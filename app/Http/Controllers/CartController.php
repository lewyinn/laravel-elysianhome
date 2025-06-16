<?php
namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CartController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = Auth::user();

        if ($user->role === 'admin') {
            return redirect('/')->with('error', 'Kamu Adalah Admin, Jangan Ke Keranjang.');
        }

        $cart = Cart::where('user_id', $user->id)->first();

        if (!$cart) {
            return view('fe.cart.index', [
                'title' => 'Cart',
                'cartItems' => [],
                'cartCount' => 0,
            ]);
        }

        $cartItems = CartItem::with('product')
            ->where('cart_id', $cart->id)
            ->get();

        $cartCount = $cartItems->sum('quantity');

        return view('fe.cart.index', [
            'title' => 'Cart',
            'cartItems' => $cartItems,
            'cartCount' => $cartCount,
        ]);
    }

    public function addToCart(Request $request)
    {
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu untuk menambahkan ke keranjang.');
        }

        $user = Auth::user();

        if ($user->role !== 'user') {
            return redirect('/')->with('error', 'Hanya user biasa yang dapat menambahkan ke keranjang.');
        }

        $productId = $request->input('product_id');
        $quantity = $request->input('quantity', 1);

        $product = Product::findOrFail($productId);

        $cart = Cart::firstOrCreate(['user_id' => $user->id]);

        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $productId)
            ->first();

        if ($cartItem) {
            $cartItem->quantity += $quantity;
            $cartItem->save();
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $productId,
                'quantity' => $quantity,
            ]);
        }

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    public function updateQuantity(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:cart_items,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = CartItem::findOrFail($request->item_id);

        if ($cartItem->cart->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        return response()->json(['success' => true]);
    }

    public function process(Request $request)
    {
        // Validasi user login
        if (!Auth::check()) {
            return response()->json(['error' => 'Anda harus login untuk checkout.'], 401);
        }

        $user = Auth::user();

        // Ambil cart user
        $cart = Cart::where('user_id', $user->id)->first();
        if (!$cart || $cart->items->isEmpty()) {
            return response()->json(['error' => 'Keranjang belanja kosong.'], 400);
        }

        // Hitung total belanja
        $total = $cart->items->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        if ($total <= 0) {
            return response()->json(['error' => 'Total pembayaran tidak valid.'], 400);
        }

        // Siapkan item details untuk Midtrans
        $item_details = $cart->items->map(function ($item) {
            return [
                'id' => $item->product->id,
                'price' => (int) $item->product->price,
                'quantity' => $item->quantity,
                'name' => $item->product->name,
            ];
        })->toArray();

        // Buat order_id unik
        $order_id = 'ORD-' . now()->format('YmdHis') . '-' . strtoupper(Str::random(6));

        // Siapkan parameter Midtrans
        $params = [
            'transaction_details' => [
                'order_id' => $order_id,
                'gross_amount' => (int) $total,
            ],
            'customer_details' => [
                'first_name' => $user->name,
                'email' => $user->email,
            ],
            'item_details' => $item_details,
        ];

        // Set konfigurasi Midtrans
        \Midtrans\Config::$serverKey = config('midtrans.serverKey');
        \Midtrans\Config::$isProduction = config('midtrans.isProduction', false);
        \Midtrans\Config::$clientKey = config('midtrans.clientKey');

        try {
            // Dapatkan Snap Token dari Midtrans
            $snapToken = \Midtrans\Snap::getSnapToken($params);

            // Simpan order ke database setelah SnapToken didapat
            $order = Order::create([
                'user_id'      => $user->id,
                'order_number' => $order_id,
                'total_price'  => $total,
                'status'       => 'pending',
                'shipping_address' => 'Default Address', // Ganti dengan alamat pengiriman yang sesuai
                'snap_token'   => $snapToken,
            ]);

            foreach ($cart->items as $cartItem) {
                $order->orderItems()->create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->product->price,
                ]);
            }

            return response()->json([
                'success'    => true,
                'snap_token' => $snapToken,
                'order_id'   => $order->id,
            ]);
        } catch (\Exception $e) {
            \Log::error('Midtrans error: ' . $e->getMessage());
            \Log::error('Midtrans params:', $params);
            return response()->json([
                'error' => 'Gagal membuat pembayaran: ' . $e->getMessage()
            ], 500);
        }
    }

    public function paymentSuccess(Request $request)
    {
        $user = auth()->user();

        $orderId = $request->input('order_id');
        $paymentType = $request->input('payment_type', 'midtrans');

        $order = Order::where('id', $orderId)
                    ->where('user_id', $user->id)
                    ->latest()
                    ->first();

        if ($order) {
            $order->payment_method = $paymentType;
            $order->status = 'paid';
            $order->save();
            if ($user->cart) {
                $user->cart->items()->delete();
            }
        } else {
            return response()->json(['error' => 'Order tidak ditemukan.'], 404);
        }

        $cartCount = $user->cart ? $user->cart->items()->sum('quantity') : 0;

        return view('fe.checkoutfinal.index', [
            'title' => 'CheckoutFinal',
            'order' => $order,
            'cartCount' => $cartCount,
        ]);
    }

    public function paymentFailed(Request $request)
    {
        $orderId = $request->order_id;
        $order = Order::find($orderId);

        if ($order) {
            $order->status = 'cancelled';
            $order->save();
        }

        return redirect()->route('cart.index')
            ->with('error', 'Pembayaran gagal atau dibatalkan. Silakan coba lagi.');
    }

    public function destroy(string $id)
    {
        $item = CartItem::findOrFail($id);

        if ($item->cart->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Tidak diizinkan.');
        }

        $item->delete();

        return redirect()->back()->with('success', 'Item berhasil dihapus dari keranjang.');
    }
}

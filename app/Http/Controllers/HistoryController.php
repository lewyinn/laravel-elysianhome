<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Spatie\Browsershot\Browsershot;

class HistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $cartCount = 0;

        if ($user) {
            $cart = Cart::where('user_id', $user->id)->first();
            if ($cart) {
                $cartCount = $cart->items()->sum('quantity');
            }
        }

        // Ambil semua order user + relasi item dan produk
        $orders = Order::with(['orderItems.product'])
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        return view('fe.history.index', [
            'title' => 'History',
            'cartCount' => $cartCount,
            'orders' => $orders,
        ]);
    }

    /**
     * Process payment for an existing order using Midtrans.
     */
    public function payOrder(Request $request, $orderId)
    {
        // Validasi user login
        if (!Auth::check()) {
            return response()->json(['error' => 'Anda harus login untuk melakukan pembayaran.'], 401);
        }

        $user = auth()->user();

        // Ambil order berdasarkan ID dan user
        $order = Order::with('orderItems.product')
            ->where('id', $orderId)
            ->where('user_id', $user->id)
            ->where('status', 'pending')
            ->first();

        if (!$order) {
            return response()->json(['error' => 'Order tidak ditemukan atau tidak dapat diproses.'], 404);
        }

        // Siapkan item details untuk Midtrans
        $item_details = $order->orderItems->map(function ($item) {
            return [
                'id' => $item->product->id,
                'price' => (int) $item->price,
                'quantity' => $item->quantity,
                'name' => $item->product->name,
            ];
        })->toArray();

        if (empty($item_details)) {
            return response()->json(['error' => 'Order tidak memiliki item.'], 400);
        }

        // Buat order_id unik untuk Midtrans (gunakan order->id atau order_number)
        $order_id = 'ORD-' . $order->id . '-' . now()->format('YmdHis') . '-' . strtoupper(Str::random(6));

        if ($order->total_price < 1) {
            return response()->json(['error' => 'Total harga order tidak valid.'], 400);
        }

        // Siapkan parameter Midtrans
        $params = [
            'transaction_details' => [
                'order_id' => $order_id,
                'gross_amount' => $order->total_price,
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

            // Update order dengan snap token
            $order->snap_token = $snapToken;
            $order->order_number = $order_id; // Update order_number jika diperlukan
            $order->save();

            return response()->json([
                'success' => true,
                'snap_token' => $snapToken,
                'order_id' => $order->id,
            ]);
        } catch (\Exception $e) {
            \Log::error('Midtrans error: ' . $e->getMessage());
            \Log::error('Midtrans params:', $params);
            return response()->json([
                'error' => 'Gagal memproses pembayaran: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Handle successful payment.
     */
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

    /**
     * Handle failed payment.
     */
    public function paymentFailed(Request $request)
    {
        $orderId = $request->input('order_id');
        $order = Order::find($orderId);

        if ($order) {
            $order->status = 'cancelled';
            $order->save();
        }

        return redirect()->route('history.index')
            ->with('error', 'Pembayaran Gagal atau dibatalkan. Silakan coba order Ulang.');
    }

    /**
     * Print invoice for a specific order.
     */
    public function printInvoice($orderId)
    {
       $order = Order::with('items.product')->findOrFail($orderId); // pastikan pakai with relasi

        $pdf = Browsershot::html(view('invoice.index', compact('order'))->render())
            ->format('A4')
            ->margins(10, 10, 10, 10)
            ->showBackground()
            ->waitUntilNetworkIdle()
            ->pdf();

        return response($pdf)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="invoice.pdf"');
    }
}

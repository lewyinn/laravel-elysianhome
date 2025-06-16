<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutFinalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $user = Auth::user();

        // // // Ambil order dengan status pending
        // // $order = Order::with('items.product')
        // //     ->where('user_id', $user->id)
        // //     ->where('status', 'pending')
        // //     ->latest()
        // //     ->first();

        // // // Jika order ditemukan, ubah status menjadi complete
        // // if ($order) {
        // //     $order->status = 'completed';
        // //     $order->save();
        // // }

        // // // Hitung total item di cart
        // // $cartCount = $user->cart ? $user->cart->items()->sum('quantity') : 0;

        // return view('fe.checkoutfinal.index', [
        //     'title' => 'CheckoutFinal',
        //     // 'cartCount' => $cartCount,
        //     // 'order' => $order,
        // ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

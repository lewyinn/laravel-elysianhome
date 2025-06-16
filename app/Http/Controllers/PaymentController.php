<?php

namespace App\Http\Controllers;

use Midtrans\Config;
use Midtrans\Snap;
use Illuminate\Http\Request;
use App\Models\Order;

class PaymentController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = false; // Ubah ke true di production
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function midtrans(Order $order)
    {
        $params = [
            'transaction_details' => [
                'order_id' => $order->order_number,
                'gross_amount' => $order->total,
            ],
            'customer_details' => [
                'first_name' => $order->user->name,
                'email' => $order->user->email,
                'phone' => $order->user->phone ?? '',
                'address' => $order->shipping_address,
            ],
        ];

        $snapToken = Snap::getSnapToken($params);

        return view('payment.midtrans', compact('order', 'snapToken'));
    }

    public function callback(Request $request)
    {
        $notif = new \Midtrans\Notification();

        $order = Order::where('order_number', $notif->order_id)->first();

        if (!$order) {
            abort(404);
        }

        // Contoh update status
        if ($notif->transaction_status == 'capture' || $notif->transaction_status == 'settlement') {
            $order->status = 'completed';
            $order->save();
        } elseif ($notif->transaction_status == 'cancel' || $notif->transaction_status == 'deny' || $notif->transaction_status == 'expire') {
            $order->status = 'failed';
            $order->save();
        }

        return response()->json(['status' => 'ok']);
    }
}

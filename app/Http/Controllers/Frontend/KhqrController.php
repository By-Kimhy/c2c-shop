<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class KhqrController extends Controller
{
    public function show($order_number)
    {
        $order = Order::where('order_number',$order_number)->firstOrFail();
        $payload = app(KhqrService::class)->makePayload($order);
        $qr = app(KhqrService::class)->qrSvgDataUri($payload);
        return view('frontend.payment.khqr', compact('order','qr','payload'));
    }

    // callback endpoint from KHQR provider (or webhook emulator)
    public function callback(Request $request)
    {
        if(!app(KhqrService::class)->validateCallback($request)){
            return response()->json(['error'=>'invalid token'],403);
        }
        $ref = $request->input('reference');
        $status = $request->input('status','confirmed');
        $order = Order::where('order_number',$ref)->first();
        if(!$order) return response()->json(['error'=>'order_not_found'],404);

        $payment = $order->payment()->first();
        $payment->status = $status === 'confirmed' ? 'confirmed' : 'failed';
        $payment->provider_ref = $request->input('provider_ref');
        $payment->payload = $request->all();
        $payment->save();

        if($payment->status === 'confirmed'){
            $order->status = 'paid';
            $order->payment_ref = $payment->provider_ref;
            $order->save();
        }

        return response()->json(['ok'=>true]);
    }
}




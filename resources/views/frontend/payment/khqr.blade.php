@extends('frontend.layouts.app')
@section('content')
<h3>Pay Order {{ $order->order_number }}</h3>
<p>Total: {{ number_format($order->total) }} KHR</p>
<img src="{{ $qr }}" alt="KHQR">
<p>Scan this QR with KHQR-supporting app. When payment confirmed, provider should call callback to update order.</p>
@endsection

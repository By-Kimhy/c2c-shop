@extends('frontend.layout.master')
@section('content')

<!-- Start Banner Area -->
<section class="banner-area organic-breadcrumb">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
            <div class="col-first">
                <h1>Shopping Cart</h1>
                <nav class="d-flex align-items-center">
                    <a href="index.html">Home<span class="lnr lnr-arrow-right"></span></a>
                    <a href="category.html">Cart</a>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- End Banner Area -->

<section class="banner-area organic-breadcrumb">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
            <div class="col-first">
                <h1>Payment (KHQR)</h1>
                <nav class="d-flex align-items-center">
                    <a href="{{ route('home') }}">Home<span class="lnr lnr-arrow-right"></span></a>
                    <a href="{{ route('checkout') }}">Checkout</a>
                </nav>
            </div>
        </div>
    </div>
</section>

<div class="container py-4">
    <h3>Scan QR to pay</h3>
    <div class="card p-4">
        <div class="row">
            <div class="col-md-6">
                <p>Order: <strong>{{ $order->order_number ?? $order->id }}</strong></p>
                <p>Amount: <strong>{{ number_format($order->total,2) }} $</strong></p>
                @if($payment)
                    <p>Payment ref: <strong>{{ $payment->provider_ref }}</strong></p>
                @endif
            </div>

            <div class="col-md-6 text-center">
                @if(!empty($qrDataUri))
                    {{-- if data URI (starts with data:) or external URL (https://...) --}}
                    <img src="{{ $qrDataUri }}" alt="KHQR" style="max-width:320px;">
                    <div class="mt-2">
                        <a href="{{ $qrDataUri }}" target="_blank" class="btn btn-sm btn-outline-secondary">Open image</a>
                    </div>
                @elseif(!empty($payload))
                    <p class="text-muted small">QR payload (no image generated):</p>
                    <pre style="white-space:pre-wrap; word-break:break-word;">{{ $payload }}</pre>
                    <p class="mt-2 text-muted">You can copy the payload into a QR generator or use the "Open image" button once image appears.</p>
                @else
                    <div class="alert alert-warning">No QR available for this order.</div>
                @endif
            </div>
        </div>

        <div class="mt-3">
            <a href="{{ route('home') }}" class="btn btn-link">Back to home</a>
            <a href="{{ url('/seller/orders/'.$order->id) }}" class="btn btn-outline-secondary">View order</a>
        </div>
    </div>
</div>
@endsection

@extends('frontend.layout.master')

@section('content')


<!-- Start Banner Area -->
<section class="banner-area organic-breadcrumb">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
            <div class="col-first">
                <h1>ប្រភេទផលិតផល</h1>
                <nav class="d-flex align-items-center">
                    <a href="index.php">ទំព័រដើម<span class="lnr lnr-arrow-right"></span></a>
                    <a href="#">ហាង<span class="lnr lnr-arrow-right"></span></a>
                    <a href="#">ប្រភេទ</a>
                </nav>
            </div>
        </div>
    </div>
</section>

<div class="container py-4">
    <h3>Order #{{ $order->order_number ?? $order->id }}</h3>

    <div class="mb-3">
        <strong>Status:</strong> {{ ucfirst($order->status) }}
        <br>
        <strong>Total:</strong> {{ number_format($order->total ?? $order->subtotal ?? 0, 2) }} {{ $order->currency ?? 'KHR' }}
    </div>

    <h5>Items</h5>
    <ul class="list-group mb-3">
        @foreach($order->items as $item)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <div>
                    <strong>{{ $item->name }}</strong><br>
                    <small class="text-muted">Qty: {{ $item->quantity }}</small>
                </div>
                <div>{{ number_format($item->line_total, 2) }} {{ $order->currency ?? 'KHR' }}</div>
            </li>
        @endforeach
    </ul>

    @if($order->payments->count())
        <h5>Payments</h5>
        <ul class="list-group mb-3">
            @foreach($order->payments as $p)
                <li class="list-group-item">
                    <strong>{{ ucfirst($p->provider) }}</strong> — {{ number_format($p->amount, 2) }} {{ $p->currency }}
                    <div class="small text-muted">Status: {{ $p->status }} | Ref: {{ $p->provider_ref }}</div>
                </li>
            @endforeach
        </ul>
    @endif

    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">Back</a>
</div>
@endsection
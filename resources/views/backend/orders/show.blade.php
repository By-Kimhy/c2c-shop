@extends('backend.layout.master')
@section('title', 'Order Details')
@section('content')

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">

            @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Order #{{ $order->order_number ?? $order->id }}</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-secondary">← Back to Orders</a>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">

            <!-- Order summary -->
            <div class="row">
                <div class="col-md-8">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Order Information</h3>
                            <div class="card-tools">
                                <span class="badge badge-{{ $order->status=='paid' ? 'success' : ($order->status=='pending' ? 'warning' : 'secondary') }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                        </div>

                        <div class="card-body">
                            <p><strong>Order Number:</strong> {{ $order->order_number }}</p>
                            <p><strong>Placed:</strong> {{ $order->created_at->format('Y-m-d H:i') }}</p>
                            <p><strong>Buyer:</strong> {{ optional($order->user)->name ?? $order->shipping_name ?? 'Guest' }}
                                ({{ optional($order->user)->email ?? '-' }})</p>
                            <p><strong>Phone:</strong> {{ $order->shipping_phone ?? '-' }}</p>
                            <p><strong>Shipping address:</strong><br>
                                <small>{{ $order->shipping_address ?? '-' }}</small>
                            </p>

                            <hr>

                            <h5>Items</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th class="text-center">SKU/ID</th>
                                            <th class="text-center">Unit Price</th>
                                            <th class="text-center">Qty</th>
                                            <th class="text-right">Line Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($order->items as $item)
                                        <tr>
                                            <td>
                                                @if($item->product)
                                                {{ $item->product->name }}
                                                @else
                                                {{ $item->name ?? '—' }}
                                                @endif
                                            </td>
                                            <td class="text-center">{{ $item->product_id ?? '-' }}</td>
                                            <td class="text-center">{{ number_format($item->unit_price ?? 0, 2) }}</td>
                                            <td class="text-center">{{ $item->quantity ?? 1 }}</td>
                                            <td class="text-right">{{ number_format($item->line_total ?? (($item->unit_price ?? 0) * ($item->quantity ?? 1)), 2) }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>

                    <!-- Notes / invoice HTML if exists -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Invoice / Notes</h3>
                        </div>
                        <div class="card-body">
                            @if($order->invoice_html)
                            {!! $order->invoice_html !!}
                            @else
                            <p>No invoice HTML stored. You can generate one on order payment.</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Right column: totals & payment -->
                <div class="col-md-4">
                    <div class="card card-outline card-info">
                        <div class="card-header">
                            <h3 class="card-title">Payment</h3>
                        </div>
                        <div class="card-body">
                            <p><strong>Subtotal:</strong> {{ number_format($subtotal ?? 0,2) }} {{ $order->currency ?? config('app.currency','KHR') }}</p>
                            <p><strong>Shipping:</strong> {{ number_format($shipping ?? 0,2) }}</p>
                            <hr>
                            <h4 class="text-right">{{ number_format($total ?? 0,2) }} {{ $order->currency ?? config('app.currency','KHR') }}</h4>

                            <hr>
                            <h5>Payments</h5>
                            @if($order->payments && $order->payments->count())
                            <ul class="list-group">
                                @foreach($order->payments as $pay)
                                <li class="list-group-item">
                                    <strong>{{ number_format($pay->amount ?? 0,2) }}</strong>
                                    <br>
                                    <small>{{ ucfirst($pay->status ?? 'unknown') }} — {{ $pay->provider ?? '-' }} ({{ $pay->provider_ref ?? '-' }})</small>
                                </li>
                                @endforeach
                            </ul>
                            @else
                            <p>No payments recorded.</p>
                            @endif

                            <hr>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Meta</h3>
                        </div>
                        <div class="card-body">
                            <p><strong>Order ID:</strong> {{ $order->id }}</p>
                            <p><strong>Payment method:</strong> {{ $order->payment_method ?? '-' }}</p>
                            <p><strong>Payment ref:</strong> {{ $order->payment_ref ?? '-' }}</p>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </section>

    <hr>

    {{-- Status change forms --}}
    <div class="mb-3" style="text-align:center;">
        {{-- <form method="post" action="{{ route('admin.orders.update.status', $order->id) }}" style="display:inline-block;">
            @csrf
            <input type="hidden" name="status" value="paid">
            <button type="submit" class="btn btn-success btn-block" onclick="return confirm('Mark order #{{ $order->order_number ?? $order->id }} as PAID? This will create a confirmed payment if none exists.')">
                <i class="fas fa-check-circle"></i> Mark as Paid
            </button>
        </form> --}}

        <form method="post" action="{{ route('admin.orders.update.status', $order->id) }}" style="display:inline-block; margin-left:8px;">
            @csrf
            <input type="hidden" name="status" value="cancelled">
            <button type="submit" class="btn btn-danger btn-block" onclick="return confirm('Mark order #{{ $order->order_number ?? $order->id }} as CANCELLED?')">
                <i class="fas fa-times-circle"></i> Mark as Cancelled
            </button>
        </form>

        <form method="post" action="{{ route('admin.orders.update.status', $order->id) }}" style="display:inline-block; margin-left:8px;">
            @csrf
            <input type="hidden" name="status" value="pending">
            <button type="submit" class="btn btn-outline-secondary btn-block" onclick="return confirm('Set order #{{ $order->order_number ?? $order->id }} back to PENDING?')">
                <i class="fas fa-hourglass-half"></i> Set Pending
            </button>
        </form>
    </div>

</div>

@endsection

@extends('backend.layout.master')
@section('title', 'Orders')
@section('content')

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <h1 class="m-0">Orders</h1>

            <div class="d-flex">
                <form method="get" action="{{ route('admin.orders.index') }}" class="form-inline mr-2">
                    <div class="input-group">
                        <input type="search" name="q" class="form-control" placeholder="Search order number..." value="{{ request('q') }}">
                        <div class="input-group-append">
                            <button class="btn btn-secondary" type="submit">Search</button>
                        </div>
                    </div>
                </form>

                <form method="get" action="{{ route('admin.orders.index') }}" class="form-inline mr-2">
                    <input type="hidden" name="q" value="{{ request('q') }}">
                    <div class="form-group">
                        <select name="status" class="form-control" onchange="this.form.submit()">
                            <option value="">All statuses</option>
                            <option value="pending" {{ request('status')==='pending' ? 'selected' : '' }}>Pending</option>
                            <option value="paid" {{ request('status')==='paid' ? 'selected' : '' }}>Paid</option>
                            <option value="cancelled" {{ request('status')==='cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>
                </form>

                <form method="get" action="{{ route('admin.orders.index') }}" class="form-inline">
                    {{-- preserve q & status when exporting --}}
                    <input type="hidden" name="q" value="{{ request('q') }}">
                    <input type="hidden" name="status" value="{{ request('status') }}">
                    <input type="hidden" name="export" value="csv">
                    <button class="btn btn-outline-success" type="submit">Export CSV</button>
                </form>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Orders list</h3>
                </div>
                <div class="card-body p-0">
                    @if($orders->count())
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Order Number</th>
                                    <th>Buyer</th>
                                    <th>Email</th>
                                    {{-- <th>Phone</th> --}}
                                    <th class="text-center">Items</th>
                                    <th class="text-right">Total</th>
                                    <th>Status</th>
                                    <th>Placed</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td><strong>{{ $order->order_number }}</strong></td>
                                    <td>{{ optional($order->user)->name ?? $order->shipping_name ?? 'Guest' }}</td>
                                    <td>{{ optional($order->user)->email ?? '-' }}</td>
                                    {{-- <td>{{ $order->shipping_phone ?? '-' }}</td> --}}
                                    <td class="text-center">{{ $order->items->count() }}</td>
                                    <td class="text-right">{{ number_format($order->total ?? 0, 2) }} {{ $order->currency ?? config('app.currency','KHR') }}</td>
                                    <td>
                                        <span class="badge badge-{{ $order->status == 'paid' ? 'success' : ($order->status=='pending' ? 'warning' : 'secondary') }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $order->created_at?->format('Y-m-d H:i') ?? '-' }}</td>
                                    <td class="text-right">
                                        <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-primary">View</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- <div class="card-footer clearfix">
                        {{ $orders->links() }}
                    </div> --}}

                    @else
                    <div class="p-4">
                        <p>No orders found.</p>
                    </div>
                    @endif
                </div>
            </div>

        </div>
    </section>
</div>

@endsection

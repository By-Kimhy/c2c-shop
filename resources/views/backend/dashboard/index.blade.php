@extends('backend.layout.master')
@section('title','Dashboard')
@section('content')

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <h1 class="m-0">Admin Dashboard</h1>
            {{-- <div>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-primary mr-2">Orders</a>
                <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-secondary mr-2">Products</a>
                <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-secondary">Users</a>
            </div> --}}
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">

            <!-- Stat boxes -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $totalOrders }}</h3>
                            <p>Total Orders</p>
                        </div>
                        <div class="icon"><i class="fas fa-shopping-cart"></i></div>
                        <a href="{{ route('admin.orders.index') }}" class="small-box-footer">Manage orders</a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ number_format($totalRevenue,2) }}</h3>
                            <p>Total Revenue</p>
                        </div>
                        <div class="icon"><i class="fas fa-dollar-sign"></i></div>
                        <a href="{{ route('admin.payments.index') }}" class="small-box-footer">View payments</a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $totalUsers }}</h3>
                            <p>Users</p>
                        </div>
                        <div class="icon"><i class="fas fa-users"></i></div>
                        <a href="{{ route('admin.users.index') }}" class="small-box-footer">Manage users</a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $totalProducts }}</h3>
                            <p>Products</p>
                        </div>
                        <div class="icon"><i class="fas fa-box-open"></i></div>
                        <a href="{{ route('admin.products.index') }}" class="small-box-footer">Manage products</a>
                    </div>
                </div>
            </div>

            <!-- Charts and lists -->
            <div class="row">
                <section class="col-lg-7 connectedSortable">
                    {{-- <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-chart-line mr-1"></i> Revenue (last 6 months)</h3>
                        </div>
                        <div class="card-body">
                            <canvas id="revenueChart" style="height:260px"></canvas>
                        </div>
                    </div> --}}

                    <div class="card">
                        <div class="card-header"><h3 class="card-title">Recent Orders</h3></div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>Order</th>
                                            <th>Buyer</th>
                                            <th class="text-right">Total</th>
                                            <th>Status</th>
                                            <th class="text-right">Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($recentOrders as $o)
                                            <tr>
                                                <td>
                                                    <a href="{{ route('admin.orders.show', $o->id) }}">
                                                        #{{ $o->order_number ?? $o->id }}
                                                    </a>
                                                </td>
                                                <td>{{ optional($o->user)->name ?? ($o->shipping_name ?? 'Guest') }}</td>
                                                <td class="text-right">{{ number_format($o->total ?? 0,2) }} {{ $o->currency ?? config('app.currency','KHR') }}</td>
                                                <td>{{ ucfirst($o->status ?? '—') }}</td>
                                                <td class="text-right">{{ $o->created_at ? $o->created_at->format('Y-m-d H:i') : '—' }}</td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="5">No recent orders</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="col-lg-5 connectedSortable">
                    {{-- <div class="card">
                        <div class="card-header"><h3 class="card-title">Order Status</h3></div>
                        <div class="card-body">
                            <canvas id="statusChart" style="height:260px"></canvas>
                        </div>
                    </div> --}}

                    <div class="card">
                        <div class="card-header"><h3 class="card-title">Top Sellers</h3></div>
                        <div class="card-body p-0">
                            <ul class="list-group list-group-flush">
                                @forelse($topSellers as $s)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong>{{ $s->seller_name }}</strong><br>
                                            <small>{{ $s->seller_email }}</small>
                                        </div>
                                        <div class="text-right">
                                            <div>{{ number_format($s->total_sales,2) }}</div>
                                            <small class="text-muted">{{ $s->orders_count }} orders</small>
                                        </div>
                                    </li>
                                @empty
                                    <li class="list-group-item">No seller sales data yet.</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header"><h3 class="card-title">Recent Users</h3></div>
                        <div class="card-body p-0">
                            <ul class="list-group list-group-flush">
                                @forelse($recentUsers as $u)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong>{{ $u->name }}</strong><br>
                                            <small>{{ $u->email }}</small>
                                        </div>
                                        <div class="text-right"><small>{{ $u->created_at ? $u->created_at->format('Y-m-d') : '—' }}</small></div>
                                    </li>
                                @empty
                                    <li class="list-group-item">No users yet.</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </section>
            </div>

        </div>
    </section>
</div>

@endsection

@section('scripts')
<!-- Chart.js CDN (if your layout already loads Chart.js remove this) -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
(function(){
    const months = {!! json_encode($months) !!};
    const revenueData = {!! json_encode($revenueData) !!};

    // Revenue line chart
    const ctx = document.getElementById('revenueChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: months,
            datasets: [{
                label: 'Revenue',
                data: revenueData,
                fill: true,
                tension: 0.3,
                pointRadius: 4
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true } }
        }
    });

    // Order status donut
    const statusCtx = document.getElementById('statusChart').getContext('2d');
    new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: ['Pending','Paid','Cancelled'],
            datasets: [{
                data: [{{ $pendingOrders }}, {{ $paidOrders }}, {{ $cancelledOrders }}]
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'bottom' } }
        }
    });
})();
</script>
@endsection

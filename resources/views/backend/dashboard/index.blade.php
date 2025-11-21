@extends('backend.layout.master')
@section('title', 'Dashboard')
@section('d_menu-open', 'menu-open')
@section('d_active', 'active')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">C2C Shop — Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <!-- New Orders -->
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $newOrdersCount ?? 0 }}</h3>
                            <p>New Orders (today)</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="{{ route('admin.orders.index') }}" class="small-box-footer">Orders <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <!-- Bounce Rate -->
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $bounceRate ?? 0 }}<sup style="font-size: 20px">%</sup></h3>
                            <p>Bounce Rate</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="#" class="small-box-footer">Analytics <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <!-- User Registrations -->
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $userRegistrations ?? 0 }}</h3>
                            <p>User Registrations (this month)</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="{{ route('admin.users.index') }}" class="small-box-footer">Users <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <!-- Unique Visitors -->
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $uniqueVisitors ?? 0 }}</h3>
                            <p>Unique Visitors</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="#" class="small-box-footer">Visitors <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
            <!-- /.row -->

            <!-- Main row -->
            <div class="row">
                <!-- Left col -->
                <section class="col-lg-7 connectedSortable">
                    <!-- Sales card (Charts) -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-chart-pie mr-1"></i>
                                Sales
                            </h3>
                            <div class="card-tools">
                                <ul class="nav nav-pills ml-auto">
                                    <li class="nav-item"><a class="nav-link active" href="#revenue-chart" data-toggle="tab">Area</a></li>
                                    <li class="nav-item"><a class="nav-link" href="#sales-chart" data-toggle="tab">Donut</a></li>
                                </ul>
                            </div>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content p-0">
                                <!-- Revenue area chart -->
                                <div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: 300px;">
                                    <canvas id="revenue-chart-canvas" height="300" style="height: 300px;"></canvas>
                                </div>
                                <!-- Sales donut -->
                                <div class="chart tab-pane" id="sales-chart" style="position: relative; height: 300px;">
                                    <canvas id="sales-chart-canvas" height="300" style="height: 300px;"></canvas>
                                </div>
                            </div>
                        </div><!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                    <!-- Recent Orders (product list) -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Recent Orders</h3>
                            <div class="card-tools">
                                <a href="{{ route('admin.orders.index') }}" class="btn btn-tool">View all</a>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <ul class="products-list product-list-in-card pl-2 pr-2">
                                @forelse($recentOrders ?? collect() as $order)
                                    <li class="item">
                                        <div class="product-img">
                                            <img src="{{ asset('backend/dist/img/default-product.png') }}" alt="Product Image" class="img-size-50">
                                        </div>
                                        <div class="product-info">
                                            <a href="{{ route('admin.orders.show', $order->id ?? '#') }}" class="product-title">#{{ $order->order_number ?? '—' }}
                                                <span class="badge badge-warning float-right">{{ number_format($order->total ?? 0, 2) }} {{ $order->currency ?? config('app.currency', 'KHR') }}</span>
                                            </a>
                                            <span class="product-description">
                                                {{ optional($order->user)->name ?? 'Guest' }} — {{ \Illuminate\Support\Str::limit($order->shipping_address ?? '-', 60) }}
                                            </span>
                                        </div>
                                    </li>
                                @empty
                                    <li class="item px-3 py-2">No recent orders found.</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                    <!-- /.card -->

                    <!-- Direct Chat (static placeholder for now) -->
                    <div class="card direct-chat direct-chat-primary">
                        <div class="card-header">
                            <h3 class="card-title">Direct Chat</h3>
                            <div class="card-tools">
                                <span title="3 New Messages" class="badge badge-primary">3</span>
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                <button type="button" class="btn btn-tool" title="Contacts" data-widget="chat-pane-toggle"><i class="fas fa-comments"></i></button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Conversations loaded here (kept static for testing) -->
                            <div class="direct-chat-messages">
                                <div class="direct-chat-msg">
                                    <div class="direct-chat-infos clearfix">
                                        <span class="direct-chat-name float-left">Alexander Pierce</span>
                                        <span class="direct-chat-timestamp float-right">23 Jan 2:00 pm</span>
                                    </div>
                                    <img class="direct-chat-img" src="{{ asset('backend/dist/img/user1-128x128.jpg') }}" alt="message user image">
                                    <div class="direct-chat-text">Is this template really for free? That's unbelievable!</div>
                                </div>
                                <div class="direct-chat-msg right">
                                    <div class="direct-chat-infos clearfix">
                                        <span class="direct-chat-name float-right">Sarah Bullock</span>
                                        <span class="direct-chat-timestamp float-left">23 Jan 2:05 pm</span>
                                    </div>
                                    <img class="direct-chat-img" src="{{ asset('backend/dist/img/user3-128x128.jpg') }}" alt="message user image">
                                    <div class="direct-chat-text">You better believe it!</div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <form action="#" method="post">
                                <div class="input-group">
                                    <input type="text" name="message" placeholder="Type Message ..." class="form-control">
                                    <span class="input-group-append">
                                        <button type="button" class="btn btn-primary">Send</button>
                                    </span>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /.direct-chat -->

                    <!-- TO DO List (static placeholder) -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><i class="ion ion-clipboard mr-1"></i>To Do List</h3>
                        </div>
                        <div class="card-body">
                            <ul class="todo-list" data-widget="todo-list">
                                <li>
                                    <span class="handle"><i class="fas fa-ellipsis-v"></i><i class="fas fa-ellipsis-v"></i></span>
                                    <div class="icheck-primary d-inline ml-2">
                                        <input type="checkbox" value="" name="todo1" id="todoCheck1">
                                        <label for="todoCheck1"></label>
                                    </div>
                                    <span class="text">Design a C2C-friendly dashboard</span>
                                    <small class="badge badge-danger"><i class="far fa-clock"></i> 2 mins</small>
                                    <div class="tools"><i class="fas fa-edit"></i><i class="fas fa-trash-o"></i></div>
                                </li>
                                <!-- more static items... -->
                            </ul>
                        </div>
                        <div class="card-footer clearfix">
                            <button type="button" class="btn btn-primary float-right"><i class="fas fa-plus"></i> Add item</button>
                        </div>
                    </div>
                    <!-- /.card -->
                </section>
                <!-- /.Left col -->

                <!-- Right col -->
                <section class="col-lg-5 connectedSortable">
                    <!-- Visitors map card (placeholder) -->
                    <div class="card bg-gradient-primary">
                        <div class="card-header border-0">
                            <h3 class="card-title"><i class="fas fa-map-marker-alt mr-1"></i> Visitors</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-primary btn-sm daterange" title="Date range"><i class="far fa-calendar-alt"></i></button>
                                <button type="button" class="btn btn-primary btn-sm" data-card-widget="collapse" title="Collapse"><i class="fas fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="world-map" style="height: 250px; width: 100%;"></div>
                        </div>
                        <div class="card-footer bg-transparent">
                            <div class="row">
                                <div class="col-4 text-center">
                                    <div id="sparkline-1"></div>
                                    <div class="text-white">Visitors</div>
                                </div>
                                <div class="col-4 text-center">
                                    <div id="sparkline-2"></div>
                                    <div class="text-white">Online</div>
                                </div>
                                <div class="col-4 text-center">
                                    <div id="sparkline-3"></div>
                                    <div class="text-white">Sales</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card -->

                    <!-- Products & Sales summary -->
                    <div class="card bg-gradient-info">
                        <div class="card-header border-0">
                            <h3 class="card-title"><i class="fas fa-th mr-1"></i> Catalog & Sales</h3>
                            <div class="card-tools">
                                <button type="button" class="btn bg-info btn-sm" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                <button type="button" class="btn bg-info btn-sm" data-card-widget="remove"><i class="fas fa-times"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-success"><i class="fas fa-box-open"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Total Products</span>
                                    <span class="info-box-number">{{ $totalProducts ?? 0 }}</span>
                                </div>
                            </div>

                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-warning"><i class="fas fa-tag"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Published</span>
                                    <span class="info-box-number">{{ $publishedProducts ?? 0 }}</span>
                                </div>
                            </div>

                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-primary"><i class="fas fa-users"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Sellers</span>
                                    <span class="info-box-number">{{ $sellersCount ?? 0 }}</span>
                                </div>
                            </div>

                            <div class="info-box">
                                <span class="info-box-icon bg-danger"><i class="fas fa-dollar-sign"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Monthly Revenue</span>
                                    <span class="info-box-number">{{ number_format($monthlyRevenue ?? 0, 2) }} {{ config('app.currency','KHR') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent">
                            <div class="row">
                                <div class="col-4 text-center">
                                    <input type="text" class="knob" data-readonly="true" value="{{ $pendingOrders ?? 0 }}" data-width="60" data-height="60" data-fgColor="#39CCCC">
                                    <div class="text-white">Pending</div>
                                </div>
                                <div class="col-4 text-center">
                                    <input type="text" class="knob" data-readonly="true" value="{{ $paidOrders ?? 0 }}" data-width="60" data-height="60" data-fgColor="#39CCCC">
                                    <div class="text-white">Paid</div>
                                </div>
                                <div class="col-4 text-center">
                                    <input type="text" class="knob" data-readonly="true" value="{{ $totalProducts ?? 0 }}" data-width="60" data-height="60" data-fgColor="#39CCCC">
                                    <div class="text-white">Products</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card -->

                    <!-- Calendar -->
                    <div class="card bg-gradient-success">
                        <div class="card-header border-0">
                            <h3 class="card-title"><i class="far fa-calendar-alt"></i> Calendar</h3>
                            <div class="card-tools">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown" data-offset="-52"><i class="fas fa-bars"></i></button>
                                    <div class="dropdown-menu" role="menu">
                                        <a href="#" class="dropdown-item">Add new event</a>
                                        <a href="#" class="dropdown-item">Clear events</a>
                                        <div class="dropdown-divider"></div>
                                        <a href="#" class="dropdown-item">View calendar</a>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-success btn-sm" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                <button type="button" class="btn btn-success btn-sm" data-card-widget="remove"><i class="fas fa-times"></i></button>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div id="calendar" style="width: 100%"></div>
                        </div>
                    </div>
                    <!-- /.card -->
                </section>
                <!-- /.right col -->
            </div>
            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
@endsection

{{-- Scripts for charts --}}
@section('scripts')
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // prepare data (fallback safe defaults)
    const labels = {!! json_encode($labels ?? []) !!};
    const values = {!! json_encode($values ?? []) !!};

    // Revenue (line)
    const revCtx = document.getElementById('revenue-chart-canvas')?.getContext('2d');
    if (revCtx) {
        new Chart(revCtx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Revenue ({{ config("app.currency", "KHR") }})',
                    data: values,
                    fill: true,
                    tension: 0.3,
                    pointRadius: 3,
                }]
            },
            options: {
                responsive: true,
                scales: { y: { beginAtZero: true } }
            }
        });
    }

    // Donut (sales breakdown placeholder using paidOrders, totalProducts, sellersCount)
    const donutCtx = document.getElementById('sales-chart-canvas')?.getContext('2d');
    if (donutCtx) {
        new Chart(donutCtx, {
            type: 'doughnut',
            data: {
                labels: ['Paid Orders','Products','Sellers'],
                datasets: [{
                    data: [
                        {{ $paidOrders ?? 0 }},
                        {{ $totalProducts ?? 0 }},
                        {{ $sellersCount ?? 0 }}
                    ]
                }]
            },
            options: { responsive: true }
        });
    }
});
</script>
@endsection

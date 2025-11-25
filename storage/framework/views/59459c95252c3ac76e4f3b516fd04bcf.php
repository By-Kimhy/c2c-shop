<?php $__env->startSection('title','Dashboard'); ?>
<?php $__env->startSection('content'); ?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <h1 class="m-0">Admin Dashboard</h1>
            
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">

            <!-- Stat boxes -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3><?php echo e($totalOrders); ?></h3>
                            <p>Total Orders</p>
                        </div>
                        <div class="icon"><i class="fas fa-shopping-cart"></i></div>
                        <a href="<?php echo e(route('admin.orders.index')); ?>" class="small-box-footer">Manage orders</a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3><?php echo e(number_format($totalRevenue,2)); ?></h3>
                            <p>Total Revenue</p>
                        </div>
                        <div class="icon"><i class="fas fa-dollar-sign"></i></div>
                        <a href="<?php echo e(route('admin.payments.index')); ?>" class="small-box-footer">View payments</a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3><?php echo e($totalUsers); ?></h3>
                            <p>Users</p>
                        </div>
                        <div class="icon"><i class="fas fa-users"></i></div>
                        <a href="<?php echo e(route('admin.users.index')); ?>" class="small-box-footer">Manage users</a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3><?php echo e($totalProducts); ?></h3>
                            <p>Products</p>
                        </div>
                        <div class="icon"><i class="fas fa-box-open"></i></div>
                        <a href="<?php echo e(route('admin.products.index')); ?>" class="small-box-footer">Manage products</a>
                    </div>
                </div>
            </div>

            <!-- Charts and lists -->
            <div class="row">
                <section class="col-lg-7 connectedSortable">
                    

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
                                        <?php $__empty_1 = true; $__currentLoopData = $recentOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $o): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <tr>
                                                <td>
                                                    <a href="<?php echo e(route('admin.orders.show', $o->id)); ?>">
                                                        #<?php echo e($o->order_number ?? $o->id); ?>

                                                    </a>
                                                </td>
                                                <td><?php echo e(optional($o->user)->name ?? ($o->shipping_name ?? 'Guest')); ?></td>
                                                <td class="text-right"><?php echo e(number_format($o->total ?? 0,2)); ?> <?php echo e($o->currency ?? config('app.currency','KHR')); ?></td>
                                                <td><?php echo e(ucfirst($o->status ?? '—')); ?></td>
                                                <td class="text-right"><?php echo e($o->created_at ? $o->created_at->format('Y-m-d H:i') : '—'); ?></td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <tr><td colspan="5">No recent orders</td></tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="col-lg-5 connectedSortable">
                    

                    <div class="card">
                        <div class="card-header"><h3 class="card-title">Top Sellers</h3></div>
                        <div class="card-body p-0">
                            <ul class="list-group list-group-flush">
                                <?php $__empty_1 = true; $__currentLoopData = $topSellers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong><?php echo e($s->seller_name); ?></strong><br>
                                            <small><?php echo e($s->seller_email); ?></small>
                                        </div>
                                        <div class="text-right">
                                            <div><?php echo e(number_format($s->total_sales,2)); ?></div>
                                            <small class="text-muted"><?php echo e($s->orders_count); ?> orders</small>
                                        </div>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <li class="list-group-item">No seller sales data yet.</li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header"><h3 class="card-title">Recent Users</h3></div>
                        <div class="card-body p-0">
                            <ul class="list-group list-group-flush">
                                <?php $__empty_1 = true; $__currentLoopData = $recentUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong><?php echo e($u->name); ?></strong><br>
                                            <small><?php echo e($u->email); ?></small>
                                        </div>
                                        <div class="text-right"><small><?php echo e($u->created_at ? $u->created_at->format('Y-m-d') : '—'); ?></small></div>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <li class="list-group-item">No users yet.</li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </section>
            </div>

        </div>
    </section>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<!-- Chart.js CDN (if your layout already loads Chart.js remove this) -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
(function(){
    const months = <?php echo json_encode($months); ?>;
    const revenueData = <?php echo json_encode($revenueData); ?>;

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
                data: [<?php echo e($pendingOrders); ?>, <?php echo e($paidOrders); ?>, <?php echo e($cancelledOrders); ?>]
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'bottom' } }
        }
    });
})();
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layout.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\wamp64\www\E-commerce\c2c-shop - Copy\resources\views/backend/dashboard/index.blade.php ENDPATH**/ ?>
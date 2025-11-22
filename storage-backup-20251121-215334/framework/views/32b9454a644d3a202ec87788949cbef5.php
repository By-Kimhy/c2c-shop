
<?php $__env->startSection('title', 'Orders'); ?>
<?php $__env->startSection('content'); ?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <h1 class="m-0">Orders</h1>

            <div class="d-flex">
                <form method="get" action="<?php echo e(route('admin.orders.index')); ?>" class="form-inline mr-2">
                    <div class="input-group">
                        <input type="search" name="q" class="form-control" placeholder="Search order number..." value="<?php echo e(request('q')); ?>">
                        <div class="input-group-append">
                            <button class="btn btn-secondary" type="submit">Search</button>
                        </div>
                    </div>
                </form>

                <form method="get" action="<?php echo e(route('admin.orders.index')); ?>" class="form-inline mr-2">
                    <input type="hidden" name="q" value="<?php echo e(request('q')); ?>">
                    <div class="form-group">
                        <select name="status" class="form-control" onchange="this.form.submit()">
                            <option value="">All statuses</option>
                            <option value="pending" <?php echo e(request('status')==='pending' ? 'selected' : ''); ?>>Pending</option>
                            <option value="paid" <?php echo e(request('status')==='paid' ? 'selected' : ''); ?>>Paid</option>
                            <option value="cancelled" <?php echo e(request('status')==='cancelled' ? 'selected' : ''); ?>>Cancelled</option>
                        </select>
                    </div>
                </form>

                <form method="get" action="<?php echo e(route('admin.orders.index')); ?>" class="form-inline">
                    
                    <input type="hidden" name="q" value="<?php echo e(request('q')); ?>">
                    <input type="hidden" name="status" value="<?php echo e(request('status')); ?>">
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
                    <?php if($orders->count()): ?>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Order Number</th>
                                    <th>Buyer</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th class="text-center">Items</th>
                                    <th class="text-right">Total</th>
                                    <th>Status</th>
                                    <th>Placed</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($order->id); ?></td>
                                    <td><strong><?php echo e($order->order_number); ?></strong></td>
                                    <td><?php echo e(optional($order->user)->name ?? $order->shipping_name ?? 'Guest'); ?></td>
                                    <td><?php echo e(optional($order->user)->email ?? '-'); ?></td>
                                    <td><?php echo e($order->shipping_phone ?? '-'); ?></td>
                                    <td class="text-center"><?php echo e($order->items->count()); ?></td>
                                    <td class="text-right"><?php echo e(number_format($order->total ?? 0, 2)); ?> <?php echo e($order->currency ?? config('app.currency','KHR')); ?></td>
                                    <td>
                                        <span class="badge badge-<?php echo e($order->status == 'paid' ? 'success' : ($order->status=='pending' ? 'warning' : 'secondary')); ?>">
                                            <?php echo e(ucfirst($order->status)); ?>

                                        </span>
                                    </td>
                                    <td><?php echo e($order->created_at?->format('Y-m-d H:i') ?? '-'); ?></td>
                                    <td class="text-right">
                                        <a href="<?php echo e(route('admin.orders.show', $order->id)); ?>" class="btn btn-sm btn-primary">View</a>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="card-footer clearfix">
                        <?php echo e($orders->links()); ?>

                    </div>

                    <?php else: ?>
                    <div class="p-4">
                        <p>No orders found.</p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </section>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layout.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\wamp64\www\E-commerce\c2c-shop - Copy\resources\views/backend/orders/index.blade.php ENDPATH**/ ?>
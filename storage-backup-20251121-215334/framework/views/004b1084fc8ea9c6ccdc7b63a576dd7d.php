
<?php $__env->startSection('title', 'Order Details'); ?>
<?php $__env->startSection('content'); ?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">

            <?php if(session('success')): ?>
            <div class="alert alert-success"><?php echo e(session('success')); ?></div>
            <?php endif; ?>

            <?php if(session('error')): ?>
            <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
            <?php endif; ?>

            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Order #<?php echo e($order->order_number ?? $order->id); ?></h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="<?php echo e(route('admin.orders.index')); ?>" class="btn btn-sm btn-secondary">← Back to Orders</a>
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
                                <span class="badge badge-<?php echo e($order->status=='paid' ? 'success' : ($order->status=='pending' ? 'warning' : 'secondary')); ?>">
                                    <?php echo e(ucfirst($order->status)); ?>

                                </span>
                            </div>
                        </div>

                        <div class="card-body">
                            <p><strong>Order Number:</strong> <?php echo e($order->order_number); ?></p>
                            <p><strong>Placed:</strong> <?php echo e($order->created_at->format('Y-m-d H:i')); ?></p>
                            <p><strong>Buyer:</strong> <?php echo e(optional($order->user)->name ?? $order->shipping_name ?? 'Guest'); ?>

                                (<?php echo e(optional($order->user)->email ?? '-'); ?>)</p>
                            <p><strong>Phone:</strong> <?php echo e($order->shipping_phone ?? '-'); ?></p>
                            <p><strong>Shipping address:</strong><br>
                                <small><?php echo e($order->shipping_address ?? '-'); ?></small>
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
                                        <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td>
                                                <?php if($item->product): ?>
                                                <?php echo e($item->product->name); ?>

                                                <?php else: ?>
                                                <?php echo e($item->name ?? '—'); ?>

                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center"><?php echo e($item->product_id ?? '-'); ?></td>
                                            <td class="text-center"><?php echo e(number_format($item->unit_price ?? 0, 2)); ?></td>
                                            <td class="text-center"><?php echo e($item->quantity ?? 1); ?></td>
                                            <td class="text-right"><?php echo e(number_format($item->line_total ?? (($item->unit_price ?? 0) * ($item->quantity ?? 1)), 2)); ?></td>
                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                            <?php if($order->invoice_html): ?>
                            <?php echo $order->invoice_html; ?>

                            <?php else: ?>
                            <p>No invoice HTML stored. You can generate one on order payment.</p>
                            <?php endif; ?>
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
                            <p><strong>Subtotal:</strong> <?php echo e(number_format($subtotal ?? 0,2)); ?> <?php echo e($order->currency ?? config('app.currency','KHR')); ?></p>
                            <p><strong>Shipping:</strong> <?php echo e(number_format($shipping ?? 0,2)); ?></p>
                            <hr>
                            <h4 class="text-right"><?php echo e(number_format($total ?? 0,2)); ?> <?php echo e($order->currency ?? config('app.currency','KHR')); ?></h4>

                            <hr>
                            <h5>Payments</h5>
                            <?php if($order->payments && $order->payments->count()): ?>
                            <ul class="list-group">
                                <?php $__currentLoopData = $order->payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pay): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="list-group-item">
                                    <strong><?php echo e(number_format($pay->amount ?? 0,2)); ?></strong>
                                    <br>
                                    <small><?php echo e(ucfirst($pay->status ?? 'unknown')); ?> — <?php echo e($pay->provider ?? '-'); ?> (<?php echo e($pay->provider_ref ?? '-'); ?>)</small>
                                </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                            <?php else: ?>
                            <p>No payments recorded.</p>
                            <?php endif; ?>

                            <hr>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Meta</h3>
                        </div>
                        <div class="card-body">
                            <p><strong>Order ID:</strong> <?php echo e($order->id); ?></p>
                            <p><strong>Payment method:</strong> <?php echo e($order->payment_method ?? '-'); ?></p>
                            <p><strong>Payment ref:</strong> <?php echo e($order->payment_ref ?? '-'); ?></p>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </section>

    <hr>

    
    <div class="mb-3" style="text-align:center;">
        <form method="post" action="<?php echo e(route('admin.orders.update.status', $order->id)); ?>" style="display:inline-block;">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="status" value="paid">
            <button type="submit" class="btn btn-success btn-block" onclick="return confirm('Mark order #<?php echo e($order->order_number ?? $order->id); ?> as PAID? This will create a confirmed payment if none exists.')">
                <i class="fas fa-check-circle"></i> Mark as Paid
            </button>
        </form>

        <form method="post" action="<?php echo e(route('admin.orders.update.status', $order->id)); ?>" style="display:inline-block; margin-left:8px;">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="status" value="cancelled">
            <button type="submit" class="btn btn-danger btn-block" onclick="return confirm('Mark order #<?php echo e($order->order_number ?? $order->id); ?> as CANCELLED?')">
                <i class="fas fa-times-circle"></i> Mark as Cancelled
            </button>
        </form>

        <form method="post" action="<?php echo e(route('admin.orders.update.status', $order->id)); ?>" style="display:inline-block; margin-left:8px;">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="status" value="pending">
            <button type="submit" class="btn btn-outline-secondary btn-block" onclick="return confirm('Set order #<?php echo e($order->order_number ?? $order->id); ?> back to PENDING?')">
                <i class="fas fa-hourglass-half"></i> Set Pending
            </button>
        </form>
    </div>

</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layout.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\wamp64\www\E-commerce\c2c-shop - Copy\resources\views/backend/orders/show.blade.php ENDPATH**/ ?>
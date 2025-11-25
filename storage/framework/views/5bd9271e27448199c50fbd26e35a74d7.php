
<?php $__env->startSection('title','Payments'); ?>
<?php $__env->startSection('content'); ?>
<div class="content-wrapper">
  <div class="content-header d-flex justify-content-between align-items-center">
    <h1 class="m-0">Payments</h1>
    <div class="d-flex">
      <form method="get" action="<?php echo e(route('admin.payments.index')); ?>" class="mr-2">
        <div class="input-group">
          <input name="q" class="form-control" placeholder="Search provider/ref/id" value="<?php echo e($q ?? ''); ?>">
          <select name="status" class="form-control ml-2">
            <option value="">All statuses</option>
            <option value="pending" <?php echo e((request('status')=='pending')?'selected':''); ?>>Pending</option>
            <option value="Paid" <?php echo e((request('status')=='Paid')?'selected':''); ?>>Paid</option>
            <option value="failed" <?php echo e((request('status')=='failed')?'selected':''); ?>>Failed</option>
          </select>
          <div class="input-group-append">
            <button class="btn btn-secondary">Filter</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <?php if(session('success')): ?> <div class="alert alert-success"><?php echo e(session('success')); ?></div> <?php endif; ?>
      <?php if(session('error')): ?> <div class="alert alert-danger"><?php echo e(session('error')); ?></div> <?php endif; ?>

      <div class="card">
        <div class="card-body p-0">
          <?php if($payments->count()): ?>
            <div class="table-responsive">
              <table class="table table-hover mb-0">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Order</th>
                    <th>Amount</th>
                    <th>Provider</th>
                    <th>Provider Ref</th>
                    <th>Status</th>
                    <th class="text-right">Created</th>
                    <th class="text-right">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pay): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                      <td><?php echo e($pay->id); ?></td>
                      <td>
                        <?php if($pay->order): ?>
                          <a href="<?php echo e(route('admin.orders.show', $pay->order->id)); ?>">#<?php echo e($pay->order->order_number ?? $pay->order->id); ?></a>
                        <?php else: ?>
                          —
                        <?php endif; ?>
                      </td>
                      <td class="text-right"><?php echo e(number_format($pay->amount,2)); ?> <?php echo e($pay->currency ?? config('app.currency','KHR')); ?></td>
                      <td><?php echo e($pay->provider ?? '-'); ?></td>
                      <td><?php echo e($pay->provider_ref ?? '-'); ?></td>
                      <td><?php echo e(ucfirst($pay->status)); ?></td>
                      <td class="text-right"><?php echo e($pay->created_at->format('Y-m-d H:i')); ?></td>
                      <td class="text-right">
                        <a href="<?php echo e(route('admin.payments.show', $pay->id)); ?>" class="btn btn-sm btn-outline-primary">View</a>

                        <form action="<?php echo e(route('admin.payments.destroy', $pay->id)); ?>" method="POST" style="display:inline-block;" onsubmit="return confirm('Delete payment?');">
                          <?php echo csrf_field(); ?>
                          <?php echo method_field('DELETE'); ?>
                          <button class="btn btn-sm btn-danger">Delete</button>
                        </form>
                      </td>
                    </tr>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
              </table>
            </div>
          <?php else: ?>
            <div class="p-4">No payments found.</div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </section>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layout.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\wamp64\www\E-commerce\c2c-shop - Copy\resources\views/backend/payments/index.blade.php ENDPATH**/ ?>
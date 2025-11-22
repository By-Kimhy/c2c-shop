
<?php $__env->startSection('title','Seller Profiles'); ?>
<?php $__env->startSection('content'); ?>

<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid d-flex justify-content-between align-items-center">
      <h1 class="m-0">Seller Profiles</h1>
      <form method="get" action="<?php echo e(route('admin.seller-profiles.index')); ?>" class="form-inline">
        <div class="input-group">
          <input name="q" value="<?php echo e($q ?? ''); ?>" class="form-control" placeholder="search shop, owner">
          <div class="input-group-append">
            <button class="btn btn-secondary">Search</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <?php if(session('success')): ?> <div class="alert alert-success"><?php echo e(session('success')); ?></div> <?php endif; ?>
      <div class="card">
        <div class="card-body p-0">
          <table class="table mb-0">
            <thead>
              <tr>
                <th>ID</th><th>Shop</th><th>Owner</th><th>Status</th><th>Joined</th><th class="text-right">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php $__currentLoopData = $profiles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <tr>
                <td><?php echo e($p->id); ?></td>
                <td>
                  <strong><?php echo e($p->shop_name); ?></strong><br>
                  <a href="<?php echo e(route('shop.show', $p->slug)); ?>" target="_blank"><?php echo e(url('/shop/'.$p->slug)); ?></a>
                </td>
                <td><?php echo e($p->user->name); ?><br><small><?php echo e($p->user->email); ?></small></td>
                <td>
                  <span class="badge badge-<?php echo e($p->status === 'approved' ? 'success' : ($p->status==='pending' ? 'secondary' : 'warning')); ?>">
                    <?php echo e(ucfirst($p->status)); ?>

                  </span>
                </td>
                <td><?php echo e($p->created_at->format('Y-m-d')); ?></td>
                <td class="text-right">
                  <a href="<?php echo e(route('admin.seller-profiles.edit', $p->id)); ?>" class="btn btn-sm btn-primary">Edit</a>
                  <form action="<?php echo e(route('admin.seller-profiles.destroy', $p->id)); ?>" method="POST" style="display:inline-block" onsubmit="return confirm('Delete profile?');">
                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                    <button class="btn btn-sm btn-danger">Delete</button>
                  </form>
                </td>
              </tr>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
          </table>
        </div>
        <div class="card-footer clearfix">
          <?php echo e($profiles->links()); ?>

        </div>
      </div>
    </div>
  </section>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layout.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\wamp64\www\E-commerce\c2c-shop - Copy\resources\views/backend/sellers/profiles/index.blade.php ENDPATH**/ ?>
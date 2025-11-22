

<?php $__env->startSection('title','Categories'); ?>

<?php $__env->startSection('content'); ?>
<div class="content-wrapper">
  <div class="content-header d-flex justify-content-between align-items-center">
    <h1 class="m-0">Categories</h1>
    <div>
      <form method="get" action="<?php echo e(route('admin.categories.index')); ?>" class="d-inline-block mr-2">
        <div class="input-group">
          <input name="q" class="form-control" placeholder="Search name or slug" value="<?php echo e($q ?? ''); ?>">
          <div class="input-group-append">
            <button class="btn btn-secondary">Search</button>
          </div>
        </div>
      </form>
      <a href="<?php echo e(route('admin.categories.create')); ?>" class="btn btn-primary">Create Category</a>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
      <?php endif; ?>
      <?php if(session('error')): ?>
        <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
      <?php endif; ?>

      <div class="card">
        <div class="card-body p-0">
          <?php if($categories->count()): ?>
            <div class="table-responsive">
              <table class="table table-hover mb-0">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Products</th>
                    <th class="text-right">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                      <td><?php echo e($cat->id); ?></td>
                      <td><?php echo e($cat->name); ?></td>
                      <td><?php echo e($cat->slug); ?></td>
                      <td><?php echo e($cat->products()->count()); ?></td>
                      <td class="text-right">
                        <a href="<?php echo e(route('admin.categories.edit', $cat->id)); ?>" class="btn btn-sm btn-primary">Edit</a>

                        <form action="<?php echo e(route('admin.categories.destroy', $cat->id)); ?>" method="post" style="display:inline-block" onsubmit="return confirm('Delete category?');">
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

            <div class="card-footer clearfix">
              <?php echo e($categories->links()); ?>

            </div>
          <?php else: ?>
            <div class="p-4">No categories found.</div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </section>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layout.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\wamp64\www\E-commerce\c2c-shop - Copy\resources\views/backend/categories/index.blade.php ENDPATH**/ ?>


<?php $__env->startSection('title', ($mode === 'create' ? 'Create Category' : 'Edit Category')); ?>

<?php $__env->startSection('content'); ?>
<div class="content-wrapper">
  <div class="content-header d-flex justify-content-between align-items-center">
    <h1 class="m-0"><?php echo e($mode === 'create' ? 'Create Category' : 'Edit Category'); ?></h1>
    <a href="<?php echo e(route('admin.categories.index')); ?>" class="btn btn-secondary">Back to list</a>
  </div>

  <section class="content">
    <div class="container-fluid">
      <?php if($errors->any()): ?>
        <div class="alert alert-danger">
          <ul class="mb-0">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $err): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <li><?php echo e($err); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </ul>
        </div>
      <?php endif; ?>

      <div class="card">
        <div class="card-body">
          <?php if($mode === 'create'): ?>
            <form method="post" action="<?php echo e(route('admin.categories.store')); ?>">
          <?php else: ?>
            <form method="post" action="<?php echo e(route('admin.categories.update', $category->id)); ?>">
              <?php echo method_field('PUT'); ?>
          <?php endif; ?>
            <?php echo csrf_field(); ?>

            <div class="form-group">
              <label for="name">Name</label>
              <input id="name" name="name" class="form-control" required value="<?php echo e(old('name', $category->name)); ?>">
            </div>

            <div class="form-group">
              <label for="slug">Slug (optional)</label>
              <input id="slug" name="slug" class="form-control" value="<?php echo e(old('slug', $category->slug)); ?>">
              <small class="form-text text-muted">Leave empty to generate automatically from name.</small>
            </div>

            <div class="form-group">
              <button class="btn btn-primary"><?php echo e($mode === 'create' ? 'Create' : 'Save'); ?></button>
              <a href="<?php echo e(route('admin.categories.index')); ?>" class="btn btn-secondary">Cancel</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layout.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\wamp64\www\E-commerce\c2c-shop - Copy\resources\views/backend/categories/form.blade.php ENDPATH**/ ?>
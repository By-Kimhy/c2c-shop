
<?php $__env->startSection('title', $mode === 'create' ? 'Create Product' : 'Edit Product'); ?>
<?php $__env->startSection('content'); ?>
<div class="content-wrapper">
  <div class="content-header d-flex justify-content-between align-items-center">
    <h1 class="m-0"><?php echo e($mode === 'create' ? 'Create Product' : 'Edit Product'); ?></h1>
    <a href="<?php echo e(route('admin.products.index')); ?>" class="btn btn-secondary">Back to list</a>
  </div>

  <section class="content">
    <div class="container-fluid">
      <?php if($errors->any()): ?>
        <div class="alert alert-danger"><ul class="mb-0"><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($e); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul></div>
      <?php endif; ?>

      <div class="card">
        <div class="card-body">
          <?php if($mode === 'create'): ?>
            <form method="post" action="<?php echo e(route('admin.products.store')); ?>" enctype="multipart/form-data">
          <?php else: ?>
            <form method="post" action="<?php echo e(route('admin.products.update', $product->id)); ?>" enctype="multipart/form-data">
              <?php echo method_field('PUT'); ?>
          <?php endif; ?>
            <?php echo csrf_field(); ?>

            <div class="form-row">
              <div class="form-group col-md-6">
                <label>Product name</label>
                <input name="name" class="form-control" required value="<?php echo e(old('name', $product->name)); ?>">
              </div>

              <div class="form-group col-md-3">
                <label>Price</label>
                <input name="price" class="form-control" required value="<?php echo e(old('price', $product->price ?? 0)); ?>">
              </div>

              <div class="form-group col-md-3">
                <label>Stock</label>
                <input name="stock" class="form-control" value="<?php echo e(old('stock', $product->stock ?? 0)); ?>">
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-6">
                <label>Seller (user)</label>
                <select name="user_id" class="form-control">
                  <option value="">— none —</option>
                  <?php $__currentLoopData = $sellers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($s->id); ?>" <?php echo e((old('user_id', $product->user_id) == $s->id) ? 'selected' : ''); ?>><?php echo e($s->name); ?> (<?php echo e($s->email); ?>)</option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
              </div>

              <div class="form-group col-md-6">
                <label>Category</label>
                <select name="category_id" class="form-control">
                  <option value="">— none —</option>
                  <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($c->id); ?>" <?php echo e((old('category_id', $product->category_id) == $c->id) ? 'selected' : ''); ?>><?php echo e($c->name); ?></option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
              </div>
            </div>

            <div class="form-group">
              <label>Description</label>
              <textarea name="description" rows="6" class="form-control"><?php echo e(old('description', $product->description)); ?></textarea>
            </div>

            <div class="form-group">
              <label>Images (multiple allowed)</label>
              <input type="file" name="images[]" multiple class="form-control-file">
            </div>

            <?php if(!empty($product->images) && is_array($product->images)): ?>
              <div class="form-group">
                <label>Existing images</label>
                <div class="d-flex flex-wrap">
                  <?php $__currentLoopData = $product->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="m-1" style="position:relative">
                      <img src="<?php echo e(asset('storage/'.$img)); ?>" style="width:120px;height:80px;object-fit:cover;border-radius:4px;">
                      <div style="position:absolute;left:4px;top:4px;">
                        <label class="badge badge-danger" style="cursor:pointer;padding:4px 6px;">
                          <input type="checkbox" name="remove_images[]" value="<?php echo e($img); ?>" style="display:none;">
                          Remove
                        </label>
                      </div>
                    </div>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
              </div>
            <?php endif; ?>

            <div class="form-group">
              <label>Status</label>
              <select name="status" class="form-control">
                <option value="draft" <?php echo e(old('status', $product->status) === 'draft' ? 'selected' : ''); ?>>Draft</option>
                <option value="published" <?php echo e(old('status', $product->status) === 'published' ? 'selected' : ''); ?>>Published</option>
              </select>
            </div>

            <div class="form-group">
              <button class="btn btn-primary"><?php echo e($mode === 'create' ? 'Create' : 'Save'); ?></button>
              <a href="<?php echo e(route('admin.products.index')); ?>" class="btn btn-secondary">Cancel</a>
            </div>

          </form>
        </div>
      </div>
    </div>
  </section>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layout.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\wamp64\www\E-commerce\c2c-shop - Copy\resources\views/backend/products/form.blade.php ENDPATH**/ ?>
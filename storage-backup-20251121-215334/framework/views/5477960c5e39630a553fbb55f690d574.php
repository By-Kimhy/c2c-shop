
<?php $__env->startSection('title','Product'); ?>
<?php $__env->startSection('content'); ?>
<div class="content-wrapper">
  <div class="content-header d-flex justify-content-between align-items-center">
    <h1 class="m-0"><?php echo e($product->name); ?></h1>
    <a href="<?php echo e(route('admin.products.index')); ?>" class="btn btn-secondary">Back</a>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="card mb-3">
        <div class="card-body">
          <div class="row">
            <div class="col-md-4">
              <?php if(!empty($product->images[0])): ?>
                <img src="<?php echo e(asset('storage/'.$product->images[0])); ?>" style="width:100%;height:220px;object-fit:cover;border-radius:6px;">
              <?php endif; ?>
            </div>
            <div class="col-md-8">
              <p><strong>Price:</strong> <?php echo e(number_format($product->price,2)); ?></p>
              <p><strong>Stock:</strong> <?php echo e($product->stock); ?></p>
              <p><strong>Seller:</strong> <?php echo e(optional($product->user)->name ?? '—'); ?></p>
              <p><strong>Category:</strong> <?php echo e(optional($product->category)->name ?? '—'); ?></p>
              <hr>
              <div><?php echo nl2br(e($product->description)); ?></div>
            </div>
          </div>
        </div>
      </div>

      <?php if(!empty($product->images) && is_array($product->images)): ?>
        <div class="card">
          <div class="card-header">All images</div>
          <div class="card-body">
            <div class="d-flex flex-wrap">
              <?php $__currentLoopData = $product->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="m-1"><img src="<?php echo e(asset('storage/'.$img)); ?>" style="width:180px;height:120px;object-fit:cover;border-radius:6px;"></div>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </section>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layout.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\wamp64\www\E-commerce\c2c-shop - Copy\resources\views/backend/products/show.blade.php ENDPATH**/ ?>

<?php $__env->startSection('title','Edit Seller Profile'); ?>
<?php $__env->startSection('content'); ?>

<div class="content-wrapper">
  <div class="content-header d-flex justify-content-between align-items-center">
    <h1 class="m-0">Edit Seller Profile</h1>
    <a href="<?php echo e(route('admin.seller-profiles.index')); ?>" class="btn btn-secondary">Back</a>
  </div>

  <section class="content">
    <div class="container-fluid">

      <?php if(session('success')): ?> <div class="alert alert-success"><?php echo e(session('success')); ?></div> <?php endif; ?>
      <?php if(session('error')): ?> <div class="alert alert-danger"><?php echo e(session('error')); ?></div> <?php endif; ?>

      <?php if($errors->any()): ?>
        <div class="alert alert-danger"><ul class="mb-0"><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($e); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul></div>
      <?php endif; ?>

      <div class="card">
        <div class="card-body">

          
          <div class="mb-4">
            <h4>User</h4>

            <?php if($profile->user): ?>
              <p>
                Linked User:<br>
                <strong><?php echo e($profile->user->name); ?></strong><br>
                <small><?php echo e($profile->user->email); ?></small>
              </p>
            <?php else: ?>
              <div class="alert alert-warning">
                <strong>No user linked!</strong><br>
                You can fix it by selecting a user below.
              </div>

              
              <form method="POST" action="<?php echo e(route('admin.seller-profiles.link-user', $profile->id)); ?>" class="form-inline mb-3">
                <?php echo csrf_field(); ?>
                <div class="form-group mr-2" style="min-width:320px;">
                  <select name="user_id" class="form-control w-100" required>
                    <option value="">Choose user...</option>
                    <?php $__currentLoopData = $allUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <option value="<?php echo e($u->id); ?>"><?php echo e($u->name); ?> (<?php echo e($u->email); ?>)</option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </select>
                </div>
                <button class="btn btn-info">Link User</button>
              </form>

              <div class="text-muted small">
                If the user already has a seller profile, the system will prevent linking.
              </div>
            <?php endif; ?>
          </div>

          
          <form method="post" action="<?php echo e(route('admin.seller-profiles.update', $profile->id)); ?>" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div class="form-group">
              <label>Shop name</label>
              <input name="shop_name" class="form-control" required value="<?php echo e(old('shop_name', $profile->shop_name)); ?>">
            </div>

            <div class="form-row">
              <div class="form-group col-md-6">
                <label>Phone</label>
                <input name="phone" class="form-control" value="<?php echo e(old('phone', $profile->phone)); ?>">
              </div>
              <div class="form-group col-md-6">
                <label>Address</label>
                <input name="address" class="form-control" value="<?php echo e(old('address', $profile->address)); ?>">
              </div>
            </div>

            <div class="form-group">
              <label>Description</label>
              <textarea name="description" rows="4" class="form-control"><?php echo e(old('description', $profile->description)); ?></textarea>
            </div>

            <div class="form-row">
              <div class="form-group col-md-6">
                <label>Logo</label>
                <input type="file" name="logo" class="form-control-file">
                <?php if($profile->logo && file_exists(public_path('storage/'.$profile->logo))): ?>
                  <div class="mt-2">
                    <img src="<?php echo e(asset('storage/'.$profile->logo)); ?>" alt="logo" style="width:160px;height:80px;object-fit:cover;border-radius:4px;">
                    <div class="mt-1">
                      <label class="mr-2">Replace logo to upload new one</label>
                      
                      <button type="submit" name="remove_logo" value="1" class="btn btn-sm btn-outline-danger" onclick="return confirm('Remove existing logo?')">Remove logo</button>
                    </div>
                  </div>
                <?php endif; ?>
              </div>

              <div class="form-group col-md-6">
                <label>Banner</label>
                <input type="file" name="banner" class="form-control-file">
                <?php if($profile->banner && file_exists(public_path('storage/'.$profile->banner))): ?>
                  <div class="mt-2">
                    <img src="<?php echo e(asset('storage/'.$profile->banner)); ?>" alt="banner" style="width:240px;height:80px;object-fit:cover;border-radius:4px;">
                    <div class="mt-1">
                      <button type="submit" name="remove_banner" value="1" class="btn btn-sm btn-outline-danger" onclick="return confirm('Remove existing banner?')">Remove banner</button>
                    </div>
                  </div>
                <?php endif; ?>
              </div>
            </div>

            <div class="form-group">
              <label>Status</label>
              <select name="status" class="form-control">
                <option value="pending" <?php echo e(old('status', $profile->status) === 'pending' ? 'selected' : ''); ?>>Pending</option>
                <option value="approved" <?php echo e(old('status', $profile->status) === 'approved' ? 'selected' : ''); ?>>Approved</option>
                <option value="suspended" <?php echo e(old('status', $profile->status) === 'suspended' ? 'selected' : ''); ?>>Suspended</option>
              </select>
            </div>

            <div class="form-group">
              <button class="btn btn-primary">Save</button>
              <a href="<?php echo e(route('admin.seller-profiles.index')); ?>" class="btn btn-secondary">Cancel</a>
            </div>
          </form>

          
          <div class="mt-3">
            <form action="<?php echo e(route('admin.seller-profiles.destroy', $profile->id)); ?>" method="POST" onsubmit="return confirm('Delete this seller profile? This action cannot be undone.');">
              <?php echo csrf_field(); ?>
              <?php echo method_field('DELETE'); ?>
              <button class="btn btn-danger">Delete profile</button>
            </form>
          </div>

        </div>
      </div>

    </div>
  </section>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layout.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\wamp64\www\E-commerce\c2c-shop - Copy\resources\views/backend/sellers/profiles/edit.blade.php ENDPATH**/ ?>
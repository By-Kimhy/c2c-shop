
<?php $__env->startSection('title','Users'); ?>
<?php $__env->startSection('content'); ?>

<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid d-flex justify-content-between align-items-center">
      <h1 class="m-0">Users</h1>

      <div class="d-flex">
        <form method="get" action="<?php echo e(route('admin.users.index')); ?>" class="form-inline mr-2">
          <div class="input-group">
            <input name="q" class="form-control" placeholder="Search name or email" value="<?php echo e($q ?? ''); ?>">
            <div class="input-group-append">
              <button class="btn btn-secondary">Search</button>
            </div>
          </div>
        </form>

        <a href="<?php echo e(route('admin.users.create')); ?>" class="btn btn-primary">Create user</a>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="card">
        <div class="card-body p-0">
          <?php if($users->count()): ?>
          <div class="table-responsive">
            <table class="table table-hover mb-0">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Roles</th>
                  <th>Joined</th>
                  <th class="text-right">Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr data-user-id="<?php echo e($user->id); ?>">
                  <td><?php echo e($user->id); ?></td>
                  <td><?php echo e($user->name); ?></td>
                  <td><?php echo e($user->email); ?></td>
                  <td>
                    <?php $__currentLoopData = $user->roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <span class="badge badge-info"><?php echo e($r->name); ?></span>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </td>
                  <td><?php echo e($user->created_at ? $user->created_at->format('Y-m-d') : '-'); ?></td>
                  <td class="text-right">
                    <a href="<?php echo e(route('admin.users.show', $user->id)); ?>" class="btn btn-sm btn-outline-primary">View</a>
                    <a href="<?php echo e(route('admin.users.edit', $user->id)); ?>" class="btn btn-sm btn-primary">Edit</a>

                    <!-- AJAX Delete Button -->
                    <button class="btn btn-sm btn-danger js-delete-user" data-id="<?php echo e($user->id); ?>">
                      Delete
                    </button>
                  </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </tbody>
            </table>
          </div>

          <div class="card-footer clearfix">
            <?php echo e($users->links()); ?>

          </div>
          <?php else: ?>
          <div class="p-4">No users found.</div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </section>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layout.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\wamp64\www\E-commerce\c2c-shop - Copy\resources\views/backend/users/index.blade.php ENDPATH**/ ?>
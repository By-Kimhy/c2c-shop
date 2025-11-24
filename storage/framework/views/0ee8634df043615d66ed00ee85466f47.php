
<?php $__env->startSection('title', $mode == 'create' ? 'Create User' : 'Edit User'); ?>
<?php $__env->startSection('content'); ?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <h1 class="m-0"><?php echo e($mode == 'create' ? 'Create User' : 'Edit User'); ?></h1>
            <a href="<?php echo e(route('admin.users.index')); ?>" class="btn btn-sm btn-secondary">← Back to Users</a>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    
                    <?php if($errors->any()): ?>
                    <div class="alert alert-danger">
                        <strong>There were some problems with your input:</strong>
                        <ul class="mb-0 mt-2">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                    <?php endif; ?>

                    
                    <?php if(session('success')): ?>
                    <div class="alert alert-success"><?php echo e(session('success')); ?></div>
                    <?php endif; ?>
                    <?php if(session('error')): ?>
                    <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
                    <?php endif; ?>

                    <?php if($mode=='create'): ?>
                    <form method="post" action="<?php echo e(route('admin.users.store')); ?>">
                        <?php else: ?>
                        <form method="post" action="<?php echo e(route('admin.users.update', $user->id)); ?>">
                            <?php echo method_field('PUT'); ?>
                            <?php endif; ?>
                            <?php echo csrf_field(); ?>

                            <div class="form-group">
                                <label>Name</label>
                                <input name="name" class="form-control" value="<?php echo e(old('name', $user->name)); ?>" required>
                            </div>

                            <div class="form-group">
                                <label>Email</label>
                                <input name="email" type="email" class="form-control" value="<?php echo e(old('email', $user->email)); ?>" required>
                            </div>

                            <div class="form-group">
                                <label>Password <?php echo e($mode=='edit' ? '(leave blank to keep current)' : ''); ?></label>
                                <input name="password" type="password" class="form-control" <?php echo e($mode=='create' ? 'required' : ''); ?>>
                            </div>

                            <div class="form-group">
                                <label>Confirm Password</label>
                                <input name="password_confirmation" type="password" class="form-control" <?php echo e($mode=='create' ? 'required' : ''); ?>>
                            </div>

                            <div class="form-group">
                                <label>Roles</label>
                                <select name="roles[]" class="form-control" multiple>
                                    <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($role->id); ?>" <?php echo e(in_array($role->id, old('roles', $user->roles->pluck('id')->toArray() ?? [])) ? 'selected' : ''); ?>>
                                        <?php echo e($role->name); ?>

                                    </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <small class="form-text text-muted">Hold Ctrl/Cmd to select multiple roles.</small>
                            </div>

                            <button class="btn btn-primary" type="submit"><?php echo e($mode=='create' ? 'Create' : 'Update'); ?></button>
                        </form>
                </div>
            </div>
        </div>
    </section>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layout.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\wamp64\www\E-commerce\c2c-shop - Copy\resources\views/backend/users/form.blade.php ENDPATH**/ ?>
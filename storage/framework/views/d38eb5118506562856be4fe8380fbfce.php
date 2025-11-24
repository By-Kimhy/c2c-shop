
<?php $__env->startSection('title', 'Seller Profiles'); ?>
<?php $__env->startSection('content'); ?>

<div class="content-wrapper">
    <div class="content-header d-flex justify-content-between align-items-center">
        <h1 class="m-0">Seller Profiles</h1>

        <div class="d-flex">
            <form method="get" action="<?php echo e(route('admin.seller-profiles.index')); ?>" class="form-inline mr-2">
                <div class="input-group">
                    <input name="q" class="form-control" placeholder="Search shop name or slug" value="<?php echo e($q ?? ''); ?>">
                    <div class="input-group-append">
                        <button class="btn btn-secondary">Search</button>
                    </div>
                </div>
            </form>

            <form method="get" action="<?php echo e(route('admin.seller-profiles.index')); ?>" class="form-inline">
                <select name="status" class="form-control" onchange="this.form.submit()">
                    <option value="">All statuses</option>
                    <option value="pending" <?php echo e((request('status')=='pending') ? 'selected' : ''); ?>>Pending</option>
                    <option value="approved" <?php echo e((request('status')=='approved') ? 'selected' : ''); ?>>Approved</option>
                    <option value="suspended" <?php echo e((request('status')=='suspended') ? 'selected' : ''); ?>>Suspended</option>
                </select>
            </form>

            <form action="<?php echo e(route('admin.seller-profiles.fix-missing')); ?>" method="POST" class="ml-2">
                <?php echo csrf_field(); ?>
                <button class="btn btn-warning" onclick="return confirm('Run fix? This will create profiles for seller-role users who are missing profiles.')">
                    Fix Missing Profiles
                </button>
            </form>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">

            <?php if(session('success')): ?> <div class="alert alert-success"><?php echo e(session('success')); ?></div> <?php endif; ?>
            <?php if(session('error')): ?> <div class="alert alert-danger"><?php echo e(session('error')); ?></div> <?php endif; ?>

            <div class="card">
                <div class="card-body p-0">
                    <?php if($profiles->count()): ?>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Logo</th>
                                    <th>Shop Name</th>
                                    <th>User</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th class="text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $profiles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $profile): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($profile->id); ?></td>

                                    <td style="width:100px">
                                        <?php if($profile->logo && file_exists(public_path('storage/'.$profile->logo))): ?>
                                        <img src="<?php echo e(asset('storage/'.$profile->logo)); ?>" alt="logo" style="width:72px;height:48px;object-fit:cover;border-radius:4px;">
                                        <?php else: ?>
                                        <div style="width:72px;height:48px;background:#f0f0f0;border-radius:4px;"></div>
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <strong><?php echo e($profile->shop_name); ?></strong><br>
                                        <small class="text-muted"><?php echo e($profile->slug); ?></small>
                                        <?php if(empty($profile->shop_name)): ?>
                                        <div class="text-danger small">Missing shop name</div>
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <?php if($profile->user): ?>
                                        <?php echo e($profile->user->name); ?><br>
                                        <small class="text-muted"><?php echo e($profile->user->email); ?></small>
                                        <?php else: ?>
                                        <em class="text-warning">No user linked</em>
                                        <div class="small text-muted">This seller role exists in pivot but no profile user found.</div>
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <span class="badge badge-<?php echo e($profile->status === 'approved' ? 'success' : ($profile->status === 'pending' ? 'warning' : 'secondary')); ?>">
                                            <?php echo e(ucfirst($profile->status)); ?>

                                        </span>
                                    </td>

                                    <td><?php echo e(optional($profile->created_at)->format('Y-m-d')); ?></td>

                                    <td class="text-right">
                                        <a href="<?php echo e(route('admin.seller-profiles.edit', $profile->id)); ?>" class="btn btn-sm btn-primary">Edit</a>

                                        <?php if(!empty($profile->slug)): ?>
                                        <a href="<?php echo e(route('shop.show', $profile->slug)); ?>" class="btn btn-sm btn-info" target="_blank">View shop</a>
                                        <?php endif; ?>

                                        <form action="<?php echo e(route('admin.seller-profiles.destroy', $profile->id)); ?>" method="POST" style="display:inline-block" onsubmit="return confirm('Delete this seller profile? This cannot be undone.');">
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
                        <?php echo e($profiles->withQueryString()->links()); ?>

                    </div>
                    <?php else: ?>
                    <div class="p-4">No seller profiles found.</div>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </section>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layout.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\wamp64\www\E-commerce\c2c-shop - Copy\resources\views/backend/sellers/profiles/index.blade.php ENDPATH**/ ?>
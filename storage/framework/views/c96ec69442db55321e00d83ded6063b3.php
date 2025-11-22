
<?php $__env->startSection('title','Products'); ?>
<?php $__env->startSection('content'); ?>
<div class="content-wrapper">
    <div class="content-header d-flex justify-content-between align-items-center">
        <h1 class="m-0">Products</h1>
        <div>
            <form method="get" action="<?php echo e(route('admin.products.index')); ?>" class="d-inline-block mr-2">
                <div class="input-group">
                    <input name="q" class="form-control" placeholder="Search name, slug or description" value="<?php echo e($q ?? ''); ?>">
                    <div class="input-group-append">
                        <button class="btn btn-secondary">Search</button>
                    </div>
                </div>
            </form>
            <a href="<?php echo e(route('admin.products.create')); ?>" class="btn btn-primary">Create product</a>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <?php if(session('success')): ?> <div class="alert alert-success"><?php echo e(session('success')); ?></div> <?php endif; ?>
            <?php if(session('error')): ?> <div class="alert alert-danger"><?php echo e(session('error')); ?></div> <?php endif; ?>

            <div class="card">
                <div class="card-body p-0">
                    <?php if($products->count()): ?>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Thumb</th>
                                    <th>Name</th>
                                    <th>Seller</th>
                                    <th>Category</th>
                                    <th class="text-right">Price</th>
                                    <th class="text-center">Stock</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($p->id); ?></td>

                                    <td style="width:80px">
                                        <?php
                                            $thumb = $p->images[0] ?? null;
                                        ?>

                                        <?php if($thumb && \Illuminate\Support\Facades\Storage::disk('public')->exists($thumb)): ?>
                                            <img src="<?php echo e(asset('storage/'.$thumb)); ?>" style="width:64px;height:48px;object-fit:cover;border-radius:4px;">
                                        <?php else: ?>
                                            <div style="width:64px;height:48px;background:#f0f0f0;border-radius:4px;"></div>
                                        <?php endif; ?>
                                    </td>

                                    <td><?php echo e($p->name); ?></td>
                                    <td><?php echo e(optional($p->user)->name ?? '—'); ?></td>
                                    <td><?php echo e(optional($p->category)->name ?? '—'); ?></td>
                                    <td class="text-right"><?php echo e(number_format($p->price,2)); ?></td>
                                    <td class="text-center"><?php echo e($p->stock); ?></td>
                                    <td class="text-center"><?php echo e(ucfirst($p->status)); ?></td>
                                    <td class="text-right">
                                        <a href="<?php echo e(route('admin.products.show', $p->id)); ?>" class="btn btn-sm btn-outline-primary">View</a>
                                        <a href="<?php echo e(route('admin.products.edit', $p->id)); ?>" class="btn btn-sm btn-primary">Edit</a>

                                        <form action="<?php echo e(route('admin.products.destroy', $p->id)); ?>" method="POST"
                                              onsubmit="return confirm('Delete product?');" style="display:inline-block;">
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
                        <?php echo e($products->links()); ?>

                    </div>
                    <?php else: ?>
                    <div class="p-4">No products found.</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layout.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\wamp64\www\E-commerce\c2c-shop - Copy\resources\views/backend/products/index.blade.php ENDPATH**/ ?>
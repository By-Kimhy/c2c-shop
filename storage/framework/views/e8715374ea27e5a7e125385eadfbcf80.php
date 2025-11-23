
<?php $__env->startSection('content'); ?>





<!-- Start Banner Area -->
<section class="banner-area organic-breadcrumb">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
            <div class="col-first">
                <h1>Shopping Cart</h1>
                <nav class="d-flex align-items-center">
                    <a href="index.html">Home<span class="lnr lnr-arrow-right"></span></a>
                    <a href="category.html">Cart</a>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- End Banner Area -->




<?php
// Defensive resolver for item images (handles string/array/json/URL)
if (! function_exists('resolveItemImageUrl')) {
function resolveItemImageUrl($image) {
$placeholder = asset('frontend/assets/img/product/p4.jpg');
if (empty($image)) return $placeholder;
if (is_array($image) || $image instanceof \Illuminate\Support\Collection) {
$first = is_array($image) ? ($image[0] ?? null) : $image->first();
return resolveItemImageUrl($first);
}
if (is_string($image) && in_array(substr(trim($image),0,1), ['[','{'])) {
$decoded = json_decode($image, true);
if (json_last_error() === JSON_ERROR_NONE) return resolveItemImageUrl($decoded);
}
if (is_string($image) && preg_match('#^https?://#i', $image)) return $image;
$rel = ltrim((string)$image, '/');
try {
if (\Illuminate\Support\Facades\Storage::disk('public')->exists($rel)) return asset('storage/'.$rel);
} catch (\Exception $e) {}
if (file_exists(public_path($rel))) return asset($rel);
return $placeholder;
}
}
?>

<div class="container py-4">
    <h2 class="mb-3">Your cart</h2>

    <?php if(session('success')): ?>
    <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <?php if($items->isEmpty()): ?>
    <div class="alert alert-info">Your cart is empty.</div>
    <?php else: ?>

    
    <div class="table-responsive d-none d-md-block">
        <table class="table table-hover align-middle">
            <thead class="thead-light">
                <tr>
                    <th style="width:110px;">Product</th>
                    <th>Product</th>
                    <th class="text-right" style="width:120px;">Price</th>
                    <th style="width:130px;">Qty</th>
                    <th class="text-right" style="width:140px;">Line</th>
                    <th class="text-right" style="width:120px;"></th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php $imgUrl = resolveItemImageUrl($item['image'] ?? null); ?>
                <tr>
                    <td><img src="<?php echo e($imgUrl); ?>" alt="<?php echo e($item['name']); ?>" style="width:90px;height:60px;object-fit:cover;border-radius:6px;"></td>
                    <td>
                        <div class="fw-bold"><?php echo e(Str::limit($item['name'], 60)); ?></div>
                        <div class="text-muted small">ID: <?php echo e($item['id']); ?></div>
                    </td>
                    <td class="text-right"><?php echo e(number_format($item['price'], 2)); ?> $</td>
                    <td>
                        <form action="<?php echo e(route('cart.update')); ?>" method="POST" class="d-flex">
                            <?php echo csrf_field(); ?>
                            <input type="number" name="items[<?php echo e($item['id']); ?>][qty]" value="<?php echo e($item['qty']); ?>" min="0" class="form-control form-control-sm me-2" style="width:80px;">
                            <button class="btn btn-sm btn-outline-primary" type="submit">Update</button>
                        </form>
                    </td>
                    <td class="text-right"><?php echo e(number_format($item['price'] * $item['qty'], 2)); ?> $</td>
                    <td class="text-right">
                        <form method="POST" action="<?php echo e(route('cart.remove')); ?>">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="product_id" value="<?php echo e($item['id']); ?>">
                            <button type="submit" class="btn btn-sm btn-danger">Remove</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>

    
    <div class="d-block d-md-none">
        <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php $imgUrl = resolveItemImageUrl($item['image'] ?? null); ?>
        <div class="card mb-3">
            <div class="row g-0 align-items-center">
                <div class="col-4">
                    <img src="<?php echo e($imgUrl); ?>" class="img-fluid rounded-start" alt="<?php echo e($item['name']); ?>" style="height:100%;object-fit:cover;">
                </div>
                <div class="col-8">
                    <div class="card-body py-2">
                        <h6 class="card-title mb-1"><?php echo e(Str::limit($item['name'], 60)); ?></h6>
                        <p class="text-muted mb-1 small">Unit: <?php echo e(number_format($item['price'], 2)); ?> $</p>

                        <div class="d-flex justify-content-between align-items-center">
                            <form action="<?php echo e(route('cart.update')); ?>" method="POST" class="d-flex align-items-center">
                                <?php echo csrf_field(); ?>
                                <input type="number" name="items[<?php echo e($item['id']); ?>][qty]" value="<?php echo e($item['qty']); ?>" min="0" class="form-control form-control-sm me-2" style="width:70px;">
                                <button class="btn btn-sm btn-outline-primary" type="submit">Update</button>
                            </form>

                            <div class="text-end">
                                <div class="fw-bold"><?php echo e(number_format($item['price'] * $item['qty'], 2)); ?> $</div>
                                <form method="POST" action="<?php echo e(route('cart.remove')); ?>" class="mt-1">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="product_id" value="<?php echo e($item['id']); ?>">
                                    <button type="submit" class="btn btn-sm btn-danger">Remove</button>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-3">
        <div class="mb-2 mb-md-0">
            <form method="POST" action="<?php echo e(route('cart.clear')); ?>" onsubmit="return confirm('Clear cart?');" class="d-inline">
                <?php echo csrf_field(); ?>
                <button class="btn btn-outline-secondary">Clear cart</button>
            </form>
            <a href="<?php echo e(url('/')); ?>" class="btn btn-link">Continue shopping</a>
        </div>

        <div class="text-end">
            <h5 class="mb-2">Subtotal: <strong><?php echo e(number_format($subtotal, 2)); ?> $</strong></h5>
            <a href="<?php echo e(url('/checkout')); ?>" class="btn btn-success btn-lg">Proceed to checkout</a>
        </div>
    </div>

    <?php endif; ?>
</div>

<style>
    .table-hover tbody tr:hover {
        background-color: rgba(0, 0, 0, 0.02);
    }

    @media (max-width: 767px) {
        .card .btn {
            font-size: 0.85rem;
            padding: 0.35rem 0.6rem;
        }
    }

</style>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layout.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\wamp64\www\E-commerce\c2c-shop - Copy\resources\views/frontend/cart/index.blade.php ENDPATH**/ ?>
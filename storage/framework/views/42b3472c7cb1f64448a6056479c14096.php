

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



<div class="container py-4">
    <h3 class="mb-3">Checkout</h3>

    <?php if(session('error')): ?> <div class="alert alert-danger"><?php echo e(session('error')); ?></div> <?php endif; ?>
    <?php if(session('success')): ?> <div class="alert alert-success"><?php echo e(session('success')); ?></div> <?php endif; ?>

    <?php if($items->isEmpty()): ?>
    <div class="alert alert-info">Your cart is empty. <a href="<?php echo e(url('/')); ?>">Continue shopping</a>.</div>
    <?php else: ?>
    <div class="card mb-3">
        <div class="card-body">
            <table class="table table-sm mb-0">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th class="text-end">Price</th>
                        <th class="text-center">Qty</th>
                        <th class="text-end">Line</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="<?php echo e(resolveItemImageUrl($item['image'] ?? null)); ?>" alt="<?php echo e($item['name']); ?>" style="width:64px;height:48px;object-fit:cover;border-radius:6px;" class="me-2">
                                <div>
                                    <div class="fw-bold"><?php echo e(Str::limit($item['name'], 60)); ?></div>
                                </div>
                            </div>
                        </td>
                        <td class="text-end"><?php echo e(number_format($item['price'],2)); ?> $</td>
                        <td class="text-center"><?php echo e($item['qty']); ?></td>
                        <td class="text-end"><?php echo e(number_format($item['line'],2)); ?> $</td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>

            <div class="d-flex justify-content-between align-items-center mt-3">
                <div>
                    <a href="<?php echo e(url('/')); ?>" class="btn btn-link">Continue shopping</a>
                    <a href="<?php echo e(route('cart.index')); ?>" class="btn btn-outline-secondary">Edit cart</a>
                </div>

                <div class="text-end">
                    <div class="mb-1 text-muted">Subtotal</div>
                    <h4 class="mb-0"><?php echo e(number_format($subtotal,2)); ?> $</h4>
                </div>
            </div>
        </div>
    </div>

    
    <form action="<?php echo e(route('checkout.process')); ?>" method="POST" id="checkout-form">
        <?php echo csrf_field(); ?>

        
        <input type="hidden" name="cart_snapshot" value="<?php echo e(base64_encode(json_encode($items->toArray()))); ?>">

        
        <button type="submit" class="btn btn-success btn-lg w-100" id="checkout-submit-btn">
            <span class="ti-bag me-2"></span> Pay with KHQR (<?php echo e(number_format($subtotal,2)); ?> $)
        </button>
    </form>

    <?php endif; ?>
</div>

<script>
    document.getElementById('checkout-form')?.addEventListener('submit', function(e) {
        document.getElementById('checkout-submit-btn').disabled = true;
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layout.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\wamp64\www\E-commerce\c2c-shop - Copy\resources\views/frontend/checkout/index.blade.php ENDPATH**/ ?>
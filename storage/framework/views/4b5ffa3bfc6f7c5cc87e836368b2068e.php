
<?php $__env->startSection('content'); ?>

<!-- Start Banner Area -->
<section class="banner-area organic-breadcrumb">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
            <div class="col-first">
                <h1>Verify your email</h1>
            </div>
        </div>
    </div>
</section>
<!-- End Banner Area -->

<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <?php if(session('success')): ?> <div class="alert alert-success"><?php echo e(session('success')); ?></div> <?php endif; ?>
      <?php if(session('status')): ?> <div class="alert alert-info"><?php echo e(session('status')); ?></div> <?php endif; ?>

      <div class="card">
        <div class="card-body">
          <h4>Please verify your email</h4>
          <p>We sent a verification link to your email address. Check your inbox and click the link to verify your account.</p>

          <form method="POST" action="<?php echo e(route('verification.resend')); ?>">
            <?php echo csrf_field(); ?>
            <button type="submit" class="btn btn-primary">Resend verification email</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layout.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\wamp64\www\E-commerce\c2c-shop - Copy\resources\views/frontend/auth/verify-notice.blade.php ENDPATH**/ ?>
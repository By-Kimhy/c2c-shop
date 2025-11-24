

<?php $__env->startSection('content'); ?>
<!-- Start Banner Area -->
<section class="banner-area organic-breadcrumb">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
            <div class="col-first">
                <h1>ទាក់ទងមកយើង</h1>
                <nav class="d-flex align-items-center">
                    <a href="<?php echo e(route('home')); ?>">ទំព័រដើម<span class="lnr lnr-arrow-right"></span></a>
                    <a href="<?php echo e(route('contact')); ?>">ទាក់ទងមកយើង</a>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- End Banner Area -->

<section class="contact_area section_gap_bottom">
    <div class="container">
        <?php if(session('success')): ?>
            <div class="alert alert-success"><?php echo e(session('success')); ?></div>
        <?php endif; ?>
        <?php if(session('error')): ?>
            <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
        <?php endif; ?>

        <div id="mapBox" class="mapBox" data-lat="11.576341" data-lon="104.918202" data-zoom="13" data-info="No. 86A, Street 110, Phnom Penh" data-mlat="11.576341" data-mlon="104.918202"></div>

        <div class="row">
            <div class="col-lg-3">
                <div class="contact_info">
                    <div class="info_item">
                        <i class="lnr lnr-home"></i>
                        <h6>រាជធានីភ្នំពេញ ប្រទេសកម្ពុជា</h6>
                        <p>មហាវិថីសហព័ន្ធរុស្ស៊ី សង្កាត់ទឹកល្អក់១ ខណ្ឌទួលគោក </p>
                    </div>
                    <div class="info_item">
                        <i class="lnr lnr-phone-handset"></i>
                        <h6><a href="#">+855 12 345 678</a></h6>
                        <p>ច័ន្ទ ដល់ សុក្រ ម៉ោង ៩ ព្រឹក ដល់ ៦ ល្ងាច</p>
                    </div>
                    <div class="info_item">
                        <i class="lnr lnr-envelope"></i>
                        <h6><a href="mailto:<?php echo e(config('mail.from.address')); ?>"><?php echo e(config('mail.from.address')); ?></a></h6>
                        <p>ផ្ញើសំណួររបស់អ្នកមកយើងគ្រប់ពេល!</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-9">
                <form class="row contact_form" action="<?php echo e(route('contact.send')); ?>" method="post" id="contactForm" novalidate>
                    <?php echo csrf_field(); ?>

                    <div class="col-md-6">
                        <div class="form-group">
                            <input value="<?php echo e(old('name')); ?>" type="text" class="form-control" id="name" name="name" placeholder="បញ្ចូល​ឈ្មោះ​របស់​អ្នក">
                            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small class="text-danger"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="form-group">
                            <input value="<?php echo e(old('email')); ?>" type="email" class="form-control" id="email" name="email" placeholder="បញ្ចូលអាសយដ្ឋានអ៊ីមេល">
                            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small class="text-danger"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="form-group">
                            <input value="<?php echo e(old('subject')); ?>" type="text" class="form-control" id="subject" name="subject" placeholder="បញ្ចូលប្រធានបទ">
                            <?php $__errorArgs = ['subject'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small class="text-danger"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <textarea class="form-control" name="message" id="message" rows="6" placeholder="បញ្ចូលសារ"><?php echo e(old('message')); ?></textarea>
                            <?php $__errorArgs = ['message'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small class="text-danger"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <div class="col-md-12 text-right">
                        <button type="submit" class="primary-btn">ផ្ញើ​សារ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layout.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\wamp64\www\E-commerce\c2c-shop - Copy\resources\views/frontend/contact/index.blade.php ENDPATH**/ ?>
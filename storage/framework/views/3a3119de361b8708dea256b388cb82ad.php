
<?php $__env->startSection('content'); ?>

<!-- start banner Area -->
<section class="banner-area">
    <div class="container">
        <div class="row fullscreen align-items-center justify-content-start">
            <div class="col-lg-12">
                <div class="active-banner-slider owl-carousel">
                    <!-- single-slide -->
                    <div class="row single-slide align-items-center d-flex">
                        <div class="col-lg-5 col-md-6">
                            <div class="banner-content">
                                <h1>Nike New <br>Collection!</h1>
                                <p>គ្រាន់តែ​ធ្វើ​វាឡើងមក ភាពអស្ចារ្យត្រូវការរបស់ច្រើន ប៉ុន្តែមិនត្រូវការទស្សនិកជនទេ
                                    ដូច​​ម្សិលមិញ​អ្នក​និយាយ​ថា​ចាំថ្ងៃ​ស្អែក</p>
                                
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="banner-img">
                                <img class="img-fluid" src="<?php echo e(asset('frontend/assets/img/banner/banner-img.png')); ?>" alt="">
                            </div>
                        </div>
                    </div>
                    <!-- single-slide -->
                    <div class="row single-slide">
                        <div class="col-lg-5">
                            <div class="banner-content">
                                <h1>Puma New <br>Collection!</h1>
                                <p>គ្រាន់តែ​ធ្វើ​វាឡើងមក ភាពអស្ចារ្យត្រូវការរបស់ច្រើន ប៉ុន្តែមិនត្រូវការទស្សនិកជនទេ
                                    ដូច​​ម្សិលមិញ​អ្នក​និយាយ​ថា​ចាំថ្ងៃ​ស្អែក</p>
                                
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="banner-img">
                                <img class="img-fluid" src="<?php echo e(asset('frontend/assets/img/banner/banner-img1.png')); ?>" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End banner Area -->

<!-- start features Area -->
<section class="features-area section_gap">
    <div class="container">
        <div class="row features-inner">
            <!-- single features -->
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="single-features">
                    <div class="f-icon">
                        <img src="<?php echo e(asset('frontend/assets/img/features/f-icon1.png')); ?>" alt="">
                    </div>
                    <h6>ដឹកជញ្ជូនដោយឥតគិតថ្លៃ</h6>
                    <p>ឥតគិតថ្លៃលើការបញ្ជាទិញទាំងអស់</p>
                </div>
            </div>
            <!-- single features -->
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="single-features">
                    <div class="f-icon">
                        <img src="<?php echo e(asset('frontend/assets/img/features/f-icon2.png')); ?>" alt="">
                    </div>
                    <h6>ការបង្វិលទំនិញត្រឡប់មកវិញ</h6>
                    <p>ឥតគិតថ្លៃលើការបញ្ជាទិញទាំងអស់</p>
                </div>
            </div>
            <!-- single features -->
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="single-features">
                    <div class="f-icon">
                        <img src="<?php echo e(asset('frontend/assets/img/features/f-icon3.png')); ?>" alt="">
                    </div>
                    <h6>24/7 Support</h6>
                    <p>ឥតគិតថ្លៃលើការបញ្ជាទិញទាំងអស់</p>
                </div>
            </div>
            <!-- single features -->
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="single-features">
                    <div class="f-icon">
                        <img src="<?php echo e(asset('frontend/assets/img/features/f-icon4.png')); ?>" alt="">
                    </div>
                    <h6>ការទូទាត់ប្រកបដោយសុវត្ថិភាព</h6>
                    <p>ឥតគិតថ្លៃលើការបញ្ជាទិញទាំងអស់</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- end features Area -->



<!-- start product Area (dynamic) -->
<section class="products-area section_gap">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-6 text-center">
        <div class="section-title">
          <h1>ផលិតផលទើបនិងចេញ</h1>
          <p>ផលិតផលល្អអាចត្រូវបានលក់ដោយការផ្សាយពាណិជ្ជកម្មដោយស្មោះត្រង់</p>
        </div>
      </div>
    </div>

    <div class="row">
      <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="col-lg-3 col-md-6 mb-4">
          <div class="single-product">
            <?php
              $thumb = is_array($p->images) && count($p->images) ? $p->images[0] : null;
              $imgUrl = $thumb && Storage::disk('public')->exists($thumb)
                        ? asset('storage/'.$thumb)
                        : asset('frontend/assets/img/product/p4.jpg');
            ?>

            <img class="product-thumb" src="<?php echo e($imgUrl); ?>" alt="<?php echo e($p->name); ?>">

            <div class="product-details mt-2">
              <h6 style="min-height:40px; overflow:hidden;">
                <?php echo e(Str::limit($p->name, 60)); ?>

              </h6>

              <div class="price">
                <h6><?php echo e(number_format($p->price, 2)); ?> $</h6>
              </div>

              <div class="prd-bottom mt-2">
                <a href="<?php echo e(url('/cart')); ?>" class="social-info">
                  <span class="ti-bag"></span>
                  <p class="hover-text">បន្ថែមចូលកន្ត្រក</p>
                </a>

                <a href="<?php echo e(url('/productDetail?id='.$p->id)); ?>" class="social-info">
                  <span class="lnr lnr-move"></span>
                  <p class="hover-text">បង្ហាញបន្តែម</p>
                </a>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="col-12">
          <div class="alert alert-info">No products found.</div>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <!-- FIX IMAGE SIZE -->
  <style>
      .single-product .product-thumb {
          width: 100%;
          height: 250px;   /* ← Make everything same height */
          object-fit: cover;
          border-radius: 5px;
      }
  </style>

</section>
<!-- end product Area -->


<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layout.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\wamp64\www\E-commerce\c2c-shop - Copy\resources\views/frontend/home/index.blade.php ENDPATH**/ ?>
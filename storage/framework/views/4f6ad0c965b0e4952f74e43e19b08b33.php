	
	<?php $__env->startSection('content'); ?>

	<!-- Start Banner Area -->
	<section class="banner-area organic-breadcrumb">
	    <div class="container">
	        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
	            <div class="col-first">
	                <h1>ប្រភេទផលិតផល</h1>
	                <nav class="d-flex align-items-center">
	                    <a href="index.php">ទំព័រដើម<span class="lnr lnr-arrow-right"></span></a>
	                    <a href="#">ហាង<span class="lnr lnr-arrow-right"></span></a>
	                    <a href="#">ប្រភេទ</a>
	                </nav>
	            </div>
	        </div>
	    </div>
	</section>
	<!-- End Banner Area -->
	<!-- start product Area (dynamic) -->
	<section class="products-area section_gap">
	    <div class="container">
	        <div class="row justify-content-center mb-4">
	            <div class="col-lg-6 text-center">
	                <div class="section-title">
	                    <h1>ផលិតផលទើបនិងចេញ</h1>
	                    <p class="text-muted">ផលិតផលល្អអាចត្រូវបានលក់ដោយការផ្សាយពាណិជ្ជកម្មដោយស្មោះត្រង់</p>
	                </div>
	            </div>
	        </div>

	        <div class="row gx-3 gy-4">
	            <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
	            <?php
	            // normalize thumbnail: support array/json/string
	            $thumb = null;
	            if (!empty($p->images)) {
	            if (is_array($p->images)) {
	            $thumb = $p->images[0] ?? null;
	            } else {
	            $tmp = @json_decode($p->images, true);
	            $thumb = (json_last_error() === JSON_ERROR_NONE) ? ($tmp[0] ?? null) : $p->images;
	            }
	            }
	            $imgUrl = ($thumb && Storage::disk('public')->exists(ltrim($thumb, '/')))
	            ? asset('storage/' . ltrim($thumb, '/'))
	            : asset('frontend/assets/img/product/p4.jpg');
	            ?>

	            <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
	                <div class="card product-card h-100 shadow-sm">
	                    <a href="<?php echo e(route('product.show', $p->id)); ?>" class="text-decoration-none">
	                        <div class="ratio ratio-4x3 overflow-hidden">
	                            <img src="<?php echo e($imgUrl); ?>" alt="<?php echo e($p->name); ?>" class="card-img-top object-fit-cover">
	                        </div>
	                    </a>

	                    <div class="card-body d-flex flex-column">
	                        <a href="<?php echo e(route('product.show', $p->id)); ?>" class="text-dark text-decoration-none">
	                            <h6 class="card-title mb-1"><?php echo e(Str::limit($p->name, 60)); ?></h6>
	                        </a>

	                        <div class="d-flex align-items-center justify-content-between mb-3">
	                            <div class="text-primary fw-bold"><?php echo e(number_format($p->price, 2)); ?> $</div>
	                            <div class="text-muted small">ID: <?php echo e($p->id); ?></div>
	                        </div>

	                        <div class="mt-auto d-flex gap-2">
	                            
	                            <form action="<?php echo e(route('cart.add')); ?>" method="POST" class="m-0 w-100 pr-2">
	                                <?php echo csrf_field(); ?>
	                                <input type="hidden" name="product_id" value="<?php echo e($p->id); ?>">
	                                <input type="hidden" name="qty" value="1">
	                                <button type="submit" class="btn btn-success w-100" aria-label="Add <?php echo e($p->name); ?> to cart">
	                                    <span class="ti-bag me-1" aria-hidden="true"></span>
	                                    បន្ថែម
	                                </button>
	                            </form>

	                            
	                            <a href="<?php echo e(route('product.show', $p->id)); ?>" class="btn btn-outline-secondary" title="View details">
	                                <span class="lnr lnr-move" aria-hidden="true"></span>
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

	    <!-- small styles to keep product thumbs neat -->
	    <style>
	        .product-card {
	            border-radius: 8px;
	            overflow: hidden;
	        }

	        .product-card .object-fit-cover {
	            object-fit: cover;
	            width: 100%;
	            height: 100%;
	            display: block;
	        }

	        .ratio-4x3 {
	            aspect-ratio: 4 / 3;
	        }

	        @media (max-width: 576px) {
	            .product-card .card-title {
	                font-size: 0.95rem;
	            }
	        }

	    </style>
	</section>
	<!-- end product Area -->



	<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layout.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\wamp64\www\E-commerce\c2c-shop - Copy\resources\views/frontend/product/index.blade.php ENDPATH**/ ?>
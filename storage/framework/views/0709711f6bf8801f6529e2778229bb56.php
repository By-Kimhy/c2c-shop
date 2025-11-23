<!DOCTYPE html>
<html lang="zxx" class="no-js">

<head>
	<!-- Mobile Specific Meta -->
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- Favicon-->
	<link rel="shortcut icon" href="img/fav.png">
	<!-- Author Meta -->
	<meta name="author" content="CodePixar">
	<!-- Meta Description -->
	<meta name="description" content="">
	<!-- Meta Keyword -->
	<meta name="keywords" content="">
	<!-- meta character set -->
	<meta charset="UTF-8">
	<!-- Site Title -->
	<title>Karma Shop</title>
	<!--
		CSS
		============================================= -->
	<?php echo $__env->make('frontend.layout.style_shop', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</head>

<body>

	<!-- Start Header Area -->
	<?php echo $__env->make('frontend.layout.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
	<!-- End Header Area -->

    <!-- Start Master Area -->
    <?php echo $__env->yieldContent('content'); ?>
    <!-- End Master Area -->

	<!-- start footer Area -->
	<?php echo $__env->make('frontend.layout.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
	<!-- End footer Area -->

	<?php echo $__env->make('frontend.layout.js_shop', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</body>

</html><?php /**PATH C:\wamp64\www\E-commerce\c2c-shop - Copy\resources\views/frontend/layout/master.blade.php ENDPATH**/ ?>
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
	@include('frontend.layout.style_shop')
</head>

<body>

	<!-- Start Header Area -->
	@include('frontend.layout.header')
	<!-- End Header Area -->

    <!-- Start Master Area -->
    @yield('content')
    <!-- End Master Area -->

	<!-- start footer Area -->
	@include('frontend.layout.footer')
	<!-- End footer Area -->

	@include('frontend.layout.js_shop')
</body>

</html>
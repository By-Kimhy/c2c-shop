	@extends('frontend.layout.master')
	@section('content')

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
	{{-- <!-- start product Area (dynamic) -->
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
	            @forelse($products as $p)
	            <div class="col-lg-3 col-md-6 mb-4">
	                <div class="single-product">
	                    @php
	                    $thumb = is_array($p->images) && count($p->images) ? $p->images[0] : null;
	                    $imgUrl = $thumb && Storage::disk('public')->exists($thumb)
	                    ? asset('storage/'.$thumb)
	                    : asset('frontend/assets/img/product/p4.jpg');
	                    @endphp

	                    <img class="product-thumb" src="{{ $imgUrl }}" alt="{{ $p->name }}">

	                    <div class="product-details mt-2">
	                        <h6 style="min-height:40px; overflow:hidden;">
	                            {{ Str::limit($p->name, 60) }}
	                        </h6>

	                        <div class="price">
	                            <h6>{{ number_format($p->price, 2) }} $</h6>
	                        </div>

	                        <div class="prd-bottom mt-2">
	                            <a href="{{ url('/cart') }}" class="social-info">
	                                <span class="ti-bag"></span>
	                                <p class="hover-text">បន្ថែមចូលកន្ត្រក</p>
	                            </a>

	                            <a href="{{ url('/productDetail?id='.$p->id) }}" class="social-info">
	                                <span class="lnr lnr-move"></span>
	                                <p class="hover-text">បង្ហាញបន្តែម</p>
	                            </a>
	                        </div>
	                    </div>
	                </div>
	            </div>
	            @empty
	            <div class="col-12">
	                <div class="alert alert-info">No products found.</div>
	            </div>
	            @endforelse
	        </div>
	    </div>

	    <!-- FIX IMAGE SIZE -->
	    <style>
	        .single-product .product-thumb {
	            width: 100%;
	            height: 250px;
	            /* ← Make everything same height */
	            object-fit: cover;
	            border-radius: 5px;
	        }

	    </style>

	</section>
	<!-- end product Area --> --}}

	@endsection

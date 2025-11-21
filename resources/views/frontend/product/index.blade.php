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
	<div class="container">
	    <div class="row">
	        <div class="col-xl-3 col-lg-4 col-md-5">
	            <div class="sidebar-categories">
	                <div class="head">ប្រភេទ</div>
	                <ul class="main-categories">
	                    <li class="main-nav-list"><a data-toggle="collapse" href="#fruitsVegetable" aria-expanded="false" aria-controls="fruitsVegetable"><span class="lnr lnr-arrow-right"></span>ស្បែកជើងប៉ាតា<span class="number">(53)</span></a>
	                        <ul class="collapse" id="fruitsVegetable" data-toggle="collapse" aria-expanded="false" aria-controls="fruitsVegetable">
	                            <li class="main-nav-list child"><a href="#">Adidas<span class="number">(13)</span></a></li>
	                            <li class="main-nav-list child"><a href="#">Nikes<span class="number">(09)</span></a></li>
	                            <li class="main-nav-list child"><a href="#">PUMA<span class="number">(17)</span></a></li>
	                            <li class="main-nav-list child"><a href="#">Vans<span class="number">(01)</span></a></li>
	                            <li class="main-nav-list child"><a href="#">Meat<span class="number">(11)</span></a></li>
	                        </ul>
	                    </li>

	                    <li class="main-nav-list"><a data-toggle="collapse" href="#meatFish" aria-expanded="false" aria-controls="meatFish"><span class="lnr lnr-arrow-right"></span>ស្បែកជើងកវែង<span class="number">(53)</span></a>
	                        <ul class="collapse" id="meatFish" data-toggle="collapse" aria-expanded="false" aria-controls="meatFish">
	                            <li class="main-nav-list child"><a href="#">Adidas<span class="number">(13)</span></a></li>
	                            <li class="main-nav-list child"><a href="#">Nikes<span class="number">(09)</span></a></li>
	                            <li class="main-nav-list child"><a href="#">PUMA<span class="number">(17)</span></a></li>
	                            <li class="main-nav-list child"><a href="#">Vans<span class="number">(01)</span></a></li>
	                            <li class="main-nav-list child"><a href="#">clarks<span class="number">(11)</span></a></li>
	                        </ul>
	                    </li>
	                    <li class="main-nav-list"><a data-toggle="collapse" href="#cooking" aria-expanded="false" aria-controls="cooking"><span class="lnr lnr-arrow-right"></span>Loafer<span class="number">(53)</span></a>
	                        <ul class="collapse" id="cooking" data-toggle="collapse" aria-expanded="false" aria-controls="cooking">
	                            <li class="main-nav-list child"><a href="#">Adidas<span class="number">(13)</span></a></li>
	                            <li class="main-nav-list child"><a href="#">Nikes<span class="number">(09)</span></a></li>
	                            <li class="main-nav-list child"><a href="#">PUMA<span class="number">(17)</span></a></li>
	                            <li class="main-nav-list child"><a href="#">Vans<span class="number">(01)</span></a></li>
	                            <li class="main-nav-list child"><a href="#">clarks<span class="number">(11)</span></a></li>
	                        </ul>
	                    </li>
	                    <li class="main-nav-list"><a data-toggle="collapse" href="#beverages" aria-expanded="false" aria-controls="beverages"><span class="lnr lnr-arrow-right"></span>ស្បែកជើង Oxford<span class="number">(24)</span></a>
	                        <ul class="collapse" id="beverages" data-toggle="collapse" aria-expanded="false" aria-controls="beverages">
	                            <li class="main-nav-list child"><a href="#">Adidas<span class="number">(13)</span></a></li>
	                            <li class="main-nav-list child"><a href="#">Nikes<span class="number">(09)</span></a></li>
	                            <li class="main-nav-list child"><a href="#">PUMA<span class="number">(17)</span></a></li>
	                            <li class="main-nav-list child"><a href="#">Vans<span class="number">(01)</span></a></li>
	                            <li class="main-nav-list child"><a href="#">clarks<span class="number">(11)</span></a></li>
	                        </ul>
	                    </li>
	                    <li class="main-nav-list"><a data-toggle="collapse" href="#homeClean" aria-expanded="false" aria-controls="homeClean"><span class="lnr lnr-arrow-right"></span>Sandal<span class="number">(53)</span></a>
	                        <ul class="collapse" id="homeClean" data-toggle="collapse" aria-expanded="false" aria-controls="homeClean">
	                            <li class="main-nav-list child"><a href="#">Adidas<span class="number">(13)</span></a></li>
	                            <li class="main-nav-list child"><a href="#">Nikes<span class="number">(09)</span></a></li>
	                            <li class="main-nav-list child"><a href="#">PUMA<span class="number">(17)</span></a></li>
	                            <li class="main-nav-list child"><a href="#">Vans<span class="number">(01)</span></a></li>
	                            <li class="main-nav-list child"><a href="#">clarks<span class="number">(11)</span></a></li>
	                        </ul>
	                    </li>
	                    <li class="main-nav-list"><a data-toggle="collapse" href="#homeAppliance" aria-expanded="false" aria-controls="homeAppliance"><span class="lnr lnr-arrow-right"></span>Espadrille<span class="number">(15)</span></a>
	                        <ul class="collapse" id="homeAppliance" data-toggle="collapse" aria-expanded="false" aria-controls="homeAppliance">
	                            <li class="main-nav-list child"><a href="#">Adidas<span class="number">(13)</span></a></li>
	                            <li class="main-nav-list child"><a href="#">Nikes<span class="number">(09)</span></a></li>
	                            <li class="main-nav-list child"><a href="#">PUMA<span class="number">(17)</span></a></li>
	                            <li class="main-nav-list child"><a href="#">Vans<span class="number">(01)</span></a></li>
	                            <li class="main-nav-list child"><a href="#">clarks<span class="number">(11)</span></a></li>
	                        </ul>
	                    </li>
	                    <li class="main-nav-list"><a class="border-bottom-0" data-toggle="collapse" href="#babyCare" aria-expanded="false" aria-controls="babyCare"><span class="lnr lnr-arrow-right"></span>កូនក្មេង<span class="number">(48)</span></a>
	                        <ul class="collapse" id="babyCare" data-toggle="collapse" aria-expanded="false" aria-controls="babyCare">
	                            <li class="main-nav-list child"><a href="#">Adidas<span class="number">(13)</span></a></li>
	                            <li class="main-nav-list child"><a href="#">Nikes<span class="number">(09)</span></a></li>
	                            <li class="main-nav-list child"><a href="#">PUMA<span class="number">(17)</span></a></li>
	                            <li class="main-nav-list child"><a href="#">Vans<span class="number">(01)</span></a></li>
	                            <li class="main-nav-list child"><a href="#" class="border-bottom-0">clarks<span class="number">(11)</span></a></li>
	                        </ul>
	                    </li>
	                </ul>
	            </div>
	            <div class="sidebar-filter mt-50">
	                <div class="top-filter-head">ផលិតផល</div>
	                <div class="common-filter">
	                    <div class="head">ម៉ាក</div>
	                    <form action="#">
	                        <ul>
	                            <li class="filter-list"><input class="pixel-radio" type="radio" id="Addidas" name="brand"><label for="Addidas">Addidas<span>(29)</span></label></li>
	                            <li class="filter-list"><input class="pixel-radio" type="radio" id="Nikes" name="brand"><label for="Nikes">Nikes<span>(29)</span></label></li>
	                            <li class="filter-list"><input class="pixel-radio" type="radio" id="Puma" name="brand"><label for="Puma">Puma<span>(19)</span></label></li>
	                            <li class="filter-list"><input class="pixel-radio" type="radio" id="clarks" name="brand"><label for="clarks">clarks<span>(19)</span></label></li>
	                            <li class="filter-list"><input class="pixel-radio" type="radio" id="Vans" name="brand"><label for="Vans">Vans<span>(19)</span></label></li>
	                        </ul>
	                    </form>
	                </div>
	                <div class="common-filter">
	                    <div class="head">ពណ៌</div>
	                    <form action="#">
	                        <ul>
	                            <li class="filter-list"><input class="pixel-radio" type="radio" id="black" name="color"><label for="black">ខ្មៅ<span>(29)</span></label></li>
	                            <li class="filter-list"><input class="pixel-radio" type="radio" id="balckleather" name="color"><label for="balckleather">ស្បែកខ្មៅ<span>(29)</span></label></li>
	                            <li class="filter-list"><input class="pixel-radio" type="radio" id="blackred" name="color"><label for="blackred">ខ្មៅលាយក្រហម<span>(19)</span></label></li>
	                            <li class="filter-list"><input class="pixel-radio" type="radio" id="gold" name="color"><label for="gold">មាស<span>(19)</span></label></li>
	                            <li class="filter-list"><input class="pixel-radio" type="radio" id="spacegrey" name="color"><label for="spacegrey">ពណ៌ប្រផេះ<span>(19)</span></label></li>
	                        </ul>
	                    </form>
	                </div>
	                <div class="common-filter">
	                    <div class="head">តម្លៃ</div>
	                    <div class="price-range-area">
	                        <div id="price-range"></div>
	                        <div class="value-wrapper d-flex">
	                            <div class="price">តម្លៃ:</div>
	                            <span>$</span>
	                            <div id="lower-value"></div>
	                            <div class="to">ដល់</div>
	                            <span>$</span>
	                            <div id="upper-value"></div>
	                        </div>
	                    </div>
	                </div>
	            </div>
	        </div>
	        <div class="col-xl-9 col-lg-8 col-md-7">
	            <!-- Start Filter Bar -->
	            <div class="filter-bar d-flex flex-wrap align-items-center">
	                <div class="sorting">
	                    <select>
	                        <option value="1">តម្រៀបលំនាំដើម</option>
	                        <option value="1">តម្រៀបពី​ A-Z</option>
	                        <option value="1">តម្រៀបពី Z-A </option>
	                    </select>
	                </div>
	                <div class="sorting mr-auto">
	                    <select>
	                        <option value="1">បង្ហាញ 10</option>
	                        <option value="1">បង្ហាញ 30</option>
	                        <option value="1">បង្ហាញ 50</option>
	                    </select>
	                </div>
	                <div class="pagination">
	                    <a href="#" class="prev-arrow"><i class="fa fa-long-arrow-left" aria-hidden="true"></i></a>
	                    <a href="#" class="active">1</a>
	                    <a href="#">2</a>
	                    <a href="#">3</a>
	                    <a href="#" class="dot-dot"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></a>
	                    <a href="#">6</a>
	                    <a href="#" class="next-arrow"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
	                </div>
	            </div>
	            <!-- End Filter Bar -->
	            <!-- Start Best Seller -->
	            <section class="lattest-product-area pb-40 category-list">
	                <div class="row">

	                    <!-- single product -->
	                    <div class="col-lg-3 col-md-6">
	                        <div class="single-product">
	                            <img class="img-fluid" src="{{asset('frontend/assets/img/product/p1.jpg')}}" alt="">
	                            <div class="product-details">
	                                <h6>addidas New Hammer sole
	                                    for Sports person</h6>
	                                <div class="price">
	                                    <h6>$150.00</h6>
	                                    <h6 class="l-through">$210.00</h6>
	                                </div>
	                                <div class="prd-bottom">

	                                    <a href="{{url('/cart')}}" class="social-info">
	                                        <span class="ti-bag"></span>
	                                        <p class="hover-text">បន្តែមចូលកន្ត្រក</p>
	                                    </a>

	                                    <a href="{{url('/productDetail')}}" class="social-info">
	                                        <span class="lnr lnr-move"></span>
	                                        <p class="hover-text">បង្ហាញបន្តែម</p>
	                                    </a>
	                                    </a>
	                                </div>
	                            </div>
	                        </div>
	                    </div>
	                    <!-- single product -->
	                    <div class="col-lg-3 col-md-6">
	                        <div class="single-product">
	                            <img class="img-fluid" src="{{asset('frontend/assets/img/product/p2.jpg')}}" alt="">
	                            <div class="product-details">
	                                <h6>addidas New Hammer sole
	                                    for Sports person</h6>
	                                <div class="price">
	                                    <h6>$150.00</h6>
	                                    <h6 class="l-through">$210.00</h6>
	                                </div>
	                                <div class="prd-bottom">

	                                    <a href="{{url('/cart')}}" class="social-info">
	                                        <span class="ti-bag"></span>
	                                        <p class="hover-text">បន្តែមចូលកន្ត្រក</p>
	                                    </a>

	                                    <a href="{{url('/productDetail')}}" class="social-info">
	                                        <span class="lnr lnr-move"></span>
	                                        <p class="hover-text">បង្ហាញបន្តែម</p>
	                                    </a>
	                                    </a>
	                                </div>
	                            </div>
	                        </div>
	                    </div>
	                    <!-- single product -->
	                    <div class="col-lg-3 col-md-6">
	                        <div class="single-product">
	                            <img class="img-fluid" src="{{asset('frontend/assets/img/product/p3.jpg')}}" alt="">
	                            <div class="product-details">
	                                <h6>addidas New Hammer sole
	                                    for Sports person</h6>
	                                <div class="price">
	                                    <h6>$150.00</h6>
	                                    <h6 class="l-through">$210.00</h6>
	                                </div>
	                                <div class="prd-bottom">
	                                    <a href="{{url('/cart')}}" class="social-info">
	                                        <span class="ti-bag"></span>
	                                        <p class="hover-text">បន្តែមចូលកន្ត្រក</p>
	                                    </a>

	                                    <a href="{{url('/productDetail')}}" class="social-info">
	                                        <span class="lnr lnr-move"></span>
	                                        <p class="hover-text">បង្ហាញបន្តែម</p>
	                                    </a>
	                                    </a>
	                                </div>
	                            </div>
	                        </div>
	                    </div>
	                    <!-- single product -->
	                    <div class="col-lg-3 col-md-6">
	                        <div class="single-product">
	                            <img class="img-fluid" src="{{asset('frontend/assets/img/product/p4.jpg')}}" alt="">
	                            <div class="product-details">
	                                <h6>addidas New Hammer sole
	                                    for Sports person</h6>
	                                <div class="price">
	                                    <h6>$150.00</h6>
	                                    <h6 class="l-through">$210.00</h6>
	                                </div>
	                                <div class="prd-bottom">

	                                    <a href="{{url('/cart')}}" class="social-info">
	                                        <span class="ti-bag"></span>
	                                        <p class="hover-text">បន្តែមចូលកន្ត្រក</p>
	                                    </a>

	                                    <a href="{{url('/productDetail')}}" class="social-info">
	                                        <span class="lnr lnr-move"></span>
	                                        <p class="hover-text">បង្ហាញបន្តែម</p>
	                                    </a>
	                                    </a>
	                                </div>
	                            </div>
	                        </div>
	                    </div>

	                    <!-- single product -->
	                    <div class="col-lg-3 col-md-6">
	                        <div class="single-product">
	                            <img class="img-fluid" src="{{asset('frontend/assets/img/product/p5.jpg')}}" alt="">
	                            <div class="product-details">
	                                <h6>addidas New Hammer sole
	                                    for Sports person</h6>
	                                <div class="price">
	                                    <h6>$150.00</h6>
	                                    <h6 class="l-through">$210.00</h6>
	                                </div>
	                                <div class="prd-bottom">

	                                    <a href="{{url('/cart')}}" class="social-info">
	                                        <span class="ti-bag"></span>
	                                        <p class="hover-text">បន្តែមចូលកន្ត្រក</p>
	                                    </a>

	                                    <a href="{{url('/productDetail')}}" class="social-info">
	                                        <span class="lnr lnr-move"></span>
	                                        <p class="hover-text">បង្ហាញបន្តែម</p>
	                                    </a>
	                                    </a>
	                                </div>
	                            </div>
	                        </div>
	                    </div>
	                    <!-- single product -->
	                    <div class="col-lg-3 col-md-6">
	                        <div class="single-product">
	                            <img class="img-fluid" src="{{asset('frontend/assets/img/product/p6.jpg')}}" alt="">
	                            <div class="product-details">
	                                <h6>addidas New Hammer sole
	                                    for Sports person</h6>
	                                <div class="price">
	                                    <h6>$150.00</h6>
	                                    <h6 class="l-through">$210.00</h6>
	                                </div>
	                                <div class="prd-bottom">

	                                    <a href="{{url('/cart')}}" class="social-info">
	                                        <span class="ti-bag"></span>
	                                        <p class="hover-text">បន្តែមចូលកន្ត្រក</p>
	                                    </a>

	                                    <a href="{{url('/productDetail')}}" class="social-info">
	                                        <span class="lnr lnr-move"></span>
	                                        <p class="hover-text">បង្ហាញបន្តែម</p>
	                                    </a>
	                                    </a>
	                                </div>
	                            </div>
	                        </div>
	                    </div>
	                    <!-- single product -->
	                    <div class="col-lg-3 col-md-6">
	                        <div class="single-product">
	                            <img class="img-fluid" src="{{asset('frontend/assets/img/product/p7.jpg')}}" alt="">
	                            <div class="product-details">
	                                <h6>addidas New Hammer sole
	                                    for Sports person</h6>
	                                <div class="price">
	                                    <h6>$150.00</h6>
	                                    <h6 class="l-through">$210.00</h6>
	                                </div>
	                                <div class="prd-bottom">

	                                    <a href="{{url('/cart')}}" class="social-info">
	                                        <span class="ti-bag"></span>
	                                        <p class="hover-text">បន្តែមចូលកន្ត្រក</p>
	                                    </a>

	                                    <a href="{{url('/productDetail')}}" class="social-info">
	                                        <span class="lnr lnr-move"></span>
	                                        <p class="hover-text">បង្ហាញបន្តែម</p>
	                                    </a>
	                                    </a>
	                                </div>
	                            </div>
	                        </div>
	                    </div>
	                    <!-- single product -->
	                    <div class="col-lg-3 col-md-6">
	                        <div class="single-product">
	                            <img class="img-fluid" src="{{asset('frontend/assets/img/product/p8.jpg')}}" alt="">
	                            <div class="product-details">
	                                <h6>addidas New Hammer sole
	                                    for Sports person</h6>
	                                <div class="price">
	                                    <h6>$150.00</h6>
	                                    <h6 class="l-through">$210.00</h6>
	                                </div>
	                                <div class="prd-bottom">

	                                    <a href="{{url('/cart')}}" class="social-info">
	                                        <span class="ti-bag"></span>
	                                        <p class="hover-text">បន្តែមចូលកន្ត្រក</p>
	                                    </a>

	                                    <a href="{{url('/productDetail')}}" class="social-info">
	                                        <span class="lnr lnr-move"></span>
	                                        <p class="hover-text">បង្ហាញបន្តែម</p>
	                                    </a>
	                                    </a>
	                                </div>
	                            </div>
	                        </div>
	                    </div><!-- single product -->
	                    <div class="col-lg-3 col-md-6">
	                        <div class="single-product">
	                            <img class="img-fluid" src="{{asset('frontend/assets/img/product/p5.jpg')}}" alt="">
	                            <div class="product-details">
	                                <h6>addidas New Hammer sole
	                                    for Sports person</h6>
	                                <div class="price">
	                                    <h6>$150.00</h6>
	                                    <h6 class="l-through">$210.00</h6>
	                                </div>
	                                <div class="prd-bottom">

	                                    <a href="{{url('/cart')}}" class="social-info">
	                                        <span class="ti-bag"></span>
	                                        <p class="hover-text">បន្តែមចូលកន្ត្រក</p>
	                                    </a>

	                                    <a href="{{url('/productDetail')}}" class="social-info">
	                                        <span class="lnr lnr-move"></span>
	                                        <p class="hover-text">បង្ហាញបន្តែម</p>
	                                    </a>
	                                    </a>
	                                </div>
	                            </div>
	                        </div>
	                    </div>
	                    <!-- single product -->
	                    <div class="col-lg-3 col-md-6">
	                        <div class="single-product">
	                            <img class="img-fluid" src="{{asset('frontend/assets/img/product/p6.jpg')}}" alt="">
	                            <div class="product-details">
	                                <h6>addidas New Hammer sole
	                                    for Sports person</h6>
	                                <div class="price">
	                                    <h6>$150.00</h6>
	                                    <h6 class="l-through">$210.00</h6>
	                                </div>
	                                <div class="prd-bottom">

	                                    <a href="{{url('/cart')}}" class="social-info">
	                                        <span class="ti-bag"></span>
	                                        <p class="hover-text">បន្តែមចូលកន្ត្រក</p>
	                                    </a>

	                                    <a href="{{url('/productDetail')}}" class="social-info">
	                                        <span class="lnr lnr-move"></span>
	                                        <p class="hover-text">បង្ហាញបន្តែម</p>
	                                    </a>
	                                    </a>
	                                </div>
	                            </div>
	                        </div>
	                    </div>
	                    <!-- single product -->
	                    <div class="col-lg-3 col-md-6">
	                        <div class="single-product">
	                            <img class="img-fluid" src="{{asset('frontend/assets/img/product/p7.jpg')}}" alt="">
	                            <div class="product-details">
	                                <h6>addidas New Hammer sole
	                                    for Sports person</h6>
	                                <div class="price">
	                                    <h6>$150.00</h6>
	                                    <h6 class="l-through">$210.00</h6>
	                                </div>
	                                <div class="prd-bottom">

	                                    <a href="{{url('/cart')}}" class="social-info">
	                                        <span class="ti-bag"></span>
	                                        <p class="hover-text">បន្តែមចូលកន្ត្រក</p>
	                                    </a>

	                                    <a href="{{url('/productDetail')}}" class="social-info">
	                                        <span class="lnr lnr-move"></span>
	                                        <p class="hover-text">បង្ហាញបន្តែម</p>
	                                    </a>
	                                    </a>
	                                </div>
	                            </div>
	                        </div>
	                    </div>
	                    <!-- single product -->
	                    <div class="col-lg-3 col-md-6">
	                        <div class="single-product">
	                            <img class="img-fluid" src="{{asset('frontend/assets/img/product/p8.jpg')}}" alt="">
	                            <div class="product-details">
	                                <h6>addidas New Hammer sole
	                                    for Sports person</h6>
	                                <div class="price">
	                                    <h6>$150.00</h6>
	                                    <h6 class="l-through">$210.00</h6>
	                                </div>
	                                <div class="prd-bottom">

	                                    <a href="{{url('/cart')}}" class="social-info">
	                                        <span class="ti-bag"></span>
	                                        <p class="hover-text">បន្តែមចូលកន្ត្រក</p>
	                                    </a>

	                                    <a href="{{url('/productDetail')}}" class="social-info">
	                                        <span class="lnr lnr-move"></span>
	                                        <p class="hover-text">បង្ហាញបន្តែម</p>
	                                    </a>
	                                    </a>
	                                </div>
	                            </div>
	                        </div>
	                    </div>

	                </div>
	            </section>
	            <!-- End Best Seller -->
	            <!-- Start Filter Bar -->
	            <div class="filter-bar d-flex flex-wrap align-items-center">
	                <div class="sorting mr-auto">
	                    <select>
	                        <option value="1">បង្ហាញ 10</option>
	                        <option value="1">បង្ហាញ 30</option>
	                        <option value="1">បង្ហាញ 50</option>
	                    </select>
	                </div>
	                <div class="pagination">
	                    <a href="#" class="prev-arrow"><i class="fa fa-long-arrow-left" aria-hidden="true"></i></a>
	                    <a href="#" class="active">1</a>
	                    <a href="#">2</a>
	                    <a href="#">3</a>
	                    <a href="#" class="dot-dot"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></a>
	                    <a href="#">6</a>
	                    <a href="#" class="next-arrow"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
	                </div>
	            </div>
	            <!-- End Filter Bar -->
	        </div>
	    </div>
	</div>


	@endsection

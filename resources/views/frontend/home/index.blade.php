@extends('frontend.layouts.master')
@section('content')

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
                                {{-- <div class="add-bag d-flex align-items-center">
									<a class="add-btn" href="#"><span class="lnr lnr-cross"></span></a>
									<span class="add-text text-uppercase">បន្តែមចូលកន្ត្រក</span>
								</div> --}}
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="banner-img">
                                <img class="img-fluid" src="{{asset('frontend/assets/img/banner/banner-img.png')}}" alt="">
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
                                {{-- <div class="add-bag d-flex align-items-center">
									<a class="add-btn" href="#"><span class="lnr lnr-cross"></span></a>
									<span class="add-text text-uppercase">បន្តែមចូលកន្ត្រក</span>
								</div> --}}
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="banner-img">
                                <img class="img-fluid" src="{{asset('frontend/assets/img/banner/banner-img1.png')}}" alt="">
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
                        <img src="{{asset('frontend/assets/img/features/f-icon1.png')}}" alt="">
                    </div>
                    <h6>ដឹកជញ្ជូនដោយឥតគិតថ្លៃ</h6>
                    <p>ឥតគិតថ្លៃលើការបញ្ជាទិញទាំងអស់</p>
                </div>
            </div>
            <!-- single features -->
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="single-features">
                    <div class="f-icon">
                        <img src="{{asset('frontend/assets/img/features/f-icon2.png')}}" alt="">
                    </div>
                    <h6>ការបង្វិលទំនិញត្រឡប់មកវិញ</h6>
                    <p>ឥតគិតថ្លៃលើការបញ្ជាទិញទាំងអស់</p>
                </div>
            </div>
            <!-- single features -->
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="single-features">
                    <div class="f-icon">
                        <img src="{{asset('frontend/assets/img/features/f-icon3.png')}}" alt="">
                    </div>
                    <h6>24/7 Support</h6>
                    <p>ឥតគិតថ្លៃលើការបញ្ជាទិញទាំងអស់</p>
                </div>
            </div>
            <!-- single features -->
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="single-features">
                    <div class="f-icon">
                        <img src="{{asset('frontend/assets/img/features/f-icon4.png')}}" alt="">
                    </div>
                    <h6>ការទូទាត់ប្រកបដោយសុវត្ថិភាព</h6>
                    <p>ឥតគិតថ្លៃលើការបញ្ជាទិញទាំងអស់</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- end features Area -->

<!-- start product Area -->
<section class="owl-carousel ">
    <!-- single product slide -->
    <div class="single-product-slider">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 text-center">
                    <div class="section-title">
                        <h1>ផលិតផលទើបនិងចេញ</h1>
                        <p>ផលិតផលល្អអាចត្រូវបានលក់ដោយការផ្សាយពាណិជ្ជកម្មដោយស្មោះត្រង់
                            បើ​អ្នក​មិន​គិត​ថា​ផលិតផល​ល្អ​ទេ អ្នក​គ្មាន​អាជីវកម្ម​ត្រូវ​ផ្សាយ​ពាណិជ្ជកម្ម​នោះ​ទេ។
                        </p>
                    </div>
                </div>
            </div>
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
        </div>
    </div>
</section>
<!-- end product Area -->

@endsection

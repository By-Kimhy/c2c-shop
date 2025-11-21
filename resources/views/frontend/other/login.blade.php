@extends('frontend.layout.master')
@section('content')

<!-- Start Banner Area -->
<section class="banner-area organic-breadcrumb">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
            <div class="col-first">
                <h1>ចូលក្នុងកម្មវិធី/ចុះឈ្មោះ</h1>
                <nav class="d-flex align-items-center">
                    <a href="#">ទំព័រដើម<span class="lnr lnr-arrow-right"></span></a>
                    <a href="#">ផ្សេងៗ<span class="lnr lnr-arrow-right"></span></a>
                    <a href="#">ចូលក្នុងកម្មវិធី/ចុះឈ្មោះ</a>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- End Banner Area -->

<!--================Login Box Area =================-->
<section class="login_box_area section_gap">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="login_box_img">
                    <img class="img-fluid" src="{{asset('frontend/assets/img/login.jpg')}}" alt="">
                    <div class="hover">
                        <h4>New to our website?</h4>
                        <p>មានការជឿនលឿនផ្នែកវិទ្យាសាស្ត្រ និងបច្ចេកវិទ្យាជារៀងរាល់ថ្ងៃ ហើយឧទាហរណ៍ដ៏ល្អមួយគឺ</p>
                        <a class="primary-btn" href="#">បង្កើត​គណនី</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="login_form_inner">
                    <h3>ចូលក្នុងកម្មវិធី</h3>
                    <form class="row login_form" action="https://themewagon.github.io/karma/contact_process.php" method="post" id="contactForm" novalidate="novalidate">
                        <div class="col-md-12 form-group">
                            <input type="text" class="form-control" id="name" name="name" placeholder="ឈ្មោះ​អ្នកប្រើប្រាស់" onfocus="this.placeholder = ''" onblur="this.placeholder = 'ឈ្មោះ​អ្នកប្រើប្រាស់'">
                        </div>
                        <div class="col-md-12 form-group">
                            <input type="text" class="form-control" id="name" name="name" placeholder="​លេខសំងាត់" onfocus="this.placeholder = ''" onblur="this.placeholder = '​លេខសំងាត់'">
                        </div>
                        <div class="col-md-12 form-group">
                            <div class="creat_account">
                                <input type="checkbox" id="f-option2" name="selector">
                                <label for="f-option2">រក្សា​នៅក្នុងប្រព័ន្ធ</label>
                            </div>
                        </div>
                        <div class="col-md-12 form-group">
                            <button type="submit" value="submit" class="primary-btn">ចូល</button>
                            <a href="#">ភ្លេច​លេខសំងាត់​?</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!--================End Login Box Area =================-->

@endsection

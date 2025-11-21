@extends('frontend.layout.master')
@section('content')

    <!-- Start Banner Area -->
    <section class="banner-area organic-breadcrumb">
        <div class="container">
            <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
                <div class="col-first">
                    <h1>ផ្ទៀងផ្ទាត់ផលិតផល</h1>
                    <nav class="d-flex align-items-center">
                        <a href="#">ទំព័រដើម<span class="lnr lnr-arrow-right"></span></a>
                        <a href="#">ផ្ទៀងផ្ទាត់ផលិតផល</a>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!-- End Banner Area -->

    <!--================Checkout Area =================-->
    <section class="checkout_area section_gap">
        <div class="container">
            <div class="billing_details">
                <div class="row">
                    <div class="col-lg-6">
                        <h3>ព័ត៌មានលម្អិតវិក្កយបត្រ</h3>
                        <form class="row contact_form" action="#" method="post" novalidate="novalidate">
                            <div class="col-md-6 form-group p_star">
                                <input type="text" class="form-control" id="first" name="name">
                                <span class="placeholder" data-placeholder="ត្រកូល"></span>
                            </div>
                            <div class="col-md-6 form-group p_star">
                                <input type="text" class="form-control" id="last" name="name">
                                <span class="placeholder" data-placeholder="នាម"></span>
                            </div>
                            <div class="col-md-6 form-group p_star">
                                <input type="text" class="form-control" id="number" name="number">
                                <span class="placeholder" data-placeholder="លេខទូរសព្ទ"></span>
                            </div>
                            <div class="col-md-6 form-group p_star">
                                <input type="text" class="form-control" id="email" name="compemailany">
                                <span class="placeholder" data-placeholder="អ៊ី​ម៉េ​ល"></span>
                            </div>
                            <div class="col-md-12 form-group p_star">
                                <input type="text" class="form-control" id="add1" name="add1">
                                <span class="placeholder" data-placeholder="អាស័យដ្ឋាន"></span>
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-6">
                        <div class="order_box">
                            <h2>ការបញ្ជាទិញរបស់អ្នក</h2>
                            <ul class="list">
                                <li><a href="#">ផលិតផល <span>សរុប</span></a></li>
                                <li><a href="#">addidas <span class="middle">x 02</span> <span class="last">$720.00</span></a></li>
                                <li><a href="#">Nike    <span class="middle">x 02</span> <span class="last">$720.00</span></a></li>
                                <li><a href="#">PUMA    <span class="middle">x 02</span> <span class="last">$720.00</span></a></li>
                            </ul>
                            <ul class="list list_2">
                                <li><a href="#">សរុប <span>$2160.00</span></a></li>
                            </ul>
                            <a class="primary-btn" href="{{url('/comfirm')}}" id="checkout_button">បន្តបង់ប្រាក់</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================End Checkout Area =================-->

@endsection

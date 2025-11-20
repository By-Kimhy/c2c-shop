@extends('frontend.layout.master')
@section('content')

<!-- Start Banner Area -->
<section class="banner-area organic-breadcrumb">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
            <div class="col-first">
                <h1>ការបញ្ជាក់</h1>
                <nav class="d-flex align-items-center">
                    <a href="#">ទំព័រដើម<span class="lnr lnr-arrow-right"></span></a>
                    <a href="#">ការបញ្ជាក់</a>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- End Banner Area -->

<!--================Order Details Area =================-->
<section class="order_details section_gap">
    <div class="container">
        <h3 class="title_confirmation">សូមអរគុណ ការបញ្ជាទិញរបស់អ្នកទទួលបានជោគជ័យ</h3>
        <div class="row order_d_inner">
            <div class="col-lg-6">
                <div class="details_item">
                    <h4>ព័ត៌មានបញ្ជាទិញ</h4>
                    <ul class="list">
                        <li><a href="#"><span>លេខបញ្ជាទិញ</span> : 60235</a></li>
                        <li><a href="#"><span>កាលបរិច្ឆេទ</span> : 23/JUN/2024</a></li>
                        <li><a href="#"><span>សរុប</span> : USD 2210</a></li>
                        <li><a href="#"><span>វិធី​សា​ស្រ្ត​ទូទាត់</span> : ABA BANK</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="details_item">
                    <h4>អាសយដ្ឋានចេញវិក័យប័ត្រ</h4>
                    <ul class="list">
                        <li><a href="#"><span>ផ្លុវ</span> : 271</a></li>
                        <li><a href="#"><span>ក្រុង</span> : Phnom Penh</a></li>
                        <li><a href="#"><span>ប្រទេស</span> : Cambodia</a></li>
                        <li><a href="#"><span>Postcode </span> : 36952</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="order_details_table">
            <h2>ព័ត៌មានលម្អិតនៃការបញ្ជាទិញ</h2>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">ផលិតផល</th>
                            <th scope="col">ចំនួន</th>
                            <th scope="col">សរុប</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <p>addidas New Hammer sole​​ សម្រាប់អ្នកកីឡា</p>
                            </td>
                            <td>
                                <h5>x 02</h5>
                            </td>
                            <td>
                                <p>$720.00</p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>addidas New Hammer sole​​ សម្រាប់អ្នកកីឡា</p>
                            </td>
                            <td>
                                <h5>x 02</h5>
                            </td>
                            <td>
                                <p>$720.00</p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>addidas New Hammer sole​​ សម្រាប់អ្នកកីឡា</p>
                            </td>
                            <td>
                                <h5>x 02</h5>
                            </td>
                            <td>
                                <p>$720.00</p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <h4>សរុបទឹកប្រាក់</h4>
                            </td>
                            <td>
                                <h5></h5>
                            </td>
                            <td>
                                <p>$2160.00</p>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
		<div class="container mt-5">
    <div class="row">
        <div class="col-12 d-flex justify-content-end">
            <a href="{{ route('invoice') }}" target="_blank" class="btn btn-primary px-4 py-2" style="font-size: 16px; border-radius: 6px;">
                ទាញយក / បោះពុម្ពវិក្កយបត្រ
            </a>
        </div>
    </div>

</section>
<!--================End Order Details Area =================-->

</div>

</div>
@endsection

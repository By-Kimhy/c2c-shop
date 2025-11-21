@extends('frontend.layout.master')
@section('content')

<!-- Start Banner Area -->
    <section class="banner-area organic-breadcrumb">
        <div class="container">
            <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
                <div class="col-first">
                    <h1>ការតាមដានការបញ្ជាទិញ</h1>
                    <nav class="d-flex align-items-center">
                        <a href="index.html">ទំព័រដើម<span class="lnr lnr-arrow-right"></span></a>
                        <a href="#">ផ្សេងៗ<span class="lnr lnr-arrow-right"></span></a>
                        <a href="#">ការតាមដានការបញ្ជាទិញ</a>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!-- End Banner Area -->

    <!--================Tracking Box Area =================-->
    <section class="tracking_box_area section_gap">
        <div class="container">
            <div class="tracking_box_inner">
                <p>ដើម្បីតាមដានការបញ្ជាទិញរបស់អ្នក សូមបញ្ចូលលេខសម្គាល់ការបញ្ជាទិញរបស់អ្នកនៅក្នុងប្រអប់ខាងក្រោម ហើយចុចប៊ូតុង "តាមដាន"
                    វាត្រូវបានផ្តល់ឱ្យអ្នកនៅលើបង្កាន់ដៃរបស់អ្នក និងនៅក្នុងអ៊ីមែលបញ្ជាក់ដែលអ្នកគួរបានទទួល។</p>
                <form class="row tracking_form" action="#" method="post" novalidate="novalidate">
                    <div class="col-md-12 form-group">
                        <input type="text" class="form-control" id="order" name="order" placeholder="Order ID" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Order ID'">
                    </div>
                    <div class="col-md-12 form-group">
                        <input type="email" class="form-control" id="email" name="email" placeholder="អាសយដ្ឋានអ៊ីមែលដែលចេញវិក្កយបត្រ" onfocus="this.placeholder = ''" onblur="this.placeholder = 'អាសយដ្ឋានអ៊ីមែលដែលចេញវិក្កយបត្រ'">
                    </div>
                    <div class="col-md-12 form-group">
                        <button type="submit" value="submit" class="primary-btn">តាមដានការបញ្ជាទិញ</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!--================End Tracking Box Area =================-->

@endsection
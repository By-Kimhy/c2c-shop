@extends('frontend.layout.master')
@section('content')

<!-- Start Banner Area -->
<section class="banner-area organic-breadcrumb">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
            <div class="col-first">
                <h1>ទាក់ទងមកយើង</h1>
                <nav class="d-flex align-items-center">
                    <a href="index.html">ទំព័រដើម<span class="lnr lnr-arrow-right"></span></a>
                    <a href="#">ទាក់ទងមកយើង</a>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- End Banner Area -->

<!--================Contact Area =================-->
<section class="contact_area section_gap_bottom">
    <div class="container">
        <div id="mapBox" class="mapBox" data-lat="11.576341" data-lon="104.918202" data-zoom="13" data-info="No. 86A, Street 110, Russian Federation Blvd (110), Phnom Penh, Cambodia." data-mlat="11.576341" data-mlon="104.918202">
        </div>
        <div class="row">
            <div class="col-lg-3">
                <div class="contact_info">
                    <div class="info_item">
                        <i class="lnr lnr-home"></i>
                        <h6>រាជធានីភ្នំពេញ ប្រទេសកម្ពុជា</h6>
                        <p>មហាវិថីសហព័ន្ធរុស្ស៊ី សង្កាត់ទឹកល្អក់១ ខណ្ឌទួលគោក </p>
                    </div>
                    <div class="info_item">
                        <i class="lnr lnr-phone-handset"></i>
                        <h6><a href="#">+៨៥៥ ១២ ៣៤៥ ៦៧៨</a></h6>
                        <p>ច័ន្ទ ដល់ សុក្រ ម៉ោង ៩ ព្រឹក ដល់ ៦ ល្ងាច</p>
                    </div>
                    <div class="info_item">
                        <i class="lnr lnr-envelope"></i>
                        <h6><a href="#">EcommerceC2C@ST5.com</a></h6>
                        <p>ផ្ញើសំណួររបស់អ្នកមកយើងគ្រប់ពេល!</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                <form class="row contact_form" action="https://themewagon.github.io/karma/contact_process.php" method="post" id="contactForm" novalidate="novalidate">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" class="form-control" id="name" name="name" placeholder="បញ្ចូល​ឈ្មោះ​របស់​អ្នក" onfocus="this.placeholder = ''" onblur="this.placeholder = 'បញ្ចូល​ឈ្មោះ​របស់​អ្នក'">
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control" id="email" name="email" placeholder="បញ្ចូលអាសយដ្ឋានអ៊ីមែល" onfocus="this.placeholder = ''" onblur="this.placeholder = 'បញ្ចូលអាសយដ្ឋានអ៊ីមែល'">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="subject" name="subject" placeholder="បញ្ចូលប្រធានបទ" onfocus="this.placeholder = ''" onblur="this.placeholder = 'បញ្ចូលប្រធានបទ'">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <textarea class="form-control" name="message" id="message" rows="1" placeholder="បញ្ចូលសារ" onfocus="this.placeholder = ''" onblur="this.placeholder = 'បញ្ចូលសារ'"></textarea>
                        </div>
                    </div>
                    <div class="col-md-12 text-right">
                        <button type="submit" value="submit" class="primary-btn">ផ្ញើ​សារ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<!--================Contact Area =================-->



@endsection

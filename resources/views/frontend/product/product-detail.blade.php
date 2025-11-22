	@extends('frontend.layout.master')
	@section('content')

	<!-- Start Banner Area -->
	<section class="banner-area organic-breadcrumb">
	    <div class="container">
	        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
	            <div class="col-first">
	                <h1>ព័ត៌មានលម្អិតអំពីផលិតផល</h1>
	                <nav class="d-flex align-items-center">
	                    <a href="index.html">ទំព័រដើម<span class="lnr lnr-arrow-right"></span></a>
	                    <a href="#">ទំនិញ<span class="lnr lnr-arrow-right"></span></a>
	                    <a href="#">ព័ត៌មានលម្អិតអំពីផលិតផល</a>
	                </nav>
	            </div>
	        </div>
	    </div>
	</section>
	<!-- End Banner Area -->

	{{-- <!--================Single Product Area =================-->
	<div class="product_image_area">
	    <div class="container">
	        <div class="row s_product_inner">
	            <div class="col-lg-6">
	                <div class="s_Product_carousel">
	                    <div class="single-prd-item">
	                        <img class="img-fluid" src="{{asset('frontend/assets/img/category/s-p1.jpg')}}" alt="">
	</div>
	<div class="single-prd-item">
	    <img class="img-fluid" src="{{asset('frontend/assets/img/category/s-p1.jpg')}}" alt="">
	</div>
	<div class="single-prd-item">
	    <img class="img-fluid" src="{{asset('frontend/assets/img/category/s-p1.jpg')}}" alt="">
	</div>
	</div>
	</div>
	<div class="col-lg-5 offset-lg-1">
	    <div class="s_product_text">
	        <h3>addidas New Hammer sole</h3>
	        <h2>$149.99</h2>
	        <ul class="list">
	            <li><a class="active" href="#"><span>ប្រភេទ</span> : Household</a></li>
	            <li><a href="#"><span>ស្តុក</span> : មានក្នុងស្តុក</a></li>
	        </ul>
	        <p>ស្បែកជើងទម្ងន់ស្រាលទាំងនេះមានផាសុកភាព និងឆ្លើយតប
	            ដូច្នេះអ្នកអាចលេងហ្គេមរបស់អ្នកតាមរបៀបដែលអ្នកចង់បាន។ ពួកវាងាយស្រួលបំបែក
	            ហើយអ្នកគួរតែជ្រើសរើសទំហំធម្មតារបស់អ្នក ឬបង្កើនទំហំពាក់កណ្តាលសម្រាប់ទំហំធំទូលាយ។</p>
	        <div class="product_count">
	            <label for="qty">ចំនួន:</label>
	            <input type="text" name="qty" id="sst" maxlength="12" value="1" title="Quantity:" class="input-text qty">
	            <button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst )) result.value++;return false;" class="increase items-count" type="button"><i class="lnr lnr-chevron-up"></i></button>
	            <button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst ) && sst > 0 ) result.value--;return false;" class="reduced items-count" type="button"><i class="lnr lnr-chevron-down"></i></button>
	        </div>
	        <div class="card_area d-flex align-items-center">
	            <a class="primary-btn" href="{{url('/cart')}}">បន្តែមចូលកន្ត្រក</a>

	        </div>
	    </div>
	</div>
	</div>
	</div>
	</div>
	<!--================End Single Product Area =================-->

	<!--================Product Description Area =================-->
	<section class="product_description_area">
	    <div class="container">
	        <ul class="nav nav-tabs" id="myTab" role="tablist">
	            <li class="nav-item">
	                <a class="nav-link" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">ការពិពណ៌នា</a>
	            </li>
	            <li class="nav-item">
	                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">ការបញ្ជាក់</a>
	            </li>
	            <li class="nav-item">
	                <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">មតិយោបល់</a>
	            </li>
	            <li class="nav-item">
	                <a class="nav-link active" id="review-tab" data-toggle="tab" href="#review" role="tab" aria-controls="review" aria-selected="false">ពិនិត្យ</a>
	            </li>
	        </ul>
	        <div class="tab-content" id="myTabContent">
	            <div class="tab-pane fade" id="home" role="tabpanel" aria-labelledby="home-tab">
	                <p>ពេលខ្លះការរចនាដ៏សាមញ្ញគឺជាការរចនាដ៏ល្អបំផុត ហើយស្លាយ adidas ទាំងនេះរួមបញ្ចូលវា។ ជាមួយមួយដុំ
	                    ការសាងសង់ ពួកគេមានជើង Molded EVA ដែលខ្នើយគ្រប់ជំហាន និងស្ងួតយ៉ាងលឿន។ របស់ពួកគេ។
	                    រូប​រាង​ស្លីម​រលោង​ឆ្លុះ​បញ្ចាំង​ពី​បេះដូង​របស់​អាឌីដាស៖ រូបរាង​រលោង​ធ្វើ​ឱ្យ​មាន​មុខងារ​សម្រាប់​រាល់​ថ្ងៃ។
	                </p>
	            </div>
	            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
	                <div class="table-responsive">
	                    <table class="table">
	                        <tbody>
	                            <tr>
	                                <td>
	                                    <h5>ទទឹង</h5>
	                                </td>
	                                <td>
	                                    <h5>128mm</h5>
	                                </td>
	                            </tr>
	                            <tr>
	                                <td>
	                                    <h5>កម្ពស់</h5>
	                                </td>
	                                <td>
	                                    <h5>508mm</h5>
	                                </td>
	                            </tr>
	                            <tr>
	                                <td>
	                                    <h5>ជម្រៅ</h5>
	                                </td>
	                                <td>
	                                    <h5>85mm</h5>
	                                </td>
	                            </tr>
	                            <tr>
	                                <td>
	                                    <h5>ទម្ងន់</h5>
	                                </td>
	                                <td>
	                                    <h5>52gm</h5>
	                                </td>
	                            </tr>
	                            <tr>
	                                <td>
	                                    <h5>ការត្រួតពិនិត្យគុណភាព</h5>
	                                </td>
	                                <td>
	                                    <h5>មានគុណភាព</h5>
	                                </td>
	                            </tr>
	                            <tr>
	                                <td>
	                                    <h5>ប្រអប់នីមួយៗមាន</h5>
	                                </td>
	                                <td>
	                                    <h5>60pcs</h5>
	                                </td>
	                            </tr>
	                        </tbody>
	                    </table>
	                </div>
	            </div>
	            <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
	                <div class="row">
	                    <div class="col-lg-6">
	                        <div class="comment_list">
	                            <div class="review_item">
	                                <div class="media">
	                                    <div class="d-flex">
	                                        <img src="{{asset('frontend/assets/img/product/review-1.png')}}" alt="">
	                                    </div>
	                                    <div class="media-body">
	                                        <h4>Blake Ruiz</h4>
	                                        <h5>12th Feb, 2018 at 05:56 pm</h5>
	                                        <a class="reply_btn" href="#">Reply</a>
	                                    </div>
	                                </div>
	                                <p>Great arch support and lighter than previous versions. Curious to see how they hold up.</p>
	                            </div>
	                            <div class="review_item reply">
	                                <div class="media">
	                                    <div class="d-flex">
	                                        <img src="{{asset('frontend/assets/img/product/review-2.png')}}" alt="">
	                                    </div>
	                                    <div class="media-body">
	                                        <h4>Blake Ruiz</h4>
	                                        <h5>12th Feb, 2018 at 05:56 pm</h5>
	                                        <a class="reply_btn" href="#">Reply</a>
	                                    </div>
	                                </div>
	                                <p>Comfy. Good quality. Great for any project. I use it mainly in the house and it’s perfect. I have wide feet and had to size up. But still the length and width is good.</p>
	                            </div>
	                            <div class="review_item">
	                                <div class="media">
	                                    <div class="d-flex">
	                                        <img src="{{asset('frontend/assets/img/product/review-3.png')}}" alt="">
	                                    </div>
	                                    <div class="media-body">
	                                        <h4>Blake Ruiz</h4>
	                                        <h5>12th Feb, 2018 at 05:56 pm</h5>
	                                        <a class="reply_btn" href="#">Reply</a>
	                                    </div>
	                                </div>
	                                <p>very nice fit and nice fitting because it fit nicelys</p>
	                            </div>
	                        </div>
	                    </div>
	                    <div class="col-lg-6">
	                        <div class="review_box">
	                            <h4>បង្ហោះមតិ</h4>
	                            <form class="row contact_form" action="https://themewagon.github.io/karma/contact_process.php" method="post" id="contactForm" novalidate="novalidate">
	                                <div class="col-md-12">
	                                    <div class="form-group">
	                                        <input type="text" class="form-control" id="name" name="name" placeholder="ឈ្មោះ​ពេញ​របស់​អ្នក">
	                                    </div>
	                                </div>
	                                <div class="col-md-12">
	                                    <div class="form-group">
	                                        <input type="email" class="form-control" id="email" name="email" placeholder="អ៊ី​ម៉េ​ល">
	                                    </div>
	                                </div>
	                                <div class="col-md-12">
	                                    <div class="form-group">
	                                        <input type="text" class="form-control" id="number" name="number" placeholder="លេខទូរសព្ទ">
	                                    </div>
	                                </div>
	                                <div class="col-md-12">
	                                    <div class="form-group">
	                                        <textarea class="form-control" name="message" id="message" rows="1" placeholder="សារ"></textarea>
	                                    </div>
	                                </div>
	                                <div class="col-md-12 text-right">
	                                    <button type="submit" value="submit" class="btn primary-btn">ដាក់ស្នើ</button>
	                                </div>
	                            </form>
	                        </div>
	                    </div>
	                </div>
	            </div>
	            <div class="tab-pane fade show active" id="review" role="tabpanel" aria-labelledby="review-tab">
	                <div class="row">
	                    <div class="col-lg-6">
	                        <div class="row total_rate">
	                            <div class="col-6">
	                                <div class="box_total">
	                                    <h5>សរុប</h5>
	                                    <h4>4.0</h4>
	                                    <h6>(03 ពិនិត្យ)</h6>
	                                </div>
	                            </div>
	                            <div class="col-6">
	                                <div class="rating_list">
	                                    <h3>ផ្អែកលើ 3 ការពិនិត្យឡើងវិញ</h3>
	                                    <ul class="list">
	                                        <li><a href="#">5 ផ្កាយ <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i> 01</a></li>
	                                        <li><a href="#">4 ផ្កាយ <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i> 01</a></li>
	                                        <li><a href="#">3 ផ្កាយ <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i> 01</a></li>
	                                        <li><a href="#">2 ផ្កាយ <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i> 01</a></li>
	                                        <li><a href="#">1 ផ្កាយ <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i> 01</a></li>
	                                    </ul>
	                                </div>
	                            </div>
	                        </div>
	                        <div class="review_list">
	                            <div class="review_item">
	                                <div class="media">
	                                    <div class="d-flex">
	                                        <img src="{{asset('frontend/assets/img/product/review-1.png')}}" alt="">
	                                    </div>
	                                    <div class="media-body">
	                                        <h4>Blake Ruiz</h4>
	                                        <i class="fa fa-star"></i>
	                                        <i class="fa fa-star"></i>
	                                        <i class="fa fa-star"></i>
	                                        <i class="fa fa-star"></i>
	                                        <i class="fa fa-star"></i>
	                                    </div>
	                                </div>
	                                <p>Great arch support and lighter than previous versions. Curious to see how they hold up.</p>
	                            </div>
	                            <div class="review_item">
	                                <div class="media">
	                                    <div class="d-flex">
	                                        <img src="{{asset('frontend/assets/img/product/review-2.png')}}" alt="">
	                                    </div>
	                                    <div class="media-body">
	                                        <h4>Blake Ruiz</h4>
	                                        <i class="fa fa-star"></i>
	                                        <i class="fa fa-star"></i>
	                                        <i class="fa fa-star"></i>
	                                        <i class="fa fa-star"></i>
	                                        <i class="fa fa-star"></i>
	                                    </div>
	                                </div>
	                                <p>Comfy. Good quality. Great for any project. I use it mainly in the house and it’s perfect. I have wide feet and had to size up. But still the length and width is good.</p>
	                            </div>
	                            <div class="review_item">
	                                <div class="media">
	                                    <div class="d-flex">
	                                        <img src="{{asset('frontend/assets/img/product/review-3.png')}}" alt="">
	                                    </div>
	                                    <div class="media-body">
	                                        <h4>Blake Ruiz</h4>
	                                        <i class="fa fa-star"></i>
	                                        <i class="fa fa-star"></i>
	                                        <i class="fa fa-star"></i>
	                                        <i class="fa fa-star"></i>
	                                        <i class="fa fa-star"></i>
	                                    </div>
	                                </div>
	                                <p>Great arch support and lighter than previous versions. Curious to see how they hold up.</p>
	                            </div>
	                        </div>
	                    </div>
	                    <div class="col-lg-6">
	                        <div class="review_box">
	                            <h4>បន្ថែមការពិនិត្យឡើងវិញ</h4>
	                            <p>ការវាយតម្លៃរបស់អ្នក:</p>
	                            <ul class="list">
	                                <li><a href="#"><i class="fa fa-star"></i></a></li>
	                                <li><a href="#"><i class="fa fa-star"></i></a></li>
	                                <li><a href="#"><i class="fa fa-star"></i></a></li>
	                                <li><a href="#"><i class="fa fa-star"></i></a></li>
	                                <li><a href="#"><i class="fa fa-star"></i></a></li>
	                            </ul>
	                            <p>ពូកែ</p>
	                            <form class="row contact_form" action="https://themewagon.github.io/karma/contact_process.php" method="post" id="contactForm" novalidate="novalidate">
	                                <div class="col-md-12">
	                                    <div class="form-group">
	                                        <input type="text" class="form-control" id="name" name="name" placeholder="ឈ្មោះ​ពេញ​របស់​អ្នក" onfocus="this.placeholder = ''" onblur="this.placeholder = 'ឈ្មោះ​ពេញ​របស់​អ្នក'">
	                                    </div>
	                                </div>
	                                <div class="col-md-12">
	                                    <div class="form-group">
	                                        <input type="email" class="form-control" id="email" name="email" placeholder="​អ៊ី​ម៉េ​ល" onfocus="this.placeholder = ''" onblur="this.placeholder = '​អ៊ី​ម៉េ​ល'">
	                                    </div>
	                                </div>
	                                <div class="col-md-12">
	                                    <div class="form-group">
	                                        <input type="text" class="form-control" id="number" name="number" placeholder="លេខទូរសព្ទ" onfocus="this.placeholder = ''" onblur="this.placeholder = 'លេខទូរសព្ទ'">
	                                    </div>
	                                </div>
	                                <div class="col-md-12">
	                                    <div class="form-group">
	                                        <textarea class="form-control" name="message" id="message" rows="1" placeholder="មតិយោបល់" onfocus="this.placeholder = ''" onblur="this.placeholder = 'មតិយោបល់'"></textarea></textarea>
	                                    </div>
	                                </div>
	                                <div class="col-md-12 text-right">
	                                    <button type="submit" value="submit" class="primary-btn">ដាក់ស្នើ</button>
	                                </div>
	                            </form>
	                        </div>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>
	</section>
	<!--================End Product Description Area =================-->

	@endsection --}}

	<div class="container my-4">
	    <div class="row">
	        <!-- Left: images -->
	        <div class="col-md-6">
	            @php
	            $images = is_array($product->images) ? $product->images : [];
	            // ensure all paths trimmed
	            $images = array_map(fn($i) => ltrim($i, '/'), $images);
	            $first = $images[0] ?? null;
	            $firstUrl = $first && \Illuminate\Support\Facades\Storage::disk('public')->exists($first)
	            ? asset('storage/' . $first)
	            : asset('frontend/assets/img/product/p4.jpg');
	            @endphp

	            <div class="product-gallery">
	                <div class="main-image mb-2">
	                    <img id="mainProductImage" src="{{ $firstUrl }}" class="img-fluid" style="width:100%; max-height:520px; object-fit:contain;" alt="{{ $product->name }}">
	                </div>

	                @if(count($images))
	                <div class="d-flex flex-wrap">
	                    @foreach($images as $img)
	                    @php
	                    $url = \Illuminate\Support\Facades\Storage::disk('public')->exists($img) ? asset('storage/'.$img) : asset('frontend/assets/img/product/p4.jpg');
	                    @endphp
	                    <div class="m-1" style="width:80px; height:80px; cursor:pointer;">
	                        <img class="img-thumbnail thumb-image" src="{{ $url }}" data-url="{{ $url }}" style="width:100%; height:100%; object-fit:cover;">
	                    </div>
	                    @endforeach
	                </div>
	                @else
	                <div class="text-muted">No images available.</div>
	                @endif
	            </div>
	        </div>

	        <!-- Right: product info -->
	        <div class="col-md-6">
	            <h2 class="mb-2">{{ $product->name }}</h2>

	            <div class="mb-3">
	                <strong class="h4">{{ number_format($product->price, 2) }} {{ config('app.currency', '$') }}</strong>
	                @if($product->stock <= 0) <span class="badge badge-danger ml-2">Out of stock</span>
	                    @else
	                    <small class="text-muted ml-2">In stock: {{ $product->stock }}</small>
	                    @endif
	            </div>

	            <div class="mb-2">
	                <span class="text-muted">Category: </span>
	                <strong>{{ optional($product->category)->name ?? '—' }}</strong>
	            </div>

	            <div class="mb-3">
	                <span class="text-muted">Seller: </span>
	                @if($product->user)
	                <strong>{{ $product->user->name }}</strong>
	                @if(optional($product->user->sellerProfile)->slug)
	                — <a href="{{ route('shop.show', $product->user->sellerProfile->slug) }}" target="_blank">Visit shop</a>
	                @endif
	                @else
	                <em class="text-warning">No seller linked</em>
	                @endif
	            </div>

	            <div class="mb-4">
	                <form method="POST" action="{{ url('/cart/add') }}">
	                    @csrf
	                    <input type="hidden" name="product_id" value="{{ $product->id }}">
	                    <div class="form-group row">
	                        <label class="col-sm-3 col-form-label">Quantity</label>
	                        <div class="col-sm-3">
	                            <input type="number" name="quantity" value="1" min="1" max="{{ max(1, $product->stock) }}" class="form-control">
	                        </div>
	                    </div>

	                    <div class="d-flex">
	                        <button class="btn btn-primary mr-2" {{ $product->stock <= 0 ? 'disabled' : '' }}>
	                            <i class="ti-bag"></i> Add to cart
	                        </button>

	                        <a href="{{ route('product.show', $product->id) }}" class="btn btn-outline-secondary">View full</a>
	                    </div>
	                </form>
	            </div>

	            <hr>

	            <h5>Description</h5>
	            <div class="product-description">
	                {!! nl2br(e($product->description ?: 'No description provided.')) !!}
	            </div>
	        </div>
	    </div>

	    {{-- Related products --}}
	    @if($related && $related->count())
	    <div class="row mt-5">
	        <div class="col-12">
	            <h4>Related Products</h4>
	        </div>
	        @foreach($related as $rp)
	        @php
	        $rthumb = is_array($rp->images) && count($rp->images) ? $rp->images[0] : null;
	        $rUrl = $rthumb && \Illuminate\Support\Facades\Storage::disk('public')->exists($rthumb) ? asset('storage/'.$rthumb) : asset('frontend/assets/img/product/p4.jpg');
	        @endphp
	        <div class="col-md-3 mb-3">
	            <div class="card h-100">
	                <a href="{{ route('product.show', $rp->id) }}">
	                    <img src="{{ $rUrl }}" class="card-img-top" style="height:160px; object-fit:cover;">
	                </a>
	                <div class="card-body p-2">
	                    <h6 class="card-title mb-1" style="font-size:14px;">{{ \Illuminate\Support\Str::limit($rp->name, 50) }}</h6>
	                    <div class="text-muted">{{ number_format($rp->price,2) }} {{ config('app.currency', '$') }}</div>
	                </div>
	            </div>
	        </div>
	        @endforeach
	    </div>
	    @endif
	</div>

	@endsection

	@push('scripts')
	<script>
	    // thumbnail click -> swap main image
	    document.addEventListener('click', function(e) {
	        if (e.target && e.target.classList.contains('thumb-image')) {
	            var url = e.target.getAttribute('data-url');
	            var main = document.getElementById('mainProductImage');
	            if (main && url) main.src = url;
	        }
	    });

	</script>
	@endpush

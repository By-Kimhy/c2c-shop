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

	@php
	use Illuminate\Support\Facades\Storage;
	$images = $product->images ?? [];
	// fallback placeholder
	$placeholder = asset('frontend/assets/img/product/p4.jpg');
	// compute URL for given relative path
	$imgUrl = function($rel) use ($placeholder) {
	if (! $rel) return $placeholder;
	$rel = ltrim($rel, '/');
	// check public disk existence
	if (Storage::disk('public')->exists($rel)) {
	return asset('storage/'.$rel);
	}
	// try legacy location: storage/app/private/public/...
	if (file_exists(storage_path('app/private/public/'.$rel))) {
	// This will still not be available via asset() unless linked - fallback to placeholder
	return $placeholder;
	}
	return $placeholder;
	};
	@endphp

	<section class="product-detail section_gap">
	    <div class="container">
	        <div class="row">

	            <!-- thumbnails column -->
	            <aside class="col-lg-2 d-none d-lg-block">
	                <div class="thumbs-list">
	                    @if(count($images))
	                    @foreach($images as $idx => $img)
	                    @php $url = $imgUrl($img); @endphp
	                    <div class="thumb-item mb-2">
	                        <img src="{{ $url }}" data-full="{{ $url }}" class="img-thumbnail thumb-click" style="width:100%; cursor:pointer; object-fit:cover; height:80px;" data-index="{{ $idx }}">
	                    </div>
	                    @endforeach
	                    @else
	                    <div class="thumb-item mb-2">
	                        <img src="{{ $placeholder }}" class="img-thumbnail" style="width:100%; object-fit:cover; height:80px;">
	                    </div>
	                    @endif
	                </div>
	            </aside>

	            <!-- main image + gallery -->
	            <div class="col-lg-6">
	                <div class="main-image mb-3 text-center">
	                    @php
	                    $first = $images[0] ?? null;
	                    $mainUrl = $imgUrl($first);
	                    @endphp
	                    <img id="product-main-image" src="{{ $mainUrl }}" alt="{{ $product->name }}" style="width:100%; max-height:520px; object-fit:cover; border-radius:6px;">
	                </div>

	                {{-- small carousel for mobile (thumbnails horizontally) --}}
	                <div class="d-block d-lg-none mb-3">
	                    <div class="mobile-thumbs d-flex overflow-auto">
	                        @if(count($images))
	                        @foreach($images as $idx => $img)
	                        @php $url = $imgUrl($img); @endphp
	                        <div style="min-width:90px; margin-right:8px;">
	                            <img src="{{ $url }}" data-full="{{ $url }}" class="img-thumbnail thumb-click" style="width:90px; height:60px; object-fit:cover; cursor:pointer;" data-index="{{ $idx }}">
	                        </div>
	                        @endforeach
	                        @endif
	                    </div>
	                </div>

	            </div>

	            <!-- product info -->
	            <div class="col-lg-4">
	                <h2>{{ $product->name }}</h2>
	                <div class="mb-2">
	                    <strong style="font-size:20px;">{{ number_format($product->price,2) }} {{ config('app.currency', '$') }}</strong>
	                </div>

	                <div class="mb-3">
	                    <span>Stock: {{ $product->stock }}</span> |
	                    <span>Category: {{ optional($product->category)->name ?? '—' }}</span>
	                </div>

	                <div class="mb-3">
	                    <p>{!! nl2br(e($product->description)) !!}</p>
	                </div>

	                {{-- <div class="mb-3">
	                    <form id="add-to-cart-form" method="post" action="{{ route('cart.add') }}">
	                @csrf
	                <input type="hidden" name="product_id" value="{{ $product->id }}">
	                <div class="form-group">
	                    <label>Quantity</label>
	                    <input type="number" name="qty" class="form-control" value="1" min="1" style="width:100px;">
	                </div>
	                <button type="submit" id="add-to-cart-btn" class="btn btn-primary">Add to cart</button>
	                </form>

	                <a href="{{ route('shop.show', optional($product->user->sellerProfile)->slug ?? '#') }}" class="btn btn-outline-secondary" target="_blank">Visit shop</a>
	            </div> --}}

	            <div class="p-3 border rounded-3 bg-white shadow-sm">
	                <form action="{{ route('cart.add') }}" method="POST" class="mb-3 qty-form">
	                    @csrf
	                    <input type="hidden" name="product_id" value="{{ $product->id }}">

	                    <label class="form-label mb-2 fw-semibold">Quantity</label>

	                    {{-- Desktop / wide: compact inline controls --}}
	                    <div class="qty-inline d-none d-sm-flex align-items-center mb-3" style="max-width:220px;">
	                        <button type="button" class="btn btn-outline-secondary btn-qty btn-decrease" aria-label="Decrease quantity">−</button>

	                        <input type="number" name="qty" value="1" min="1" step="1" class="form-control text-center mx-2 qty-input" style="width:80px;" aria-label="Quantity">

	                        <button type="button" class="btn btn-outline-secondary btn-qty btn-increase" aria-label="Increase quantity">+</button>
	                    </div>

	                    {{-- Mobile: stacked large controls --}}
	                    <div class="qty-stacked d-sm-none mb-3">
	                        <div class="d-flex gap-2">
	                            <button type="button" class="btn btn-outline-secondary flex-fill btn-qty btn-decrease" aria-label="Decrease quantity">−</button>
	                            <input type="number" name="qty" value="1" min="1" step="1" class="form-control text-center qty-input" aria-label="Quantity">
	                            <button type="button" class="btn btn-outline-secondary flex-fill btn-qty btn-increase" aria-label="Increase quantity">+</button>
	                        </div>
	                    </div>

	                    <button type="submit" class="btn btn-success w-100 py-2 fw-semibold">
	                        <span class="ti-bag me-2" aria-hidden="true"></span> Add to Cart
	                    </button>
	                </form>

	                <a href="{{ route('shop.show', optional($product->user->sellerProfile)->slug ?? '#') }}" class="btn btn-outline-secondary w-100">
	                    Visit Shop
	                </a>
	            </div>





	        </div>

	    </div>
	    </div>
	    {{-- Responsive qty behavior (paste once per page) --}}
	    <script>
	        document.addEventListener('DOMContentLoaded', function() {
	            // delegate within this form block
	            function setupQtyControls(root) {
	                const decreaseBtns = root.querySelectorAll('.btn-decrease');
	                const increaseBtns = root.querySelectorAll('.btn-increase');
	                const qtyInputs = root.querySelectorAll('.qty-input');

	                function clampInput(input) {
	                    const min = parseInt(input.getAttribute('min') || 1, 10);
	                    let val = parseInt(input.value || 0, 10);
	                    if (isNaN(val) || val < min) val = min;
	                    input.value = val;
	                    return val;
	                }

	                // plus / minus handlers
	                decreaseBtns.forEach(btn => {
	                    btn.addEventListener('click', () => {
	                        // affect nearest qty-input in same form
	                        const input = btn.closest('form').querySelector('.qty-input');
	                        if (!input) return;
	                        let val = clampInput(input);
	                        if (val > parseInt(input.getAttribute('min') || 1, 10)) {
	                            input.value = val - 1;
	                        }
	                        input.dispatchEvent(new Event('change', {
	                            bubbles: true
	                        }));
	                    });
	                });

	                increaseBtns.forEach(btn => {
	                    btn.addEventListener('click', () => {
	                        const input = btn.closest('form').querySelector('.qty-input');
	                        if (!input) return;
	                        let val = clampInput(input);
	                        input.value = val + 1;
	                        input.dispatchEvent(new Event('change', {
	                            bubbles: true
	                        }));
	                    });
	                });

	                // clamp on blur and prevent invalid keys
	                qtyInputs.forEach(input => {
	                    input.addEventListener('blur', () => clampInput(input));
	                    input.addEventListener('keydown', (e) => {
	                        // allow: backspace, delete, arrows, tab
	                        const allowed = ['Backspace', 'Delete', 'ArrowLeft', 'ArrowRight', 'Tab'];
	                        if (allowed.includes(e.key)) return;
	                        // allow digits
	                        if (e.key >= '0' && e.key <= '9') return;
	                        // block others
	                        if (e.key === 'Enter') {
	                            input.blur();
	                            return;
	                        }
	                        e.preventDefault();
	                    });
	                });
	            }

	            // initialize forms currently on page
	            document.querySelectorAll('.qty-form').forEach(form => setupQtyControls(form));
	        });

	    </script>

	    <style>
	        /* small visual polish — adjust sizing easily */
	        .btn-qty {
	            min-width: 44px;
	            min-height: 44px;
	            font-size: 1.1rem;
	            display: inline-flex;
	            align-items: center;
	            justify-content: center;
	            padding: 0.35rem 0.6rem;
	        }

	        .qty-input {
	            height: 44px;
	            font-size: 1rem;
	        }

	        @media (max-width: 576px) {
	            .qty-input {
	                height: 48px;
	                font-size: 1.05rem;
	            }

	            .btn-qty {
	                min-height: 48px;
	                font-size: 1.15rem;
	            }
	        }

	    </style>

	    <style>
	        .btn-success {
	            font-weight: 600;
	        }

	        .btn-success:hover {
	            opacity: .9;
	            transform: translateY(-1px);
	            transition: .15s;
	        }

	        .btn-outline-secondary:hover {
	            background: #f8f9fa;
	        }

	    </style>

	    <style>
	        /* keep thumbs column sticky on large screens */
	        .thumbs-list {
	            position: sticky;
	            top: 100px;
	        }

	        .thumb-item img.active-thumb {
	            outline: 3px solid #007bff;
	        }

	    </style>
	    <script>
	        document.addEventListener('DOMContentLoaded', function() {
	            const form = document.getElementById('add-to-cart-form');
	            const btn = document.getElementById('add-to-cart-btn');

	            form.addEventListener('submit', function(e) {
	                e.preventDefault();
	                btn.disabled = true;
	                const formData = new FormData(form);

	                fetch(form.action, {
	                        method: 'POST'
	                        , headers: {
	                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
	                            , 'Accept': 'application/json'
	                        }
	                        , body: formData
	                    })
	                    .then(response => {
	                        btn.disabled = false;
	                        if (!response.ok) throw response;
	                        return response.json();
	                    })
	                    .then(data => {
	                        if (data && data.success) {
	                            const badge = document.getElementById('cart-badge');
	                            if (badge) badge.textContent = (data.cart_count ? ? 0);
	                            const original = btn.innerHTML;
	                            btn.innerHTML = 'Added ✓';
	                            setTimeout(() => btn.innerHTML = original, 900);
	                        } else {
	                            alert('Could not add to cart');
	                        }
	                    })
	                    .catch(async err => {
	                        btn.disabled = false;
	                        let msg = 'Error adding to cart';
	                        try {
	                            const j = await err.json();
	                            msg = j.message || msg;
	                        } catch (e) {}
	                        alert(msg);
	                        console.error(err);
	                    });
	            });
	        });

	    </script>
	    <!-- Ajax script: place after page scripts or in a script stack -->
	    <script>
	        document.addEventListener('DOMContentLoaded', function() {
	            const form = document.getElementById('add-to-cart-form');
	            const btn = document.getElementById('add-to-cart-btn');

	            form.addEventListener('submit', function(e) {
	                // do AJAX if you prefer
	                e.preventDefault();
	                btn.disabled = true;
	                const formData = new FormData(form);

	                fetch("{{ route('cart.add') }}", {
	                    method: 'POST'
	                    , headers: {
	                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
	                        , 'Accept': 'application/json'
	                    }
	                    , body: formData
	                }).then(r => r.json()).then(data => {
	                    btn.disabled = false;
	                    if (data && data.success) {
	                        // update cart badge
	                        const badge = document.getElementById('cart-badge');
	                        if (badge) badge.textContent = data.cart_count ? ? 0;
	                        // optional: show a toast
	                        alert('Added to cart');
	                    } else {
	                        alert('Could not add to cart');
	                    }
	                }).catch(err => {
	                    btn.disabled = false;
	                    alert('Error adding to cart');
	                    console.error(err);
	                });
	            });
	        });

	    </script>

	    <script>
	        document.addEventListener('DOMContentLoaded', function() {
	            const mainImg = document.getElementById('product-main-image');
	            document.querySelectorAll('.thumb-click').forEach(function(el) {
	                el.addEventListener('click', function(e) {
	                    const src = el.getAttribute('data-full') || el.src;
	                    if (src) {
	                        mainImg.src = src;
	                        // toggle active class
	                        document.querySelectorAll('.thumb-click').forEach(t => t.classList.remove('active-thumb'));
	                        el.classList.add('active-thumb');
	                    }
	                });
	            });
	            // mark first thumbnail active
	            const firstThumb = document.querySelector('.thumb-click');
	            if (firstThumb) firstThumb.classList.add('active-thumb');
	        });

	    </script>

	</section>

	@endsection

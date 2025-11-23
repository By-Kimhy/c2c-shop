@extends('frontend.layout.master')
@section('content')

{{-- @if(session('error'))
  <div class="alert alert-danger">{{ session('error') }}</div>
@endif
@if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif --}}



<!-- Start Banner Area -->
<section class="banner-area organic-breadcrumb">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
            <div class="col-first">
                <h1>Shopping Cart</h1>
                <nav class="d-flex align-items-center">
                    <a href="index.html">Home<span class="lnr lnr-arrow-right"></span></a>
                    <a href="category.html">Cart</a>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- End Banner Area -->

{{-- <!--================Cart Area =================-->
    <section class="cart_area">
        <div class="container">
            <div class="cart_inner">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Product</th>
                                <th scope="col">Price</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="media">
                                        <div class="d-flex">
                                            <img src="img/cart.jpg" alt="">
                                        </div>
                                        <div class="media-body">
                                            <p>Minimalistic shop for multipurpose use</p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <h5>$360.00</h5>
                                </td>
                                <td>
                                    <div class="product_count">
                                        <input type="text" name="qty" id="sst" maxlength="12" value="1" title="Quantity:"
                                            class="input-text qty">
                                        <button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst )) result.value++;return false;"
                                            class="increase items-count" type="button"><i class="lnr lnr-chevron-up"></i></button>
                                        <button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst ) &amp;&amp; sst > 0 ) result.value--;return false;"
                                            class="reduced items-count" type="button"><i class="lnr lnr-chevron-down"></i></button>
                                    </div>
                                </td>
                                <td>
                                    <h5>$720.00</h5>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="media">
                                        <div class="d-flex">
                                            <img src="img/cart.jpg" alt="">
                                        </div>
                                        <div class="media-body">
                                            <p>Minimalistic shop for multipurpose use</p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <h5>$360.00</h5>
                                </td>
                                <td>
                                    <div class="product_count">
                                        <input type="text" name="qty" id="sst" maxlength="12" value="1" title="Quantity:"
                                            class="input-text qty">
                                        <button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst )) result.value++;return false;"
                                            class="increase items-count" type="button"><i class="lnr lnr-chevron-up"></i></button>
                                        <button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst ) &amp;&amp; sst > 0 ) result.value--;return false;"
                                            class="reduced items-count" type="button"><i class="lnr lnr-chevron-down"></i></button>
                                    </div>
                                </td>
                                <td>
                                    <h5>$720.00</h5>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="media">
                                        <div class="d-flex">
                                            <img src="img/cart.jpg" alt="">
                                        </div>
                                        <div class="media-body">
                                            <p>Minimalistic shop for multipurpose use</p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <h5>$360.00</h5>
                                </td>
                                <td>
                                    <div class="product_count">
                                        <input type="text" name="qty" id="sst" maxlength="12" value="1" title="Quantity:"
                                            class="input-text qty">
                                        <button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst )) result.value++;return false;"
                                            class="increase items-count" type="button"><i class="lnr lnr-chevron-up"></i></button>
                                        <button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst ) &amp;&amp; sst > 0 ) result.value--;return false;"
                                            class="reduced items-count" type="button"><i class="lnr lnr-chevron-down"></i></button>
                                    </div>
                                </td>
                                <td>
                                    <h5>$720.00</h5>
                                </td>
                            </tr>
                            <tr>
                                <td>

                                </td>
                                <td>

                                </td>
                                <td>
                                    <h5>Subtotal</h5>
                                </td>
                                <td>
                                    <h5>$2160.00</h5>
                                </td>
                            </tr>
                            <tr class="bottom_button">
                                <td>
                                    <a class="gray_btn" href="#">Update Cart</a>
                                </td>
                                <td>

                                </td>
                                <td>

                                </td>
                                <td>
                                    <div class="cupon_text d-flex align-items-center">
                                        <a class="gray_btn" href="{{url('/')}}">Continue Shopping</a>
<a class="primary-btn" href="{{url('/checkout')}}">Proceed to checkout</a>
</div>
</td>
</tr>
</tbody>
</table>
</div>
</div>
</div>
</section>
<!--================End Cart Area =================--> --}}


@php
// Defensive resolver for item images (handles string/array/json/URL)
if (! function_exists('resolveItemImageUrl')) {
function resolveItemImageUrl($image) {
$placeholder = asset('frontend/assets/img/product/p4.jpg');
if (empty($image)) return $placeholder;
if (is_array($image) || $image instanceof \Illuminate\Support\Collection) {
$first = is_array($image) ? ($image[0] ?? null) : $image->first();
return resolveItemImageUrl($first);
}
if (is_string($image) && in_array(substr(trim($image),0,1), ['[','{'])) {
$decoded = json_decode($image, true);
if (json_last_error() === JSON_ERROR_NONE) return resolveItemImageUrl($decoded);
}
if (is_string($image) && preg_match('#^https?://#i', $image)) return $image;
$rel = ltrim((string)$image, '/');
try {
if (\Illuminate\Support\Facades\Storage::disk('public')->exists($rel)) return asset('storage/'.$rel);
} catch (\Exception $e) {}
if (file_exists(public_path($rel))) return asset($rel);
return $placeholder;
}
}
@endphp

<div class="container py-4">
    <h2 class="mb-3">Your cart</h2>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($items->isEmpty())
    <div class="alert alert-info">Your cart is empty.</div>
    @else

    {{-- Desktop table --}}
    <div class="table-responsive d-none d-md-block">
        <table class="table table-hover align-middle">
            <thead class="thead-light">
                <tr>
                    <th style="width:110px;">Product</th>
                    <th>Product</th>
                    <th class="text-right" style="width:120px;">Price</th>
                    <th style="width:130px;">Qty</th>
                    <th class="text-right" style="width:140px;">Line</th>
                    <th class="text-right" style="width:120px;"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                @php $imgUrl = resolveItemImageUrl($item['image'] ?? null); @endphp
                <tr>
                    <td><img src="{{ $imgUrl }}" alt="{{ $item['name'] }}" style="width:90px;height:60px;object-fit:cover;border-radius:6px;"></td>
                    <td>
                        <div class="fw-bold">{{ Str::limit($item['name'], 60) }}</div>
                        <div class="text-muted small">ID: {{ $item['id'] }}</div>
                    </td>
                    <td class="text-right">{{ number_format($item['price'], 2) }} $</td>
                    <td>
                        <form action="{{ route('cart.update') }}" method="POST" class="d-flex">
                            @csrf
                            <input type="number" name="items[{{ $item['id'] }}][qty]" value="{{ $item['qty'] }}" min="0" class="form-control form-control-sm me-2" style="width:80px;">
                            <button class="btn btn-sm btn-outline-primary" type="submit">Update</button>
                        </form>
                    </td>
                    <td class="text-right">{{ number_format($item['price'] * $item['qty'], 2) }} $</td>
                    <td class="text-right">
                        <form method="POST" action="{{ route('cart.remove') }}">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $item['id'] }}">
                            <button type="submit" class="btn btn-sm btn-danger">Remove</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Mobile stacked cards --}}
    <div class="d-block d-md-none">
        @foreach($items as $item)
        @php $imgUrl = resolveItemImageUrl($item['image'] ?? null); @endphp
        <div class="card mb-3">
            <div class="row g-0 align-items-center">
                <div class="col-4">
                    <img src="{{ $imgUrl }}" class="img-fluid rounded-start" alt="{{ $item['name'] }}" style="height:100%;object-fit:cover;">
                </div>
                <div class="col-8">
                    <div class="card-body py-2">
                        <h6 class="card-title mb-1">{{ Str::limit($item['name'], 60) }}</h6>
                        <p class="text-muted mb-1 small">Unit: {{ number_format($item['price'], 2) }} $</p>

                        <div class="d-flex justify-content-between align-items-center">
                            <form action="{{ route('cart.update') }}" method="POST" class="d-flex align-items-center">
                                @csrf
                                <input type="number" name="items[{{ $item['id'] }}][qty]" value="{{ $item['qty'] }}" min="0" class="form-control form-control-sm me-2" style="width:70px;">
                                <button class="btn btn-sm btn-outline-primary" type="submit">Update</button>
                            </form>

                            <div class="text-end">
                                <div class="fw-bold">{{ number_format($item['price'] * $item['qty'], 2) }} $</div>
                                <form method="POST" action="{{ route('cart.remove') }}" class="mt-1">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $item['id'] }}">
                                    <button type="submit" class="btn btn-sm btn-danger">Remove</button>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Footer actions --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-3">
        <div class="mb-2 mb-md-0">
            <form method="POST" action="{{ route('cart.clear') }}" onsubmit="return confirm('Clear cart?');" class="d-inline">
                @csrf
                <button class="btn btn-outline-secondary">Clear cart</button>
            </form>
            <a href="{{ url('/') }}" class="btn btn-link">Continue shopping</a>
        </div>

        <div class="text-end">
            <h5 class="mb-2">Subtotal: <strong>{{ number_format($subtotal, 2) }} $</strong></h5>
            <a href="{{ url('/checkout') }}" class="btn btn-success btn-lg">Proceed to checkout</a>
        </div>
    </div>

    @endif
</div>

<style>
    .table-hover tbody tr:hover {
        background-color: rgba(0, 0, 0, 0.02);
    }

    @media (max-width: 767px) {
        .card .btn {
            font-size: 0.85rem;
            padding: 0.35rem 0.6rem;
        }
    }

</style>

@endsection

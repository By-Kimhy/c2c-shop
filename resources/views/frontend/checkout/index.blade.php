@extends('frontend.layout.master')

@section('content')

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

<div class="container py-4">
    <h3 class="mb-3">Checkout</h3>

    @if(session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif
    @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif

    @if($items->isEmpty())
    <div class="alert alert-info">Your cart is empty. <a href="{{ url('/') }}">Continue shopping</a>.</div>
    @else
    <div class="card mb-3">
        <div class="card-body">
            <table class="table table-sm mb-0">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th class="text-end">Price</th>
                        <th class="text-center">Qty</th>
                        <th class="text-end">Line</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $item)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="{{ resolveItemImageUrl($item['image'] ?? null) }}" alt="{{ $item['name'] }}" style="width:64px;height:48px;object-fit:cover;border-radius:6px;" class="me-2">
                                <div>
                                    <div class="fw-bold">{{ Str::limit($item['name'], 60) }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="text-end">{{ number_format($item['price'],2) }} $</td>
                        <td class="text-center">{{ $item['qty'] }}</td>
                        <td class="text-end">{{ number_format($item['line'],2) }} $</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="d-flex justify-content-between align-items-center mt-3">
                <div>
                    <a href="{{ url('/') }}" class="btn btn-link">Continue shopping</a>
                    <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary">Edit cart</a>
                </div>

                <div class="text-end">
                    <div class="mb-1 text-muted">Subtotal</div>
                    <h4 class="mb-0">{{ number_format($subtotal,2) }} $</h4>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('checkout.process') }}" method="POST" id="checkout-form">
        @csrf
        <input type="hidden" name="cart_snapshot" value="{{ base64_encode(json_encode($items->toArray())) }}">
        <input type="hidden" name="payment_method" value="khqr">
        <button type="submit" class="btn btn-success btn-lg w-100" id="checkout-submit-btn">
            <span class="ti-bag me-2"></span> Pay with KHQR ({{ number_format($subtotal,2) }} $)
        </button>
    </form>

    @endif
</div>

<script>
    document.getElementById('checkout-form').addEventListener('submit', function(e) {
        // small UX: disable submit to prevent double clicks
        document.getElementById('checkout-submit-btn').disabled = true;
    });

</script>
@endsection

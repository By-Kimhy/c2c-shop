{{-- @extends('frontend.layouts.app')
@section('content')
<h3>Your Cart</h3>
@if($cart->items->isEmpty()) <p>Empty</p> @else
<table class="table">
  <thead><tr><th>Product</th><th>Qty</th><th>Price</th><th>Total</th><th></th></tr></thead>
  <tbody>
    @foreach($cart->items as $item)
    <tr>
      <td>{{ $item->product->name }}</td>
      <td>
        <form action="{{ route('cart.update') }}" method="post">
          @csrf
          <input type="hidden" name="item_id" value="{{ $item->id }}">
          <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" style="width:70px">
          <button class="btn btn-sm btn-primary">Update</button>
        </form>
      </td>
      <td>{{ number_format($item->unit_price) }}</td>
      <td>{{ number_format($item->line_total) }}</td>
      <td>
        <form action="{{ route('cart.remove') }}" method="post">@csrf
          <input type="hidden" name="item_id" value="{{ $item->id }}">
          <button class="btn btn-sm btn-danger">Remove</button>
        </form>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
<a href="{{ route('checkout.show') }}" class="btn btn-success">Checkout</a>
@endif
@endsection --}}


@extends('frontend.layouts.app') {{-- I used your existing layout; change if your master is different --}}
@section('content')

<!-- Start Banner Area -->
<section class="banner-area organic-breadcrumb">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
            <div class="col-first">
                <h1>Shopping Cart</h1>
                <nav class="d-flex align-items-center">
                    <a href="{{ url('/') }}">Home<span class="lnr lnr-arrow-right"></span></a>
                    <a href="{{ url('/catalog') }}">Cart</a>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- End Banner Area -->

<!--================Cart Area =================-->
<section class="cart_area">
    <div class="container">
        <div class="cart_inner">
            <div class="table-responsive">

                @if($cart->items->isEmpty())
                    <p>Your cart is empty.</p>
                @else
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
                            @foreach($cart->items as $item)
                                @php
                                    $product = $item->product;
                                    // use first image or fallback
                                    $img = optional($product->images)[0] ?? 'frontend/assets/img/demo-product.png';
                                @endphp

                                <tr data-item-id="{{ $item->id }}">
                                    <td>
                                        <div class="media">
                                            <div class="d-flex">
                                                <img src="{{ asset($img) }}" alt="{{ $product->name }}" style="width:80px; height:auto;">
                                            </div>
                                            <div class="media-body">
                                                <p>{{ $product->name }}</p>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <h5>{{ number_format($item->unit_price) }} KHR</h5>
                                    </td>

                                    <td>
                                        <div class="product_count d-flex align-items-center">
                                            {{-- Update form (non-AJAX fallback) --}}
                                            <form action="{{ route('cart.update') }}" method="post" class="d-flex align-items-center update-form">
                                                @csrf
                                                <input type="hidden" name="item_id" value="{{ $item->id }}">

                                                <button type="button" class="btn btn-light btn-sm qty-decrease me-1" data-item="{{ $item->id }}">-</button>

                                                <input
                                                    type="number"
                                                    name="quantity"
                                                    id="qty-{{ $item->id }}"
                                                    maxlength="12"
                                                    value="{{ $item->quantity }}"
                                                    title="Quantity:"
                                                    class="input-text qty form-control"
                                                    style="width:80px"
                                                    min="1"
                                                >

                                                <button type="button" class="btn btn-light btn-sm qty-increase ms-1" data-item="{{ $item->id }}">+</button>

                                                <button type="submit" class="btn btn-sm btn-primary ms-2">Update</button>
                                            </form>
                                        </div>
                                    </td>

                                    <td>
                                        <h5>{{ number_format($item->line_total) }} KHR</h5>
                                    </td>
                                </tr>
                            @endforeach

                            {{-- subtotal row --}}
                            <tr>
                                <td></td>
                                <td></td>
                                <td><h5>Subtotal</h5></td>
                                <td><h5>{{ number_format($cart->items->sum('line_total')) }} KHR</h5></td>
                            </tr>

                            <tr class="bottom_button">
                                <td>
                                    <a class="gray_btn" href="{{ url('/') }}">Continue Shopping</a>
                                </td>
                                <td></td>
                                <td></td>
                                <td>
                                    <div class="cupon_text d-flex align-items-center">
                                        <a class="primary-btn" href="{{ route('checkout.show') }}">Proceed to checkout</a>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                @endif

            </div>
        </div>
    </div>
</section>
<!--================End Cart Area =================-->

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function(){
    // helper: post JSON with CSRF token
    async function postJson(url, data){
        const token = window._csrf || document.querySelector('meta[name="csrf-token"]')?.content;
        return fetch(url, {
            method: 'POST',
            credentials: 'same-origin',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token || ''
            },
            body: JSON.stringify(data)
        }).then(r => r.json());
    }

    // increment / decrement buttons (works on each row)
    document.querySelectorAll('.qty-increase').forEach(btn => {
        btn.addEventListener('click', function(){
            const id = this.dataset.item;
            const input = document.getElementById('qty-' + id);
            input.value = Math.max(1, parseInt(input.value || 0) + 1);
            // auto-submit the parent form (AJAX)
            const form = this.closest('form.update-form');
            ajaxSubmitUpdate(form);
        });
    });

    document.querySelectorAll('.qty-decrease').forEach(btn => {
        btn.addEventListener('click', function(){
            const id = this.dataset.item;
            const input = document.getElementById('qty-' + id);
            input.value = Math.max(1, parseInt(input.value || 0) - 1);
            const form = this.closest('form.update-form');
            ajaxSubmitUpdate(form);
        });
    });

    // Attach ajax submission for update forms
    function ajaxSubmitUpdate(form){
        // optional: use AJAX to update quantity without page reload
        const formData = new FormData(form);
        const itemId = formData.get('item_id');
        const qty = formData.get('quantity');

        // send to route('cart.update') which expects item_id and quantity (non-JSON fallback also supported)
        postJson('{{ route("cart.update") }}', { item_id: itemId, quantity: qty })
            .then(json => {
                if(json.success){
                    // reload the page to show updated totals (or better: update DOM)
                    location.reload();
                } else {
                    alert(json.message || 'Update failed');
                }
            }).catch(err => {
                console.error(err);
                // fallback to non-AJAX (submit the form)
                form.submit();
            });
    }

    // Optional: intercept normal form submit to use AJAX too
    document.querySelectorAll('form.update-form').forEach(f => {
        f.addEventListener('submit', function(e){
            e.preventDefault();
            ajaxSubmitUpdate(this);
        });
    });

    // Note: Remove AJAX if you prefer the classic POST form behaviour -> server will redirect back.
});
</script>
@endpush

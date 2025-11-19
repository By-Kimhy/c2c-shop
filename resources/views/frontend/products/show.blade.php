@extends('frontend.layouts.app')
@section('content')
<div class="row">
  <div class="col-md-6">
    <img src="{{ asset($product->images[0] ?? 'frontend/assets/img/demo-product.png') }}" class="img-fluid">
  </div>
  <div class="col-md-6">
    <h2>{{ $product->name }}</h2>
    <p>{{ number_format($product->price) }} KHR</p>
    <p>{{ $product->description }}</p>
    <button class="btn btn-primary btn-add-cart" data-id="{{ $product->id }}">Add to cart</button>
  </div>
</div>
@endsection

@extends('frontend.layout.master')
@section('title', $product->name)
@section('content')

<!-- Start Banner Area -->
<section class="banner-area organic-breadcrumb">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
            <div class="col-first">
                <h1>ប្រភេទផលិតផល</h1>
                <nav class="d-flex align-items-center">
                    <a href="index.php">ទំព័រដើម<span class="lnr lnr-arrow-right"></span></a>
                    <a href="#">ហាង<span class="lnr lnr-arrow-right"></span></a>
                    <a href="#">ប្រភេទ</a>
                </nav>
            </div>
        </div>
    </div>
</section>

<div class="container py-4">
  <div class="card">
    <div class="row no-gutters">
      <div class="col-md-5">
        @if($product->images && count($product->images))
          <img src="{{ asset('storage/'.$product->images[0]) }}" class="img-fluid" style="width:100%;height:100%;object-fit:cover;">
        @endif
      </div>
      <div class="col-md-7">
        <div class="card-body">
          <h4>{{ $product->name }}</h4>
          <p>{{ $product->description }}</p>
          <p><strong>Price:</strong> {{ number_format($product->price,2) }}</p>
          <p><strong>Stock:</strong> {{ $product->stock }}</p>
          <a href="{{ route('seller.products.edit', $product->id) }}" class="btn btn-primary">Edit</a>
          <form method="POST" action="{{ route('seller.products.destroy', $product->id) }}" style="display:inline-block">
            @csrf @method('DELETE')
            <button onclick="return confirm('Delete product?')" class="btn btn-danger">Delete</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@extends('frontend.layout.master') {{-- adjust to your frontend layout --}}
@section('title', $profile->shop_name)

@section('content')
<div class="container py-4">
  <div class="row">
    <div class="col-12">
      @if($profile->banner)
        <img src="{{ asset('storage/'.$profile->banner) }}" class="img-fluid" alt="banner">
      @endif
      <div class="d-flex align-items-center mt-3">
        @if($profile->logo)
          <img src="{{ asset('storage/'.$profile->logo) }}" style="width:80px;height:80px;object-fit:cover;border-radius:8px;margin-right:16px;">
        @endif
        <div>
          <h2>{{ $profile->shop_name }}</h2>
          <p>By: {{ $profile->user->name }} — {{ $profile->phone }}</p>
        </div>
      </div>

      <div class="mt-3">
        {!! nl2br(e($profile->description)) !!}
      </div>

      <hr>
      <h4>Products</h4>
      <div class="row">
        @foreach($products as $product)
          <div class="col-md-3 mb-3">
            <div class="card">
              @if($product->images && is_array($product->images))
                <img src="{{ asset($product->images[0] ?? '') }}" class="card-img-top" alt="">
              @endif
              <div class="card-body">
                <h5 class="card-title">{{ $product->name }}</h5>
                <p class="card-text">{{ number_format($product->price,2) }} {{ $product->currency ?? 'KHR' }}</p>
                <a href="{{ route('productDetail', ['id' => $product->id]) }}" class="btn btn-sm btn-primary">View</a>
              </div>
            </div>
          </div>
        @endforeach
      </div>

      <div class="mt-3">{{ $products->links() }}</div>
    </div>
  </div>
</div>
@endsection

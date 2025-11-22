@extends('backend.layout.master')
@section('title','Product')
@section('content')
<div class="content-wrapper">
  <div class="content-header d-flex justify-content-between align-items-center">
    <h1 class="m-0">{{ $product->name }}</h1>
    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Back</a>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="card mb-3">
        <div class="card-body">
          <div class="row">
            <div class="col-md-4">
              @if(!empty($product->images[0]))
                <img src="{{ asset('storage/'.$product->images[0]) }}" style="width:100%;height:220px;object-fit:cover;border-radius:6px;">
              @endif
            </div>
            <div class="col-md-8">
              <p><strong>Price:</strong> {{ number_format($product->price,2) }}</p>
              <p><strong>Stock:</strong> {{ $product->stock }}</p>
              <p><strong>Seller:</strong> {{ optional($product->user)->name ?? '—' }}</p>
              <p><strong>Category:</strong> {{ optional($product->category)->name ?? '—' }}</p>
              <hr>
              <div>{!! nl2br(e($product->description)) !!}</div>
            </div>
          </div>
        </div>
      </div>

      @if(!empty($product->images) && is_array($product->images))
        <div class="card">
          <div class="card-header">All images</div>
          <div class="card-body">
            <div class="d-flex flex-wrap">
              @foreach($product->images as $img)
                <div class="m-1"><img src="{{ asset('storage/'.$img) }}" style="width:180px;height:120px;object-fit:cover;border-radius:6px;"></div>
              @endforeach
            </div>
          </div>
        </div>
      @endif
    </div>
  </section>
</div>
@endsection

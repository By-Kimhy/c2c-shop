@extends('frontend.layouts.app')
@section('content')
<div class="row">
  <aside class="col-md-3">
    <h5>Categories</h5>
    <ul>
      @foreach($categories as $c)
        <li><a href="{{ route('catalog', ['category'=>$c->slug]) }}">{{ $c->name }}</a></li>
      @endforeach
    </ul>
    <h5>Price</h5>
    <form method="get" action="{{ route('catalog') }}">
      <select name="price" class="form-control">
        <option value="">Any</option>
        <option value="0-100000">0 - 100,000</option>
        <option value="100000-500000">100,000 - 500,000</option>
      </select>
      <button class="btn btn-sm btn-primary mt-2">Filter</button>
    </form>
  </aside>
  <div class="col-md-9">
    <div class="row">
      @foreach($products as $p)
      <div class="col-md-4 mb-3">
        <div class="card">
          <img src="{{ asset($p->images[0] ?? 'frontend/assets/img/demo-product.png') }}" class="card-img-top" alt="">
          <div class="card-body">
            <h5>{{ $p->name }}</h5>
            <p>{{ number_format($p->price) }} KHR</p>
            <a href="{{ route('products.show',$p->slug) }}" class="btn btn-sm btn-outline-primary">View</a>
            <button class="btn btn-sm btn-success btn-add-cart" data-id="{{ $p->id }}">Add</button>
          </div>
        </div>
      </div>
      @endforeach
    </div>
    {{ $products->links() }}
  </div>
</div>
@endsection

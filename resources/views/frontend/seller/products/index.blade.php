@extends('frontend.layout.master')
@section('title','My Products')
@section('content')
<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h3>My Products</h3>
    <a href="{{ route('seller.products.create') }}" class="btn btn-primary">Create Product</a>
  </div>

  @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif

  <form method="get" action="{{ route('seller.products.index') }}" class="mb-3">
    <input type="text" name="q" value="{{ $q ?? '' }}" placeholder="Search product" class="form-control" />
  </form>

  @if($products->count())
    <div class="row">
      @foreach($products as $p)
        <div class="col-md-4 mb-3">
          <div class="card h-100">
            @if($p->images && count($p->images))
              <img src="{{ asset('storage/'.$p->images[0]) }}" class="card-img-top" style="height:200px;object-fit:cover;">
            @endif
            <div class="card-body d-flex flex-column">
              <h5 class="card-title">{{ $p->name }}</h5>
              <p class="mb-1">{{ Str::limit($p->description, 80) }}</p>
              <p class="mt-auto"><strong>{{ number_format($p->price,2) }}</strong></p>
              <div class="mt-2">
                <a href="{{ route('seller.products.show', $p->id) }}" class="btn btn-sm btn-outline-primary">View</a>
                <a href="{{ route('seller.products.edit', $p->id) }}" class="btn btn-sm btn-primary">Edit</a>
                <form method="POST" action="{{ route('seller.products.destroy', $p->id) }}" style="display:inline-block">
                  @csrf @method('DELETE')
                  <button onclick="return confirm('Delete product?')" class="btn btn-sm btn-danger">Delete</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>

    <div class="mt-3">{{ $products->links() }}</div>
  @else
    <div class="alert alert-info">No products yet. <a href="{{ route('seller.products.create') }}">Create one</a></div>
  @endif
</div>
@endsection

@extends('frontend.layout.master')
@section('title', $mode=='create' ? 'Create Product' : 'Edit Product')
@section('content')
<div class="container py-4">
  <h3>{{ $mode=='create' ? 'Create Product' : 'Edit Product' }}</h3>

  @if($errors->any()) <div class="alert alert-danger"><ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div> @endif
  <form method="post" action="{{ $mode=='create' ? route('seller.products.store') : route('seller.products.update', $product->id) }}" enctype="multipart/form-data">
    @csrf
    @if($mode=='edit') @method('PUT') @endif

    <div class="form-group">
      <label>Name</label>
      <input name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
    </div>

    <div class="form-group">
      <label>Slug (optional)</label>
      <input name="slug" class="form-control" value="{{ old('slug', $product->slug) }}">
    </div>

    <div class="form-group">
      <label>Description</label>
      <textarea name="description" class="form-control" rows="5">{{ old('description', $product->description) }}</textarea>
    </div>

    <div class="form-row">
      <div class="form-group col-md-4">
        <label>Price</label>
        <input name="price" type="number" step="0.01" class="form-control" value="{{ old('price', $product->price ?? 0) }}" required>
      </div>
      <div class="form-group col-md-4">
        <label>Stock</label>
        <input name="stock" type="number" class="form-control" value="{{ old('stock', $product->stock ?? 0) }}">
      </div>
      <div class="form-group col-md-4">
        <label>Status</label>
        <select name="status" class="form-control">
          <option value="draft" {{ (old('status', $product->status ?? '')=='draft') ? 'selected' : '' }}>Draft</option>
          <option value="published" {{ (old('status', $product->status ?? '')=='published') ? 'selected' : '' }}>Published</option>
        </select>
      </div>
    </div>

    <div class="form-group">
      <label>Current images</label>
      <div class="mb-2">
        @if($product->images)
          @foreach($product->images as $img)
            <div style="display:inline-block;margin-right:8px;text-align:center">
              <img src="{{ asset('storage/'.$img) }}" style="height:80px;object-fit:cover;display:block;margin-bottom:4px;">
              <label><input type="checkbox" name="remove_images[]" value="{{ $img }}"> remove</label>
            </div>
          @endforeach
        @endif
      </div>

      <label>Upload new images (you can choose multiple)</label>
      <input type="file" name="images[]" multiple class="form-control-file">
      <small class="form-text text-muted">Max per image: 4MB.</small>
    </div>

    <button class="btn btn-primary">{{ $mode=='create' ? 'Create' : 'Save' }}</button>
    <a href="{{ route('seller.products.index') }}" class="btn btn-secondary">Cancel</a>
  </form>
</div>
@endsection

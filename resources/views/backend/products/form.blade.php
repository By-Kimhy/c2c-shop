@extends('backend.layout.master')
@section('title', $mode === 'create' ? 'Create Product' : 'Edit Product')
@section('content')
<div class="content-wrapper">
  <div class="content-header d-flex justify-content-between align-items-center">
    <h1 class="m-0">{{ $mode === 'create' ? 'Create Product' : 'Edit Product' }}</h1>
    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Back to list</a>
  </div>

  <section class="content">
    <div class="container-fluid">
      @if($errors->any())
        <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
      @endif

      <div class="card">
        <div class="card-body">
          @if($mode === 'create')
            <form method="post" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
          @else
            <form method="post" action="{{ route('admin.products.update', $product->id) }}" enctype="multipart/form-data">
              @method('PUT')
          @endif
            @csrf

            <div class="form-row">
              <div class="form-group col-md-6">
                <label>Product name</label>
                <input name="name" class="form-control" required value="{{ old('name', $product->name) }}">
              </div>

              <div class="form-group col-md-3">
                <label>Price</label>
                <input name="price" class="form-control" required value="{{ old('price', $product->price ?? 0) }}">
              </div>

              <div class="form-group col-md-3">
                <label>Stock</label>
                <input name="stock" class="form-control" value="{{ old('stock', $product->stock ?? 0) }}">
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-6">
                <label>Seller (user)</label>
                <select name="user_id" class="form-control">
                  <option value="">— none —</option>
                  @foreach($sellers as $s)
                    <option value="{{ $s->id }}" {{ (old('user_id', $product->user_id) == $s->id) ? 'selected' : '' }}>{{ $s->name }} ({{ $s->email }})</option>
                  @endforeach
                </select>
              </div>

              <div class="form-group col-md-6">
                <label>Category</label>
                <select name="category_id" class="form-control">
                  <option value="">— none —</option>
                  @foreach($categories as $c)
                    <option value="{{ $c->id }}" {{ (old('category_id', $product->category_id) == $c->id) ? 'selected' : '' }}>{{ $c->name }}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="form-group">
              <label>Description</label>
              <textarea name="description" rows="6" class="form-control">{{ old('description', $product->description) }}</textarea>
            </div>

            <div class="form-group">
              <label>Images (multiple allowed)</label>
              <input type="file" name="images[]" multiple class="form-control-file">
            </div>

            @if(!empty($product->images) && is_array($product->images))
              <div class="form-group">
                <label>Existing images</label>
                <div class="d-flex flex-wrap">
                  @foreach($product->images as $img)
                    <div class="m-1" style="position:relative">
                      <img src="{{ asset('storage/'.$img) }}" style="width:120px;height:80px;object-fit:cover;border-radius:4px;">
                      <div style="position:absolute;left:4px;top:4px;">
                        <label class="badge badge-danger" style="cursor:pointer;padding:4px 6px;">
                          <input type="checkbox" name="remove_images[]" value="{{ $img }}" style="display:none;">
                          Remove
                        </label>
                      </div>
                    </div>
                  @endforeach
                </div>
              </div>
            @endif

            <div class="form-group">
              <label>Status</label>
              <select name="status" class="form-control">
                <option value="draft" {{ old('status', $product->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="published" {{ old('status', $product->status) === 'published' ? 'selected' : '' }}>Published</option>
              </select>
            </div>

            <div class="form-group">
              <button class="btn btn-primary">{{ $mode === 'create' ? 'Create' : 'Save' }}</button>
              <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Cancel</a>
            </div>

          </form>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection

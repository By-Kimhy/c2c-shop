@extends('backend.layout.master')
@section('title','Edit Seller Profile')
@section('content')

<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid d-flex justify-content-between align-items-center">
      <h1 class="m-0">Edit Seller: {{ $profile->shop_name }}</h1>
      <a href="{{ route('admin.seller-profiles.index') }}" class="btn btn-secondary">Back</a>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      @if($errors->any()) <div class="alert alert-danger"><ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div> @endif
      <div class="card">
        <div class="card-body">
          <form method="post" action="{{ route('admin.seller-profiles.update', $profile->id) }}" enctype="multipart/form-data">
            @csrf @method('PUT')

            <div class="form-group">
              <label>Shop name</label>
              <input name="shop_name" class="form-control" value="{{ old('shop_name', $profile->shop_name) }}" required>
            </div>

            <div class="form-group">
              <label>Description</label>
              <textarea name="description" class="form-control" rows="4">{{ old('description', $profile->description) }}</textarea>
            </div>

            <div class="form-group">
              <label>Phone</label>
              <input name="phone" class="form-control" value="{{ old('phone', $profile->phone) }}">
            </div>

            <div class="form-group">
              <label>Address</label>
              <input name="address" class="form-control" value="{{ old('address', $profile->address) }}">
            </div>

            <div class="form-group">
              <label>Logo (image)</label>
              @if($profile->logo)<div><img src="{{ asset('storage/'.$profile->logo) }}" style="max-height:80px"></div>@endif
              <input type="file" name="logo" class="form-control-file">
            </div>

            <div class="form-group">
              <label>Banner (image)</label>
              @if($profile->banner)<div><img src="{{ asset('storage/'.$profile->banner) }}" style="max-height:120px"></div>@endif
              <input type="file" name="banner" class="form-control-file">
            </div>

            <div class="form-group">
              <label>Status</label>
              <select name="status" class="form-control">
                <option value="pending" {{ $profile->status==='pending' ? 'selected' : '' }}>Pending</option>
                <option value="approved" {{ $profile->status==='approved' ? 'selected' : '' }}>Approved</option>
                <option value="suspended" {{ $profile->status==='suspended' ? 'selected' : '' }}>Suspended</option>
              </select>
            </div>

            <button class="btn btn-primary">Save</button>
          </form>
        </div>
      </div>
    </div>
  </section>
</div>

@endsection

@extends('frontend.layout.master')
@section('title', 'Edit Shop Profile')

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
  <h3>Edit Shop Profile</h3>

  @if($errors->any())
    <div class="alert alert-danger"><ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
  @endif

  <form action="{{ route('seller.profile.update') }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PUT')

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
      <label>Logo</label>
      @if($profile->logo) <div><img src="{{ asset('storage/'.$profile->logo) }}" style="max-height:80px"></div> @endif
      <input type="file" name="logo" class="form-control-file">
    </div>

    <div class="form-group">
      <label>Banner</label>
      @if($profile->banner) <div><img src="{{ asset('storage/'.$profile->banner) }}" style="max-height:120px"></div> @endif
      <input type="file" name="banner" class="form-control-file">
    </div>

    <button class="btn btn-primary">Save and Send for Review</button>
    <a href="{{ route('seller.dashboard') }}" class="btn btn-secondary">Cancel</a>
  </form>
</div>
@endsection

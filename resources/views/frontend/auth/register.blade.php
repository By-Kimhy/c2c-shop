@extends('frontend.layout.master')
@section('content')

<!-- Start Banner Area -->
<section class="banner-area organic-breadcrumb">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
            <div class="col-first">
                <h1>ចូលក្នុងកម្មវិធី/ចុះឈ្មោះ</h1>
                <nav class="d-flex align-items-center">
                    <a href="#">ទំព័រដើម<span class="lnr lnr-arrow-right"></span></a>
                    <a href="#">ចូលក្នុងកម្មវិធី/ចុះឈ្មោះ</a>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- End Banner Area -->

<!--================Register Box Area =================-->
<section class="login_box_area section_gap">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-7">
        <div class="login_form_inner">
          <h3>Register</h3>

          @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
          @if($errors->any())
            <div class="alert alert-danger">
              <ul class="mb-0">@foreach($errors->all() as $err) <li>{{ $err }}</li> @endforeach</ul>
            </div>
          @endif

          <form method="post" action="{{ route('register.post') }}" class="row login_form">
            @csrf

            <div class="col-md-12 form-group">
              <input type="text" name="name" value="{{ old('name') }}" class="form-control" placeholder="Name" required>
            </div>

            <div class="col-md-12 form-group">
              <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="Email" required>
            </div>

            <div class="col-md-6 form-group">
              <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>

            <div class="col-md-6 form-group">
              <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password" required>
            </div>

            <div class="col-md-12 form-group">
              <button type="submit" class="primary-btn">Create account</button>
              <a class="btn btn-link" href="{{ route('login') }}">Already have account? Login</a>
            </div>
          </form>

        </div>
      </div>
    </div>
  </div>
</section>
@endsection

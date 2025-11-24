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


<section class="login_box_area section_gap">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-6">
        <div class="login_form_inner">
          <h3>Login</h3>

          @if($errors->any())
            <div class="alert alert-danger">
              <ul class="mb-0">@foreach($errors->all() as $err) <li>{{ $err }}</li> @endforeach</ul>
            </div>
          @endif

          <form method="POST" action="{{ route('login.post') }}" class="row login_form">
            @csrf

            <div class="col-md-12 form-group">
              <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="Email" required>
            </div>

            <div class="col-md-12 form-group">
              <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>

            <div class="col-md-12 form-group">
              <div class="creat_account">
                <input type="checkbox" id="remember" name="remember" value="1">
                <label for="remember">Remember me</label>
              </div>
            </div>

            <div class="col-md-12 form-group">
              <button type="submit" class="primary-btn">Login</button>
              <a class="btn btn-link" href="{{ route('password.request') }}">Forgot password?</a>
            </div>
          </form>

        </div>
      </div>
    </div>
  </div>
</section>
@endsection
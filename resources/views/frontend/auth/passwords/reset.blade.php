@extends('frontend.layout.master')
@section('content')

<!-- Start Banner Area -->
<section class="banner-area organic-breadcrumb">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
            <div class="col-first">
                <h1>Set New Password</h1>
            </div>
        </div>
    </div>
</section>
<!-- End Banner Area -->


<div class="container py-5">
  <h3>Set New Password</h3>

  <form method="POST" action="{{ route('password.update') }}">
    @csrf
    <input type="hidden" name="token" value="{{ $token }}">

    <div class="form-group mb-2">
      <input type="email" name="email" class="form-control" value="{{ $email ?? old('email') }}" required>
    </div>

    <div class="form-group mb-2">
      <input type="password" name="password" class="form-control" placeholder="New password" required>
    </div>

    <div class="form-group mb-2">
      <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm password" required>
    </div>

    <button type="submit" class="btn btn-primary">Reset password</button>
  </form>
</div>
@endsection

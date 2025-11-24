@extends('frontend.layout.master')
@section('content')

<!-- Start Banner Area -->
<section class="banner-area organic-breadcrumb">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
            <div class="col-first">
                <h1>Reset Password</h1>
            </div>
        </div>
    </div>
</section>
<!-- End Banner Area -->


<div class="container py-5">
  <h3>Reset Password</h3>
  @if(session('status')) <div class="alert alert-success">{{ session('status') }}</div> @endif

  <form method="POST" action="{{ route('password.email') }}">
    @csrf
    <div class="form-group">
      <input type="email" name="email" class="form-control" placeholder="Your email" required>
    </div>
    <button type="submit" class="btn btn-primary">Send password reset link</button>
  </form>
</div>
@endsection

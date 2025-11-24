@extends('frontend.layout.master')
@section('content')

<!-- Start Banner Area -->
<section class="banner-area organic-breadcrumb">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
            <div class="col-first">
                <h1>Verify your email</h1>
            </div>
        </div>
    </div>
</section>
<!-- End Banner Area -->

<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-8">
      @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
      @if(session('status')) <div class="alert alert-info">{{ session('status') }}</div> @endif

      <div class="card">
        <div class="card-body">
          <h4>Please verify your email</h4>
          <p>We sent a verification link to your email address. Check your inbox and click the link to verify your account.</p>

          <form method="POST" action="{{ route('verification.resend') }}">
            @csrf
            <button type="submit" class="btn btn-primary">Resend verification email</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

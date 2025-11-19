@extends('frontend.layouts.app')
@section('content')
<h3>Checkout</h3>
<form method="post" action="{{ route('checkout.process') }}">
  @csrf
  <div class="mb-2"><label>Name</label><input name="shipping_name" class="form-control" required></div>
  <div class="mb-2"><label>Phone</label><input name="shipping_phone" class="form-control" required></div>
  <div class="mb-2"><label>Address</label><textarea name="shipping_address" class="form-control" required></textarea></div>
  <input type="hidden" name="payment_method" value="khqr">
  <button class="btn btn-primary">Place order & Pay</button>
</form>
@endsection

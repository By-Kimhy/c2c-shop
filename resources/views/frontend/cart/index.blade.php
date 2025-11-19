@extends('frontend.layouts.app')
@section('content')
<h3>Your Cart</h3>
@if($cart->items->isEmpty()) <p>Empty</p> @else
<table class="table">
  <thead><tr><th>Product</th><th>Qty</th><th>Price</th><th>Total</th><th></th></tr></thead>
  <tbody>
    @foreach($cart->items as $item)
    <tr>
      <td>{{ $item->product->name }}</td>
      <td>
        <form action="{{ route('cart.update') }}" method="post">
          @csrf
          <input type="hidden" name="item_id" value="{{ $item->id }}">
          <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" style="width:70px">
          <button class="btn btn-sm btn-primary">Update</button>
        </form>
      </td>
      <td>{{ number_format($item->unit_price) }}</td>
      <td>{{ number_format($item->line_total) }}</td>
      <td>
        <form action="{{ route('cart.remove') }}" method="post">@csrf
          <input type="hidden" name="item_id" value="{{ $item->id }}">
          <button class="btn btn-sm btn-danger">Remove</button>
        </form>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
<a href="{{ route('checkout.show') }}" class="btn btn-success">Checkout</a>
@endif
@endsection

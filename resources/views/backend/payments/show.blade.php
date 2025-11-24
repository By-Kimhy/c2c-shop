@extends('backend.layout.master')
@section('title','Payment #'.$payment->id)
@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid d-flex justify-content-between align-items-center">
      <h1 class="m-0">Payment #{{ $payment->id }}</h1>
      <a href="{{ route('admin.payments.index') }}" class="btn btn-secondary">Back to payments</a>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
      @if(session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif

      <div class="row">
        <div class="col-md-8">
          <div class="card card-outline card-info">
            <div class="card-header"><h3 class="card-title">Payment Details</h3></div>
            <div class="card-body">
              <p><strong>ID:</strong> {{ $payment->id }}</p>
              <p><strong>Amount:</strong> {{ number_format($payment->amount,2) }} {{ $payment->currency ?? config('app.currency','KHR') }}</p>
              <p><strong>Provider:</strong> {{ $payment->provider ?? '-' }}</p>
              <p><strong>Provider Ref:</strong> {{ $payment->provider_ref ?? '-' }}</p>

              {{-- FIXED BADGE STATUS --}}
              <p>
                <strong>Status:</strong>
                <span class="badge badge-{{ 
                    $payment->status === 'paid' ? 'success' :
                    ($payment->status === 'pending' ? 'warning' :
                    ($payment->status === 'failed' ? 'danger' : 'secondary')) 
                }}">
                    {{ ucfirst($payment->status) }}
                </span>
              </p>

              <hr>
              <h5>Order</h5>
              @if($order)
                <p><a href="{{ route('admin.orders.show', $order->id) }}">Order #{{ $order->order_number ?? $order->id }}</a></p>
                <p><strong>Buyer:</strong> {{ optional($order->user)->name ?? $order->shipping_name ?? 'Guest' }}</p>
                <p><strong>Total:</strong> {{ number_format($order->total ?? 0,2) }} {{ $order->currency ?? config('app.currency','KHR') }}</p>
              @else
                <p>No order attached.</p>
              @endif

              <hr>
              <h5>Raw payload</h5>
              @if($payment->payload)
                <pre style="white-space:pre-wrap;max-height:300px;overflow:auto">
{{ is_string($payment->payload) ? $payment->payload : json_encode($payment->payload, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE) }}
                </pre>
              @else
                <p>No payload.</p>
              @endif
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="card">
            <div class="card-header"><h3 class="card-title">Actions</h3></div>
            <div class="card-body">

              {{-- FIXED: Mark Paid must use lowercase "paid" --}}
              <form method="post" action="{{ route('admin.payments.update.status', $payment->id) }}">
                @csrf
                <input type="hidden" name="status" value="paid">
                <button type="submit" class="btn btn-success btn-block" onclick="return confirm('Confirm payment?')">
                  Mark Paid
                </button>
              </form>

              {{-- FAILED --}}
              <form method="post" action="{{ route('admin.payments.update.status', $payment->id) }}" class="mt-2">
                @csrf
                <input type="hidden" name="status" value="failed">
                <button type="submit" class="btn btn-danger btn-block" onclick="return confirm('Mark payment as failed?')">
                  Mark Failed
                </button>
              </form>

              {{-- PENDING --}}
              <form method="post" action="{{ route('admin.payments.update.status', $payment->id) }}" class="mt-2">
                @csrf
                <input type="hidden" name="status" value="pending">
                <button type="submit" class="btn btn-outline-secondary btn-block">
                  Set Pending
                </button>
              </form>

              <hr>

              {{-- DELETE PAYMENT --}}
              <form method="post" action="{{ route('admin.payments.destroy', $payment->id) }}" onsubmit="return confirm('Delete payment?');">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger btn-block">Delete Payment</button>
              </form>

            </div>
          </div>
        </div>

      </div>
    </div>
  </section>
</div>
@endsection

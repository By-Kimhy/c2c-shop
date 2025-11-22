<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Payment Confirmed</title>
</head>
<body>
  <h2>Payment Confirmed</h2>

  <p>Dear {{ optional($payment->order->user)->name ?? ($payment->order->shipping_name ?? 'Customer') }},</p>

  <p>We have confirmed your payment for order <strong>#{{ $payment->order->order_number ?? $payment->order_id }}</strong>.</p>

  <p>
    <strong>Amount:</strong> {{ number_format($payment->amount ?? 0,2) }} {{ $payment->currency ?? config('app.currency','KHR') }}<br>
    <strong>Payment provider:</strong> {{ $payment->provider ?? '-' }}<br>
    <strong>Provider ref:</strong> {{ $payment->provider_ref ?? '-' }}<br>
    <strong>Date:</strong> {{ $payment->created_at->format('Y-m-d H:i') }}
  </p>

  <p>Thank you for your purchase. Your order will be processed shortly.</p>

  <p>— C2C Shop</p>
</body>
</html>

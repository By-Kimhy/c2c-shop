<div style="font-family:Arial, sans-serif; padding:20px;">
  <h2>Invoice #{{ $order->order_number }}</h2>
  <p><strong>Name:</strong> {{ $order->shipping_name }}</p>
  <p><strong>Phone:</strong> {{ $order->shipping_phone }}</p>
  <p><strong>Address:</strong> {{ $order->shipping_address }}</p>
  <table width="100%" border="1" cellpadding="6" cellspacing="0">
    <thead><tr><th>Item</th><th>Qty</th><th>Unit</th><th>Total</th></tr></thead>
    <tbody>
      @foreach($order->items as $it)
      <tr><td>{{ $it->name }}</td><td>{{ $it->quantity }}</td><td>{{ number_format($it->unit_price) }}</td><td>{{ number_format($it->line_total) }}</td></tr>
      @endforeach
    </tbody>
  </table>
  <h3>Total: {{ number_format($order->total) }} {{ $order->currency }}</h3>
</div>

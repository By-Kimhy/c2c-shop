@component('mail::message')
# Payment Received ✅

Hello {{ $order->customer_name ?? $order->name ?? 'Customer' }},

We have received your payment for order **{{ $order->order_number ?? $order->id }}**.

**Amount:** {{ number_format($order->total, 2) }} $

@if(!empty($order->items))
**Items**
@foreach($order->items as $it)
- {{ $it->name }} × {{ $it->qty }}
@endforeach
@endif

Thanks for shopping with {{ config('app.name') }}.

Regards,  
{{ config('app.name') }}
@endcomponent

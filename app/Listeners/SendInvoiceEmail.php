<?php

namespace App\Listeners;

use App\Events\OrderPlaced;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\InvoiceMail;

class SendInvoiceEmail implements ShouldQueue
{
    public function handle(OrderPlaced $event)
    {
        Mail::to($event->order->shipping_phone ? $event->order->shipping_name.'@example.invalid' : null) // replace with real email if stored
            ->send(new \App\Mail\InvoiceMail($event->order));
    }
}

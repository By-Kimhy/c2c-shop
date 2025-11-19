<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;
    public function __construct(public Order $order) {}
    public function build()
    {
        // Use stored invoice_html if present, otherwise render
        $html = $this->order->invoice_html ?? view('frontend.invoices.default', ['order'=>$this->order])->render();
        return $this->subject("Invoice #{$this->order->order_number}")
                    ->html($html);
    }
}

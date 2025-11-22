<?php

namespace App\Mail;

use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentConfirmed extends Mailable
{
    use Queueable, SerializesModels;

    public Payment $payment;

    /**
     * Create a new message instance.
     */
    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $subject = 'Payment Confirmed — Order #' . ($this->payment->order->order_number ?? $this->payment->order_id);

        return $this->subject($subject)
                    ->view('emails.payment_confirmed')
                    ->with([
                        'payment' => $this->payment,
                        'order' => $this->payment->order,
                    ]);
    }
}

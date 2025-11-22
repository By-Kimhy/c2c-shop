<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use App\Mail\PaymentConfirmed;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
    /**
     * List payments with simple filters (status, q).
     */
    public function index(Request $request): View
    {
        $q = $request->input('q');
        $status = $request->input('status');

        $query = Payment::with('order')->orderBy('created_at', 'desc');

        if ($q) {
            $query->where(function ($sub) use ($q) {
                $sub->where('provider_ref', 'like', "%{$q}%")
                    ->orWhere('provider', 'like', "%{$q}%")
                    ->orWhere('id', $q);
            });
        }

        if ($status) {
            $query->where('status', $status);
        }

        $payments = $query->paginate(20)->withQueryString();

        return view('backend.payments.index', compact('payments', 'q', 'status'));
    }

    /**
     * Show single payment
     */
    public function show($id): View
    {
        $payment = Payment::with(['order', 'order.items', 'order.user'])->findOrFail($id);

        // compute useful totals if needed
        $order = $payment->order;

        return view('backend.payments.show', compact('payment', 'order'));
    }

    /**
     * Update payment status (confirm/failed/pending).
     */
    public function updateStatus(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,failed',
        ]);

        $payment = Payment::with('order.user')->findOrFail($id);
        $newStatus = $request->input('status');

        $payment->status = $newStatus;
        $payment->save();

        $order = $payment->order;

        if ($newStatus === 'confirmed') {
            // mark order paid if not already
            if ($order && $order->status !== 'paid') {
                $order->status = 'paid';
                $order->save();
            }

            // 1) Send email to buyer if we have an email
            $recipientEmail = optional($order->user)->email ?? $order->shipping_phone ? null : null;
            // prefer user email, then shipping email if you had it stored - adjust logic if needed
            $recipientEmail = optional($order->user)->email ?? ($order->shipping_email ?? null);

            if ($recipientEmail) {
                try {
                    Mail::to($recipientEmail)->send(new PaymentConfirmed($payment));
                } catch (\Throwable $e) {
                    // log but continue
                    \Log::error('Payment confirmation email failed: ' . $e->getMessage(), ['payment_id' => $payment->id]);
                }
            }

            // 2) Send Telegram message to admin chat if configured
            $bot = config('services.telegram.bot_token') ?? env('TELEGRAM_BOT_TOKEN');
            $chatId = env('TELEGRAM_CHAT_ID');

            if ($bot && $chatId) {
                try {
                    $text = sprintf(
                        "✅ Payment confirmed\nPayment ID: %s\nOrder: %s\nAmount: %s %s\nProvider: %s\nRef: %s",
                        $payment->id,
                        $order ? ($order->order_number ?? $order->id) : '—',
                        number_format($payment->amount ?? 0, 2),
                        $payment->currency ?? config('app.currency', 'KHR'),
                        $payment->provider ?? '-',
                        $payment->provider_ref ?? '-'
                    );

                    $url = "https://api.telegram.org/bot{$bot}/sendMessage";

                    Http::post($url, [
                        'chat_id' => $chatId,
                        'text' => $text,
                        'parse_mode' => 'HTML',
                    ]);
                } catch (\Throwable $e) {
                    \Log::error('Telegram notify failed: ' . $e->getMessage(), ['payment_id' => $payment->id]);
                }
            }

            return redirect()->route('admin.payments.show', $payment->id)->with('success', 'Payment confirmed and notifications sent (if configured).');
        }

        if ($newStatus === 'failed') {
            // when failed, if order was paid, set to pending (or your business logic)
            if ($order && $order->status === 'paid') {
                $order->status = 'pending';
                $order->save();
            }

            return redirect()->route('admin.payments.show', $payment->id)->with('success', 'Payment marked as failed.');
        }

        // pending
        return redirect()->route('admin.payments.show', $payment->id)->with('success', 'Payment status set to pending.');
    }

    /**
     * Delete payment (admin).
     */
    public function destroy($id): RedirectResponse
    {
        $payment = Payment::findOrFail($id);

        // if you want additional safety, prevent deleting confirmed payments:
        // if ($payment->status === 'confirmed') {
        //     return redirect()->back()->with('error','Cannot delete confirmed payment.');
        // }

        $payment->delete();

        return redirect()->route('admin.payments.index')->with('success', 'Payment deleted.');
    }
}

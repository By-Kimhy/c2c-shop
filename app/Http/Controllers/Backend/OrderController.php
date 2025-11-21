<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;   // you also need this if payment_ref uses Str
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;


class OrderController extends Controller
{
    /**
     * Orders list (paginated, with optional search by order_number and status).
     * Supports CSV export via ?export=csv
     */
    public function index(Request $request)
    {
        $query = Order::with('user')->orderBy('created_at', 'desc');

        // quick search by order number
        if ($request->filled('q')) {
            $q = $request->input('q');
            $query->where('order_number', 'like', "%{$q}%");
        }

        // status filter: pending, paid, cancelled
        $status = $request->input('status');
        if ($status && in_array($status, ['pending','paid','cancelled'])) {
            $query->where('status', $status);
        }

        // CSV export
        if ($request->input('export') === 'csv') {
            $orders = $query->get(); // export all matching rows (no pagination)
            $filename = 'orders-' . now()->format('Ymd-His') . '.csv';

            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            ];

            $columns = ['id','order_number','buyer_name','buyer_email','buyer_phone','items_count','subtotal','shipping_fee','total','currency','status','created_at'];

            $callback = function() use ($orders, $columns) {
                $handle = fopen('php://output', 'w');
                // header row
                fputcsv($handle, $columns);

                foreach ($orders as $order) {
                    $row = [
                        $order->id,
                        $order->order_number,
                        optional($order->user)->name ?? $order->shipping_name ?? '',
                        optional($order->user)->email ?? '',
                        $order->shipping_phone ?? '',
                        $order->items->count(),
                        $order->subtotal ?? '',
                        $order->shipping_fee ?? '',
                        $order->total ?? '',
                        $order->currency ?? '',
                        $order->status ?? '',
                        $order->created_at?->toDateTimeString() ?? '',
                    ];
                    fputcsv($handle, $row);
                }

                fclose($handle);
            };

            return new StreamedResponse($callback, 200, $headers);
        }

        // paginate (12 per page)
        $orders = $query->paginate(12)->withQueryString();

        return view('backend.orders.index', compact('orders', 'status'));
    }

    /**
     * Show an order detail page.
     */
    public function show($id)
    {
        $order = Order::with(['user', 'items.product', 'payments'])->find($id);

        if (! $order) {
            abort(404, 'Order not found');
        }

        $subtotal = $order->subtotal ?? $order->items->sum(fn($it) => ($it->line_total ?? ($it->unit_price * $it->quantity)));
        $shipping = $order->shipping_fee ?? 0;
        $total = $order->total ?? ($subtotal + $shipping);

        return view('backend.orders.show', compact('order','subtotal','shipping','total'));
    }

    /**
     * Update order status (mark paid / cancelled / pending).
     */
    public function updateStatus(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'status' => 'required|string|in:pending,paid,cancelled',
        ]);

        $status = $request->input('status');

        $order = Order::with('payments')->find($id);

        if (! $order) {
            return redirect()->route('admin.orders.index')->with('error', 'Order not found.');
        }

        DB::transaction(function () use ($order, $status) {
            // Update status
            $order->status = $status;
            $order->save();

            // If marking as paid and there is no confirmed payment, create a simple payment record
            if ($status === 'paid') {
                $hasConfirmed = $order->payments()->where('status', 'confirmed')->exists();

                if (! $hasConfirmed) {
                    $order->payments()->create([
                        'amount' => $order->total ?? ($order->subtotal ?? 0),
                        'currency' => $order->currency ?? config('app.currency','KHR'),
                        'status' => 'confirmed',
                        'provider' => 'admin-manual',
                        'provider_ref' => 'manual_'.Str::random(6),
                        'payload' => null,
                    ]);
                }
            }

            // If marking cancelled, optionally you could revert stock / notify seller here.
        });

        return redirect()->route('admin.orders.show', $order->id)
            ->with('success', "Order status updated to \"{$status}\".");
    }


}

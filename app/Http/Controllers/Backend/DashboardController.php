<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller; // must extend this Controller
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\Payment;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct()
    {
        // enforce session auth and admin check on the controller
        $this->middleware('auth'); // requires logged-in user (web guard)
        $this->middleware(\App\Http\Middleware\AdminMiddleware::class); // requires is_admin true
    }

    public function index(Request $request)
    {
        if (!\Illuminate\Support\Facades\Auth::guard('web')->check() || !(\Illuminate\Support\Facades\Auth::user()->is_admin ?? false)) {
            return redirect()->route('admin.login');
        }

        // Totals
        $totalOrders = Order::count();
        $totalRevenue = Order::where('status', 'paid')->sum('total') ?: 0;
        $totalUsers = User::count();
        $totalProducts = Product::count();

        // Recent orders
        $recentOrders = Order::with('user')->orderBy('created_at', 'desc')->limit(10)->get();

        // Recent users
        $recentUsers = User::orderBy('created_at', 'desc')->limit(8)->get();

        // Order status counts
        $pendingOrders = Order::where('status', 'pending')->count();
        $paidOrders = Order::where('status', 'paid')->count();
        $cancelledOrders = Order::where('status', 'cancelled')->orWhere('status', 'canceled')->count();

        // Revenue last 6 months
        $months = [];
        $revenueData = [];
        $start = Carbon::now()->startOfMonth()->subMonths(5);

        for ($i = 0; $i < 6; $i++) {
            $monthStart = (clone $start)->addMonths($i)->startOfMonth();
            $monthEnd = (clone $monthStart)->endOfMonth();
            $months[] = $monthStart->format('M Y');
            $sum = Order::where('status', 'paid')
                ->whereBetween('created_at', [$monthStart->toDateTimeString(), $monthEnd->toDateTimeString()])
                ->sum('total');
            $revenueData[] = (float) number_format($sum, 2, '.', '');
        }

        // Top sellers (best-effort)
        try {
            $topSellers = DB::table('order_items')
                ->join('products', 'order_items.product_id', '=', 'products.id')
                ->join('users', 'products.user_id', '=', 'users.id')
                ->select(
                    'users.id as seller_id',
                    DB::raw("COALESCE(users.name, 'Unknown') as seller_name"),
                    DB::raw("COALESCE(users.email, '') as seller_email"),
                    DB::raw("SUM(order_items.line_total) as total_sales"),
                    DB::raw("COUNT(DISTINCT order_items.order_id) as orders_count")
                )
                ->groupBy('users.id', 'users.name', 'users.email')
                ->orderByDesc('total_sales')
                ->limit(8)
                ->get();
        } catch (\Throwable $e) {
            \Log::warning('Top sellers query failed: ' . $e->getMessage());
            $topSellers = collect();
        }

        return view('backend.dashboard.index', compact(
            'totalOrders',
            'totalRevenue',
            'totalUsers',
            'totalProducts',
            'recentOrders',
            'recentUsers',
            'pendingOrders',
            'paidOrders',
            'cancelledOrders',
            'months',
            'revenueData',
            'topSellers'
        ));
    }
}

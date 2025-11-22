<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Payment;
use App\Models\Role;

class DashboardController extends Controller
{
    /**
     * Show admin dashboard with stats.
     */
    public function index(Request $request): View
    {
        // Basic totals
        $totalOrders   = Order::count();
        $totalUsers    = User::count();
        $totalProducts = Product::count();
        $totalPayments = Payment::count();

        // Orders by status
        $ordersByStatus = Order::select('status', DB::raw('count(*) as cnt'))
            ->groupBy('status')->pluck('cnt','status')->toArray();

        $pendingOrders   = $ordersByStatus['pending'] ?? 0;
        $paidOrders      = $ordersByStatus['paid'] ?? 0;
        $cancelledOrders = $ordersByStatus['cancelled'] ?? 0;

        // Total confirmed revenue
        $totalRevenue = Payment::where('status','confirmed')->sum('amount');

        // Monthly revenue last 6 months
        $months = [];
        $revenueData = [];
        $now = Carbon::now();
        for ($i = 5; $i >= 0; $i--) {
            $dt = $now->copy()->subMonths($i);
            $label = $dt->format('M Y');
            $months[] = $label;

            $start = $dt->copy()->startOfMonth()->toDateTimeString();
            $end   = $dt->copy()->endOfMonth()->toDateTimeString();

            $monthRevenue = Payment::where('status','confirmed')
                ->whereBetween('created_at', [$start, $end])
                ->sum('amount');

            $revenueData[] = (float) $monthRevenue;
        }

        // Recent orders & recent users
        $recentOrders = Order::with('user')->latest()->take(10)->get();
        $recentUsers  = User::orderBy('created_at','desc')->take(10)->get();

        // Top sellers (sums of order_items.line_total for paid orders)
        // This assumes you have tables: order_items (order_id, product_id, line_total), products (user_id)
        $topSellers = DB::table('order_items')
            ->join('orders','order_items.order_id','=','orders.id')
            ->join('products','order_items.product_id','=','products.id')
            ->join('users','products.user_id','=','users.id')
            ->where('orders.status','paid')
            ->select(
                'users.id as seller_id',
                'users.name as seller_name',
                'users.email as seller_email',
                DB::raw('SUM(order_items.line_total) as total_sales'),
                DB::raw('COUNT(DISTINCT orders.id) as orders_count')
            )
            ->groupBy('users.id','users.name','users.email')
            ->orderByDesc('total_sales')
            ->limit(10)
            ->get();

        // Count sellers if you have role_user pivot and a role 'seller'
        $totalSellers = 0;
        try {
            $sellerRole = Role::where('name','seller')->first();
            if ($sellerRole) {
                $totalSellers = DB::table('role_user')->where('role_id', $sellerRole->id)->count();
            } else {
                // fallback if you store role string in users.role
                if (\Schema::hasColumn('users','role')) {
                    $totalSellers = User::where('role','seller')->count();
                }
            }
        } catch (\Throwable $e) {
            // schema might not exist; ignore and leave 0
            $totalSellers = 0;
        }

        // Optional "latest" items (null-safe)
        $latestOrder   = Order::latest()->first();
        $latestUser    = User::latest()->first();
        $latestProduct = Product::latest()->first();

        return view('backend.dashboard.index', compact(
            'totalOrders','totalUsers','totalProducts','totalPayments',
            'pendingOrders','paidOrders','cancelledOrders',
            'totalRevenue','months','revenueData',
            'recentOrders','recentUsers','topSellers','totalSellers',
            'latestOrder','latestUser','latestProduct'
        ));
    }
}

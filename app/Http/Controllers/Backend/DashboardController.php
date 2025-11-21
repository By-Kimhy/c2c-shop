<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $today = Carbon::today();
        $startOfMonth = Carbon::now()->startOfMonth();

        // Basic numbers
        $newOrdersCount = Order::whereDate('created_at', $today)->count();
        $uniqueVisitors = cache()->get('dashboard_unique_visitors', 123); // sample fallback
        $userRegistrations = User::whereDate('created_at', '>=', $startOfMonth)->count();
        $bounceRate = cache()->get('dashboard_bounce_rate', 42); // sample fallback %

        // Catalog & user stats
        $totalProducts = Product::count();
        $publishedProducts = Product::where('status','published')->count();
        $sellersCount = DB::table('role_user')
            ->join('roles','role_user.role_id','=','roles.id')
            ->where('roles.name','seller')
            ->distinct('user_id')
            ->count('user_id');

        // Orders
        $pendingOrders = Order::where('status','pending')->count();
        $paidOrders = Order::where('status','paid')->count();
        $monthlyRevenue = Order::where('status','paid')
            ->whereBetween('created_at', [$startOfMonth, Carbon::now()])
            ->sum('total');

        // Recent orders (last 10)
        $recentOrders = Order::with('user')->latest()->take(10)->get();

        // Sales last 14 days for chart
        $salesLast14 = Order::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total) as total')
            )
            ->where('status','paid')
            ->where('created_at', '>=', Carbon::now()->subDays(13)->startOfDay())
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->map(fn($r) => ['date' => $r->date, 'total' => (float)$r->total]);

        $labels = [];
        $values = [];
        for ($i = 13; $i >= 0; $i--) {
            $d = Carbon::today()->subDays($i)->toDateString();
            $labels[] = $d;
            $found = collect($salesLast14)->firstWhere('date', $d);
            $values[] = $found ? $found['total'] : 0;
        }

        // Render view (variables names match the Blade file)
        return view('backend.dashboard.index', [
            'newOrdersCount' => $newOrdersCount,
            'uniqueVisitors' => $uniqueVisitors,
            'userRegistrations' => $userRegistrations,
            'bounceRate' => $bounceRate,
            'totalProducts' => $totalProducts,
            'publishedProducts' => $publishedProducts,
            'sellersCount' => $sellersCount,
            'pendingOrders' => $pendingOrders,
            'paidOrders' => $paidOrders,
            'monthlyRevenue' => $monthlyRevenue,
            'recentOrders' => $recentOrders,
            'labels' => $labels,
            'values' => $values,
        ]);
    }
}

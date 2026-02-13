<?php

namespace App\Http\Controllers\Admin;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\User;
class DashboardController extends Controller
{
    public function index()
    {
        // Last 7 days
          $lastWeek = DB::table('visits')
               ->select('visit_date', DB::raw('COUNT(DISTINCT ip) as total'))
               ->whereBetween('visit_date', [now()->subDays(6), now()])
               ->groupBy('visit_date')
               ->pluck('total', 'visit_date');

          // Previous 7 days
          $prevWeek = DB::table('visits')
               ->select('visit_date', DB::raw('COUNT(DISTINCT ip) as total'))
               ->whereBetween('visit_date', [now()->subDays(13), now()->subDays(7)])
               ->groupBy('visit_date')
               ->pluck('total', 'visit_date');

          // Prepare labels (last 7 days)
          $labels = collect(range(0, 6))->map(fn ($i) =>
               now()->subDays(6 - $i)->format('M d')
          );

          $lastWeekData = collect(range(0, 6))->map(fn ($i) =>
               $lastWeek[now()->subDays(6 - $i)->toDateString()] ?? 0
          );

          $prevWeekData = collect(range(0, 6))->map(fn ($i) =>
               $prevWeek[now()->subDays(13 - $i)->toDateString()] ?? 0
          );

     // ===== SALES THIS WEEK =====
$thisWeekSales = DB::table('orders')
    ->selectRaw('DATE(created_at) as date, SUM(total_amount) as total')
    ->whereBetween('created_at', [now()->subDays(6), now()])
    ->groupBy('date')
    ->pluck('total', 'date');

// ===== SALES PREVIOUS WEEK =====
$lastWeekSales = DB::table('orders')
    ->selectRaw('DATE(created_at) as date, SUM(total_amount) as total')
    ->whereBetween('created_at', [now()->subDays(13), now()->subDays(7)])
    ->groupBy('date')
    ->pluck('total', 'date');

// ===== LABELS =====
$salesLabels = collect(range(0, 6))->map(fn ($i) =>
    now()->subDays(6 - $i)->format('M d')
);

// ===== DATA ALIGNMENT =====
$thisWeekSalesData = collect(range(0, 6))->map(fn ($i) =>
    $thisWeekSales[now()->subDays(6 - $i)->toDateString()] ?? 0
);

$lastWeekSalesData = collect(range(0, 6))->map(fn ($i) =>
    $lastWeekSales[now()->subDays(13 - $i)->toDateString()] ?? 0
);


      $thisWeek = DB::table('users')
        ->selectRaw('DATE(created_at) as date, COUNT(*) as total')
        ->whereBetween('created_at', [now()->subDays(6), now()])
        ->groupBy('date')
        ->pluck('total', 'date');

    // ===== REGISTRATION PREVIOUS WEEK =====
    $lastWeek = DB::table('users')
        ->selectRaw('DATE(created_at) as date, COUNT(*) as total')
        ->whereBetween('created_at', [now()->subDays(13), now()->subDays(7)])
        ->groupBy('date')
        ->pluck('total', 'date');

    // ===== LABELS (last 7 days dates) =====
    $registrationLabels = collect(range(0, 6))->map(fn ($i) =>
        now()->subDays(6 - $i)->format('M d')
    );

    // ===== DATA ALIGNMENT =====
    $thisWeekData = collect(range(0, 6))->map(fn ($i) =>
        $thisWeek[now()->subDays(6 - $i)->toDateString()] ?? 0
    );

    $lastWeekData = collect(range(0, 6))->map(fn ($i) =>
        $lastWeek[now()->subDays(13 - $i)->toDateString()] ?? 0
    );


          return view('admin.dashboard', compact(
               'labels',
               'lastWeekData',
               'prevWeekData',
               'salesLabels',
               'thisWeekSalesData',
               'lastWeekSalesData',
               'registrationLabels',
               'thisWeekData',
               'lastWeekData'
          ));
    }
   
     public function network()
    {
    
        $users = User::where('role', '!=', User::ROLE_ADMIN)
        ->latest()          // newest first
        ->paginate(10);

      return view('admin.recent_registrations.index', compact('users'));
    }
     public function siteAnalytics ()
    {
           // ===== Website Traffic (last 7 days) =====
    $traffic = DB::table('visits')
    ->selectRaw('visit_date,
        COUNT(DISTINCT ip) as visitors,
        SUM(page_views) as views')
    ->whereBetween('visit_date', [now()->subDays(6), now()])
    ->groupBy('visit_date')
    ->get()
    ->keyBy('visit_date');

// Labels
$trafficLabels = collect(range(0, 6))->map(fn ($i) =>
    now()->subDays(6 - $i)->format('M d')
);

// Visitors data
$visitorData = collect(range(0, 6))->map(fn ($i) =>
    $traffic[now()->subDays(6 - $i)->toDateString()]->visitors ?? 0
);

// Page views data
$pageViewData = collect(range(0, 6))->map(fn ($i) =>
    $traffic[now()->subDays(6 - $i)->toDateString()]->views ?? 0
);

    // ===== Sales Performance (last 7 days) =====
  // ===== MONTHLY SALES REVENUE (last 12 months) =====
$monthlySales = DB::table('orders')
    ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, SUM(total_amount) as total')
    ->where('created_at', '>=', now()->subMonths(11)->startOfMonth())
    ->groupBy('month')
    ->orderBy('month')
    ->pluck('total', 'month');

// Labels (last 12 months)
$monthlyLabels = collect(range(0, 11))->map(fn ($i) =>
    now()->subMonths(11 - $i)->format('M Y')
);

// Data aligned with labels
$monthlySalesData = collect(range(0, 11))->map(fn ($i) =>
    $monthlySales[now()->subMonths(11 - $i)->format('Y-m')] ?? 0
);

    // ===== Customer Engagement (new users last 7 days) =====
   // ===== WEEKLY CUSTOMER ENGAGEMENT (last 7 days) =====
$engagement = DB::table('visits')
    ->selectRaw('visit_date,
        COUNT(DISTINCT ip) as visitors,
        SUM(CASE WHEN page_views = 1 THEN 1 ELSE 0 END) as bounces')
    ->whereBetween('visit_date', [now()->subDays(6), now()])
    ->groupBy('visit_date')
    ->get()
    ->keyBy('visit_date');

// Orders per day
$orders = DB::table('orders')
    ->selectRaw('DATE(created_at) as date, COUNT(*) as total')
    ->whereBetween('created_at', [now()->subDays(6), now()])
    ->groupBy('date')
    ->pluck('total', 'date');

// Labels
$engagementLabels = collect(range(0, 6))->map(fn ($i) =>
    now()->subDays(6 - $i)->format('M d')
);

// Conversion rate %
$conversionRates = collect(range(0, 6))->map(function ($i) use ($engagement, $orders) {
    $date = now()->subDays(6 - $i)->toDateString();

    $visitors = $engagement[$date]->visitors ?? 0;
    $orderCount = $orders[$date] ?? 0;

    return $visitors > 0
        ? round(($orderCount / $visitors) * 100, 2)
        : 0;
});

// Bounce rate %
$bounceRates = collect(range(0, 6))->map(function ($i) use ($engagement) {
    $date = now()->subDays(6 - $i)->toDateString();

    $visitors = $engagement[$date]->visitors ?? 0;
    $bounces = $engagement[$date]->bounces ?? 0;

    return $visitors > 0
        ? round(($bounces / $visitors) * 100, 2)
        : 0;
});

    // ===== MLM Network Growth (distributors count trend) =====
    // ===== MLM NETWORK GROWTH (last 12 months) =====
$monthlyDistributors = User::where('role', User::ROLE_DISTRIBUTOR)
    ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as total')
    ->where('created_at', '>=', now()->subMonths(11)->startOfMonth())
    ->groupBy('month')
    ->orderBy('month')
    ->pluck('total', 'month');

// Labels for last 12 months
$mlmLabels = collect(range(0, 11))->map(fn ($i) =>
    now()->subMonths(11 - $i)->format('M Y')
);

// Monthly new distributors
$monthlyNewDistributors = collect(range(0, 11))->map(fn ($i) =>
    $monthlyDistributors[now()->subMonths(11 - $i)->format('Y-m')] ?? 0
);

// ===== TOTAL NETWORK SIZE (cumulative) =====
$cumulativeTotal = [];
$runningTotal = User::where('role', User::ROLE_DISTRIBUTOR)
    ->where('created_at', '<', now()->subMonths(11)->startOfMonth())
    ->count();

foreach ($monthlyNewDistributors as $value) {
    $runningTotal += $value;
    $cumulativeTotal[] = $runningTotal;
}

// ===== TOP SELLING PRODUCTS (current month) =====
$topProducts = DB::table('order_items')
    ->join('products', 'order_items.product_id', '=', 'products.id')
    ->select(
        'products.name',
        DB::raw('SUM(order_items.qty) as units_sold')
    )
    ->whereMonth('order_items.created_at', now()->month)
    ->whereYear('order_items.created_at', now()->year)
    ->groupBy('products.id', 'products.name')
    ->orderByDesc('units_sold')
    ->limit(5)
    ->get();

// Labels & data for chart
$topProductLabels = $topProducts->pluck('name');
$topProductUnits  = $topProducts->pluck('units_sold');

    return view('admin.site_analytics.index', compact(
        'trafficLabels',
        'visitorData',
        'pageViewData',
        'monthlySalesData',
         'monthlyLabels',
        'engagementLabels',
        'conversionRates',
        'bounceRates',
        'mlmLabels',
        'monthlyNewDistributors',
        'cumulativeTotal',
        'topProductLabels',
        'topProductUnits'
    ));
         //return view('admin.dashboard');
    }
      public function settings()
    {
        // return view('admin.dashboard');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Medicine;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $filter = request('chart', 'month');

        if ($filter === 'day') {
            $raw = Order::where('status', '!=', 'cancelled')
                ->where('created_at', '>=', now()->subDays(13)->startOfDay())
                ->select(DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d") as period'), DB::raw('SUM(total_amount) as total'))
                ->groupBy('period')->orderBy('period')->pluck('total', 'period');
            $labels = []; $salesData = [];
            for ($i = 13; $i >= 0; $i--) {
                $key = now()->subDays($i)->format('Y-m-d');
                $labels[] = now()->subDays($i)->format('M d');
                $salesData[] = (float) ($raw[$key] ?? 0);
            }
        } elseif ($filter === 'year') {
            $raw = Order::where('status', '!=', 'cancelled')
                ->where('created_at', '>=', now()->subYears(5)->startOfYear())
                ->select(DB::raw('DATE_FORMAT(created_at, "%Y") as period'), DB::raw('SUM(total_amount) as total'))
                ->groupBy('period')->orderBy('period')->pluck('total', 'period');
            $labels = []; $salesData = [];
            for ($i = 4; $i >= 0; $i--) {
                $key = now()->subYears($i)->format('Y');
                $labels[] = $key;
                $salesData[] = (float) ($raw[$key] ?? 0);
            }
        } else {
            $raw = Order::where('status', '!=', 'cancelled')
                ->where('created_at', '>=', now()->subMonths(11)->startOfMonth())
                ->select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") as period'), DB::raw('SUM(total_amount) as total'))
                ->groupBy('period')->orderBy('period')->pluck('total', 'period');
            $labels = []; $salesData = [];
            for ($i = 11; $i >= 0; $i--) {
                $key = now()->subMonths($i)->format('Y-m');
                $labels[] = now()->subMonths($i)->format('M Y');
                $salesData[] = (float) ($raw[$key] ?? 0);
            }
        }

        return view('admin.dashboard', [
            'totalMedicines' => Medicine::count(),
            'lowStockCount'  => Medicine::whereColumn('stock_quantity', '<=', 'reorder_level')->count(),
            'expiredCount'   => Medicine::where('expiry_date', '<', now())->count(),
            'totalOrders'    => Order::count(),
            'pendingOrders'  => Order::where('status', 'pending')->count(),
            'totalCustomers' => User::where('role', 'customer')->count(),
            'totalStaff'     => User::where('role', 'staff')->count(),
            'totalSales'     => Order::where('status', '!=', 'cancelled')->sum('total_amount'),
            'pendingSupplies'=> \App\Models\StockLog::where('status', 'pending')->count(),
            'lowStockMeds'   => Medicine::whereColumn('stock_quantity', '<=', 'reorder_level')->take(5)->get(),
            'chartLabels'    => $labels,
            'chartData'      => $salesData,
            'chartFilter'    => $filter,
        ]);
    }
}

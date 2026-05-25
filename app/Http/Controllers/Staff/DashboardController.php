<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $staffId = Auth::id();
        $today   = now()->toDateString();
        $filter  = request('chart', 'day');

        $todaySales = Order::where('dispensed_by', $staffId)
            ->where('status', 'dispensed')
            ->whereDate('dispensed_at', $today)
            ->sum('total_amount');

        $todayOrders    = Order::where('dispensed_by', $staffId)->whereDate('dispensed_at', $today)->count();
        $pendingOrders  = Order::where('status', 'pending')->count();
        $confirmedOrders = Order::where('status', 'confirmed')->count();

        if ($filter === 'day') {
            $raw = Order::where('dispensed_by', $staffId)
                ->where('status', 'dispensed')
                ->where('dispensed_at', '>=', now()->subDays(13)->startOfDay())
                ->select(DB::raw('DATE_FORMAT(dispensed_at, "%Y-%m-%d") as period'), DB::raw('SUM(total_amount) as total'))
                ->groupBy('period')->orderBy('period')->pluck('total', 'period');
            $labels = []; $salesData = [];
            for ($i = 13; $i >= 0; $i--) {
                $key = now()->subDays($i)->format('Y-m-d');
                $labels[]    = now()->subDays($i)->format('M d');
                $salesData[] = (float) ($raw[$key] ?? 0);
            }
        } elseif ($filter === 'year') {
            $raw = Order::where('dispensed_by', $staffId)
                ->where('status', 'dispensed')
                ->where('dispensed_at', '>=', now()->subYears(4)->startOfYear())
                ->select(DB::raw('DATE_FORMAT(dispensed_at, "%Y") as period'), DB::raw('SUM(total_amount) as total'))
                ->groupBy('period')->orderBy('period')->pluck('total', 'period');
            $labels = []; $salesData = [];
            for ($i = 4; $i >= 0; $i--) {
                $key = now()->subYears($i)->format('Y');
                $labels[]    = $key;
                $salesData[] = (float) ($raw[$key] ?? 0);
            }
        } else {
            $raw = Order::where('dispensed_by', $staffId)
                ->where('status', 'dispensed')
                ->where('dispensed_at', '>=', now()->subMonths(11)->startOfMonth())
                ->select(DB::raw('DATE_FORMAT(dispensed_at, "%Y-%m") as period'), DB::raw('SUM(total_amount) as total'))
                ->groupBy('period')->orderBy('period')->pluck('total', 'period');
            $labels = []; $salesData = [];
            for ($i = 11; $i >= 0; $i--) {
                $key = now()->subMonths($i)->format('Y-m');
                $labels[]    = now()->subMonths($i)->format('M Y');
                $salesData[] = (float) ($raw[$key] ?? 0);
            }
        }

        $recentOrders = Order::with('user')->latest()->take(8)->get();

        return view('staff.dashboard', compact(
            'todaySales', 'todayOrders', 'pendingOrders', 'confirmedOrders',
            'recentOrders', 'labels', 'salesData', 'filter'
        ));
    }
}

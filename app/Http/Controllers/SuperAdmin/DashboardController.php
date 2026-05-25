<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\UserRemovalRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $pendingUsers    = User::whereIn('role', ['admin', 'staff'])->where('approved', false)->latest()->get();
        $removalRequests = UserRemovalRequest::with(['targetUser', 'requester'])->where('status', 'pending')->latest()->get();
        $userQuery       = User::whereIn('role', ['admin', 'staff'])->latest();
        if (request('search')) {
            $userQuery->where(function($q) {
                $q->where('name', 'like', '%'.request('search').'%')
                  ->orWhere('email', 'like', '%'.request('search').'%')
                  ->orWhere('username', 'like', '%'.request('search').'%');
            });
        }
        $allUsers = $userQuery->paginate(15)->withQueryString();

        $filter     = request('chart', 'month');
        $totalSales = Order::where('status', '!=', 'cancelled')->sum('total_amount');

        if ($filter === 'day') {
            $raw = Order::where('status', '!=', 'cancelled')
                ->where('created_at', '>=', now()->subDays(13)->startOfDay())
                ->select(DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d") as period'), DB::raw('SUM(total_amount) as total'))
                ->groupBy('period')->orderBy('period')->pluck('total', 'period');
            $labels = []; $salesData = [];
            for ($i = 13; $i >= 0; $i--) {
                $key = now()->subDays($i)->format('Y-m-d');
                $labels[]    = now()->subDays($i)->format('M d');
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
                $labels[]    = $key;
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
                $labels[]    = now()->subMonths($i)->format('M Y');
                $salesData[] = (float) ($raw[$key] ?? 0);
            }
        }

        return view('superadmin.dashboard', compact(
            'pendingUsers', 'removalRequests', 'allUsers',
            'totalSales', 'labels', 'salesData', 'filter'
        ));
    }

    public function customers()
    {
        $query = \App\Models\User::where('role', 'customer')->with(['orders'])->latest();
        if (request('search')) {
            $query->where(function($q) {
                $q->where('name', 'like', '%'.request('search').'%')
                  ->orWhere('email', 'like', '%'.request('search').'%')
                  ->orWhere('username', 'like', '%'.request('search').'%');
            });
        }
        $customers = $query->paginate(15)->withQueryString();
        return view('superadmin.customers.index', compact('customers'));
    }

    public function sales()
    {
        $orders = \App\Models\Order::with(['user', 'items.medicine', 'dispenser'])->latest()->get();
        return view('superadmin.sales.index', compact('orders'));
    }

    public function approve(User $user)
    {
        $user->update(['approved' => true]);
        return back()->with('success', $user->name . ' has been approved.');
    }

    public function reject(User $user)
    {
        $user->delete();
        return back()->with('success', 'Account rejected and removed.');
    }

    public function removeUser(User $user)
    {
        if (!in_array($user->role, ['admin', 'staff'])) {
            return back()->with('error', 'You can only remove admin or staff accounts.');
        }
        $name = $user->name;
        $user->delete();
        return back()->with('success', $name . ' has been removed.');
    }

    public function approveRemoval(UserRemovalRequest $removalRequest)
    {
        $removalRequest->targetUser->delete();
        $removalRequest->update(['status' => 'approved', 'reviewed_by' => Auth::id()]);
        return back()->with('success', $removalRequest->targetUser->name ?? 'User' . ' has been removed.');
    }

    public function rejectRemoval(UserRemovalRequest $removalRequest)
    {
        $removalRequest->update(['status' => 'rejected', 'reviewed_by' => Auth::id()]);
        return back()->with('success', 'Removal request rejected.');
    }
}

<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Medicine;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        return view('customer.dashboard', [
            'totalOrders'   => Order::where('user_id', Auth::id())->count(),
            'pendingOrders' => Order::where('user_id', Auth::id())->where('status', 'pending')->count(),
            'recentOrders'  => Order::where('user_id', Auth::id())->with('items.medicine')->latest()->take(5)->get(),
            'featuredMeds'  => Medicine::where('status', 'active')->where('requires_prescription', false)->take(6)->get(),
        ]);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $query = Order::with(['user', 'items.medicine', 'dispenser'])->latest();
        if (request('search')) {
            $search = request('search');
            $query->where(function($q) use ($search) {
                $q->where('order_number', 'like', '%'.$search.'%')
                  ->orWhere('walkin_name', 'like', '%'.$search.'%')
                  ->orWhereHas('user', function($q) use ($search) {
                      $q->where('name', 'like', '%'.$search.'%');
                  });
            });
        }
        $orders = $query->get();
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'items.medicine', 'dispenser']);
        return view('admin.orders.show', compact('order'));
    }

    public function receipt(Order $order)
    {
        $order->load(['user', 'items.medicine', 'dispenser']);
        return view('admin.orders.receipt', compact('order'));
    }
}

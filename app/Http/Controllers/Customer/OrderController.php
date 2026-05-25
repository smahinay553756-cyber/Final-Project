<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Medicine;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function catalog(Request $request)
    {
        $query = Medicine::where('status', 'active')->where('stock_quantity', '>', 0);
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('generic_name', 'like', "%{$request->search}%")
                  ->orWhere('brand', 'like', "%{$request->search}%");
            });
        }
        if ($request->category) {
            $query->where('category', $request->category);
        }
        return view('customer.catalog', [
            'medicines'  => $query->paginate(12),
            'categories' => Medicine::distinct()->pluck('category'),
        ]);
    }

    public function index()
    {
        $orders = Order::where('user_id', Auth::id())->with('items.medicine')->latest()->paginate(10);
        return view('customer.orders.index', compact('orders'));
    }

    public function create(Request $request)
    {
        $medicine = Medicine::findOrFail($request->medicine_id);
        return view('customer.orders.create', compact('medicine'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'medicine_id'    => 'required|exists:medicines,id',
            'quantity'       => 'required|integer|min:1',
            'payment_method' => 'required|in:cash,card,gcash',
            'notes'          => 'nullable|string',
        ]);

        $order = DB::transaction(function () use ($request) {
            $medicine = Medicine::lockForUpdate()->findOrFail($request->medicine_id);

            if ($medicine->stock_quantity < $request->quantity) {
                throw new \Exception('Insufficient stock. Available: ' . $medicine->stock_quantity);
            }

            $subtotal = $medicine->selling_price * $request->quantity;

            $order = Order::create([
                'user_id'                => Auth::id(),
                'order_number'           => 'ORD-'.strtoupper(Str::random(8)),
                'total_amount'           => $subtotal,
                'status'                 => 'pending',
                'payment_method'         => $request->payment_method,
                'payment_status'         => $request->pay_later ? 'pending' : 'paid',
                'notes'                  => $request->notes,
                'prescription_required'  => $medicine->requires_prescription,
            ]);

            OrderItem::create([
                'order_id'    => $order->id,
                'medicine_id' => $medicine->id,
                'quantity'    => $request->quantity,
                'unit_price'  => $medicine->selling_price,
                'subtotal'    => $subtotal,
            ]);

            return $order;
        });

        return redirect()->route('customer.orders.index')->with('success', 'Order placed successfully! Order #'.$order->order_number);
    }

    public function show(Order $order)
    {
        abort_if($order->user_id !== Auth::id(), 403);
        $order->load('items.medicine');
        return view('customer.orders.show', compact('order'));
    }

    public function cancel(Order $order)
    {
        abort_if($order->user_id !== Auth::id(), 403);
        abort_if($order->status !== 'pending', 403, 'Only pending orders can be cancelled.');
        $order->update(['status' => 'cancelled']);
        return back()->with('success', 'Order cancelled.');
    }

    public function pay(Order $order)
    {
        abort_if($order->user_id !== Auth::id(), 403);
        abort_if($order->payment_status === 'paid', 403, 'Order is already paid.');
        $order->update(['payment_status' => 'paid']);
        return back()->with('success', 'Payment confirmed. Thank you!');
    }

    public function receipt(Order $order)
    {
        abort_if($order->user_id !== Auth::id(), 403);
        abort_if($order->status !== 'dispensed', 403, 'Receipt is only available for dispensed orders.');
        $order->load(['user', 'items.medicine', 'dispenser']);
        return view('staff.orders.receipt', compact('order'));
    }
}

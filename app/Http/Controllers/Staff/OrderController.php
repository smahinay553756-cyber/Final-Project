<?php

namespace App\Http\Controllers\Staff;

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
    public function index()
    {
        $filter = request('type', 'all');
        $query  = Order::with(['user', 'items.medicine'])->latest();

        if ($filter === 'online') {
            $query->where('is_walkin', false);
        } elseif ($filter === 'walkin') {
            $query->where('is_walkin', true);
        }

        $orders = $query->get();
        return view('staff.orders.index', compact('orders', 'filter'));
    }

    public function walkinCreate()
    {
        $medicines = Medicine::where('status', 'active')->where('stock_quantity', '>', 0)->orderBy('name')->get();
        return view('staff.orders.walkin', compact('medicines'));
    }

    public function walkinStore(Request $request)
    {
        $request->validate([
            'walkin_name'         => 'nullable|string|max:255',
            'payment_method'      => 'required|in:cash,card,gcash',
            'payment_status'      => 'required|in:paid,pending',
            'items'               => 'required|array|min:1',
            'items.*.medicine_id' => 'required|exists:medicines,id',
            'items.*.quantity'    => 'required|integer|min:1',
        ]);

        $order = DB::transaction(function () use ($request) {
            $total      = 0;
            $orderItems = [];

            foreach ($request->items as $item) {
                $medicine = Medicine::lockForUpdate()->findOrFail($item['medicine_id']);
                if ($medicine->stock_quantity < $item['quantity']) {
                    throw new \Exception('Insufficient stock for ' . $medicine->name . '. Available: ' . $medicine->stock_quantity);
                }
                $subtotal     = $medicine->selling_price * $item['quantity'];
                $total       += $subtotal;
                $orderItems[] = [
                    'medicine'   => $medicine,
                    'quantity'   => $item['quantity'],
                    'unit_price' => $medicine->selling_price,
                    'subtotal'   => $subtotal,
                ];
            }

            $order = Order::create([
                'user_id'               => null,
                'order_number'          => 'ORD-' . strtoupper(Str::random(8)),
                'total_amount'          => $total,
                'status'                => 'dispensed',
                'payment_method'        => $request->payment_method,
                'payment_status'        => $request->payment_status,
                'notes'                 => $request->notes,
                'is_walkin'             => true,
                'walkin_name'           => $request->walkin_name ?: 'Walk-in Customer',
                'dispensed_by'          => Auth::id(),
                'dispensed_at'          => now(),
                'prescription_required' => false,
            ]);

            foreach ($orderItems as $item) {
                OrderItem::create([
                    'order_id'    => $order->id,
                    'medicine_id' => $item['medicine']->id,
                    'quantity'    => $item['quantity'],
                    'unit_price'  => $item['unit_price'],
                    'subtotal'    => $item['subtotal'],
                ]);
                $item['medicine']->decrement('stock_quantity', $item['quantity']);
            }

            return $order;
        });

        return redirect()->route('staff.orders.receipt', $order)->with('success', 'Walk-in order completed.');
    }

    public function show(Order $order)
    {
        $order->load(['user', 'items.medicine', 'dispenser']);
        return view('staff.orders.show', compact('order'));
    }

    public function updateStatus(Order $order, string $status)
    {
        if (!in_array($status, ['pending', 'confirmed', 'dispensed', 'cancelled'])) {
            return back()->with('error', 'Invalid status.');
        }

        $data = ['status' => $status];

        if ($status === 'dispensed' && $order->status !== 'dispensed') {
            foreach ($order->items as $item) {
                if ($item->medicine->stock_quantity < $item->quantity) {
                    return back()->with('error', 'Insufficient stock for ' . $item->medicine->name);
                }
            }
            $data['dispensed_by'] = Auth::id();
            $data['dispensed_at'] = now();
            foreach ($order->items as $item) {
                $item->medicine->decrement('stock_quantity', $item->quantity);
            }
        }

        $order->update($data);
        return back()->with('success', 'Order status updated.');
    }

    public function receipt(Order $order)
    {
        $order->load(['user', 'items.medicine', 'dispenser']);
        return view('staff.orders.receipt', compact('order'));
    }
}

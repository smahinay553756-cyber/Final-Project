<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Medicine;
use App\Models\StockLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StockController extends Controller
{
    public function index()
    {
        $medicines    = Medicine::latest()->get();
        $pendingCount = StockLog::where('staff_id', Auth::id())->where('status', 'pending')->count();
        return view('staff.stock.index', compact('medicines', 'pendingCount'));
    }

    public function stockIn(Request $request, Medicine $medicine)
    {
        $request->validate([
            'quantity'     => 'required|integer|min:1',
            'batch_number' => 'nullable|string|max:100',
            'expiry_date'  => 'nullable|date',
            'notes'        => 'nullable|string',
        ]);

        StockLog::create([
            'medicine_id'  => $medicine->id,
            'staff_id'     => Auth::id(),
            'type'         => 'in',
            'quantity'     => $request->quantity,
            'stock_before' => $medicine->stock_quantity,
            'stock_after'  => $medicine->stock_quantity + $request->quantity,
            'batch_number' => $request->batch_number,
            'expiry_date'  => $request->expiry_date,
            'notes'        => $request->notes,
            'status'       => 'pending',
        ]);

        return back()->with('success', 'Stock in request submitted. Waiting for admin approval.');
    }

    public function stockOut(Request $request, Medicine $medicine)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $medicine->stock_quantity,
            'notes'    => 'nullable|string',
        ]);

        StockLog::create([
            'medicine_id'  => $medicine->id,
            'staff_id'     => Auth::id(),
            'type'         => 'out',
            'quantity'     => $request->quantity,
            'stock_before' => $medicine->stock_quantity,
            'stock_after'  => $medicine->stock_quantity - $request->quantity,
            'notes'        => $request->notes,
            'status'       => 'pending',
        ]);

        return back()->with('success', 'Stock out request submitted. Waiting for admin approval.');
    }
}

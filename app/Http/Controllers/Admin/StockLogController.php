<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StockLog;
use Illuminate\Support\Facades\Auth;

class StockLogController extends Controller
{
    public function index()
    {
        $pending = StockLog::with(['medicine', 'staff'])->where('status', 'pending')->latest()->get();
        $logs    = StockLog::with(['medicine', 'staff', 'approver'])->whereIn('status', ['approved', 'rejected'])->latest()->get();
        return view('admin.stock_logs.index', compact('pending', 'logs'));
    }

    public function approve(StockLog $stockLog)
    {
        $medicine     = $stockLog->medicine;
        $stockBefore  = $medicine->stock_quantity;

        if ($stockLog->type === 'in') {
            $medicine->increment('stock_quantity', $stockLog->quantity);
            if ($stockLog->batch_number) $medicine->update(['batch_number' => $stockLog->batch_number]);
            if ($stockLog->expiry_date)  $medicine->update(['expiry_date'  => $stockLog->expiry_date]);
        } else {
            if ($medicine->stock_quantity < $stockLog->quantity) {
                return back()->withErrors(['error' => 'Insufficient stock to approve this request.']);
            }
            $medicine->decrement('stock_quantity', $stockLog->quantity);
        }

        $stockLog->update([
            'status'       => 'approved',
            'approved_by'  => Auth::id(),
            'approved_at'  => now(),
            'stock_before' => $stockBefore,
            'stock_after'  => $medicine->fresh()->stock_quantity,
        ]);

        return back()->with('success', 'Stock request approved and inventory updated.');
    }

    public function reject(StockLog $stockLog)
    {
        $stockLog->update([
            'status'      => 'rejected',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);

        return back()->with('success', 'Stock request rejected.');
    }
}

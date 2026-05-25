<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\StockLog;

class StockLogController extends Controller
{
    public function index()
    {
        $pending = StockLog::with(['medicine', 'staff'])->where('status', 'pending')->latest()->get();
        $logs    = StockLog::with(['medicine', 'staff', 'approver'])->whereIn('status', ['approved', 'rejected'])->latest()->paginate(20);
        return view('superadmin.stock_logs.index', compact('logs', 'pending'));
    }
}

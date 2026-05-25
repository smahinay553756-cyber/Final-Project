<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SupplyRequest;

class SupplyRequestController extends Controller
{
    public function index()
    {
        $requests = SupplyRequest::with(['supplier', 'medicine'])->latest()->paginate(10);
        return view('admin.supply_requests.index', compact('requests'));
    }

    public function approve(SupplyRequest $supplyRequest)
    {
        $supplyRequest->update(['status' => 'approved']);
        $med = $supplyRequest->medicine;
        $med->increment('stock_quantity', $supplyRequest->quantity_supplied);
        if ($supplyRequest->batch_number) $med->update(['batch_number' => $supplyRequest->batch_number]);
        if ($supplyRequest->expiry_date)  $med->update(['expiry_date' => $supplyRequest->expiry_date]);
        if ($supplyRequest->manufacture_date) $med->update(['manufacture_date' => $supplyRequest->manufacture_date]);
        return back()->with('success', 'Supply request approved and stock updated.');
    }

    public function reject(SupplyRequest $supplyRequest)
    {
        $supplyRequest->update(['status' => 'rejected']);
        return back()->with('success', 'Supply request rejected.');
    }
}

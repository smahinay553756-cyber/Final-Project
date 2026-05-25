@extends('layouts.app')
@section('title', 'Order Details')
@section('page-title', 'Order #' . $order->order_number)
@section('page-subtitle', 'Order Details')

@section('sidebar-nav')
<div class="nav-section-title">Main</div>
<a href="{{ route('admin.dashboard') }}">Dashboard</a>
<div class="nav-section-title">Inventory</div>
<a href="{{ route('admin.medicines.index') }}">Medicines</a>
<a href="{{ route('admin.supplies.index') }}">Supplies Log</a>
<div class="nav-section-title">Sales</div>
<a href="{{ route('admin.orders.index') }}" class="active">Orders</a>
<div class="nav-section-title">Management</div>
<a href="{{ route('admin.users.index') }}">Users</a>
@endsection

@section('content')
<div style="display:flex;gap:8px;margin-bottom:16px;">
    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Back</a>
    <a href="{{ route('admin.orders.receipt', $order) }}" class="btn btn-success">View Receipt</a>
</div>

<div style="display:grid;grid-template-columns:2fr 1fr;gap:20px;">
    <div>
        <div class="pharma-card">
            <div class="pharma-card-header">
                <span class="pharma-card-title">Order Items</span>
                @php $sc = ['pending'=>'warning','confirmed'=>'info','dispensed'=>'success','cancelled'=>'danger'][$order->status] ?? 'dark' @endphp
                <span class="badge badge-{{ $sc }}">{{ $order->status }}</span>
            </div>
            <div style="padding:0;">
                <table class="pharma-table">
                    <thead>
                        <tr><th>Medicine</th><th>Dosage</th><th>Qty</th><th>Unit Price</th><th>Subtotal</th></tr>
                    </thead>
                    <tbody>
                    @foreach($order->items as $item)
                    <tr>
                        <td>
                            <strong>{{ $item->medicine->name }}</strong><br>
                            <small class="text-muted">{{ $item->medicine->generic_name }}</small>
                        </td>
                        <td>{{ $item->medicine->dosage_strength }}{{ $item->medicine->dosage_unit }} {{ $item->medicine->dosage_form }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>&#8369;{{ number_format($item->unit_price, 2) }}</td>
                        <td><strong>&#8369;{{ number_format($item->subtotal, 2) }}</strong></td>
                    </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                        <tr style="background:#f8f9fb;">
                            <td colspan="4" style="text-align:right;font-weight:600;padding:12px 16px;">Total Amount</td>
                            <td style="font-weight:700;font-size:15px;color:var(--green);padding:12px 16px;">&#8369;{{ number_format($order->total_amount, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <div>
        <div class="pharma-card">
            <div class="pharma-card-header"><span class="pharma-card-title">Customer</span></div>
            <div class="pharma-card-body">
                <div class="medicine-detail-row"><span class="medicine-detail-label">Name</span><span class="medicine-detail-value">{{ $order->customer_name }}</span></div>
                @if($order->is_walkin)
                <div class="medicine-detail-row"><span class="medicine-detail-label">Type</span><span class="medicine-detail-value"><span class="badge badge-info">Walk-in</span></span></div>
                @else
                <div class="medicine-detail-row"><span class="medicine-detail-label">Phone</span><span class="medicine-detail-value">{{ $order->user?->phone ?? '—' }}</span></div>
                <div class="medicine-detail-row"><span class="medicine-detail-label">Address</span><span class="medicine-detail-value">{{ $order->user?->address ?? '—' }}</span></div>
                @endif
            </div>
        </div>

        <div class="pharma-card">
            <div class="pharma-card-header"><span class="pharma-card-title">Payment</span></div>
            <div class="pharma-card-body">
                <div class="medicine-detail-row"><span class="medicine-detail-label">Method</span><span class="medicine-detail-value">{{ strtoupper($order->payment_method) }}</span></div>
                <div class="medicine-detail-row"><span class="medicine-detail-label">Status</span>
                    <span class="badge badge-{{ $order->payment_status=='paid'?'success':'warning' }}">{{ $order->payment_status }}</span>
                </div>
                <div class="medicine-detail-row"><span class="medicine-detail-label">Prescription</span><span class="medicine-detail-value">{{ $order->prescription_required ? 'Required' : 'Not required' }}</span></div>
            </div>
        </div>

        <div class="pharma-card">
            <div class="pharma-card-header"><span class="pharma-card-title">Handled By</span></div>
            <div class="pharma-card-body">
                <div class="medicine-detail-row"><span class="medicine-detail-label">Staff</span><span class="medicine-detail-value">{{ $order->dispenser?->name ?? 'Not yet dispensed' }}</span></div>
                @if($order->dispensed_at)
                <div class="medicine-detail-row"><span class="medicine-detail-label">Dispensed At</span><span class="medicine-detail-value">{{ $order->dispensed_at->format('M d, Y g:i A') }}</span></div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

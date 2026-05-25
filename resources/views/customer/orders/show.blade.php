@extends('layouts.app')
@section('title', 'Order Details')
@section('page-title', 'Order #' . $order->order_number)
@section('page-subtitle', 'Order Details')

@section('sidebar-nav')
<div class="nav-section-title">Main</div>
<a href="{{ route('customer.dashboard') }}">Dashboard</a>
<div class="nav-section-title">Shop</div>
<a href="{{ route('customer.catalog') }}">Medicine Catalog</a>
<div class="nav-section-title">My Orders</div>
<a href="{{ route('customer.orders.index') }}" class="active">My Orders</a>
@endsection

@section('content')
<div style="display:flex;gap:8px;margin-bottom:16px;">
    <a href="{{ route('customer.orders.index') }}" class="btn btn-secondary">Back to Orders</a>
    @if($order->status === 'pending')
    <form method="POST" action="{{ route('customer.orders.cancel', $order) }}" onsubmit="return confirm('Cancel this order?')">
        @csrf @method('PATCH')
        <button class="btn btn-danger">Cancel Order</button>
    </form>
    @endif
    @if($order->payment_status !== 'paid' && $order->status !== 'cancelled')
    <button type="button" class="btn btn-primary" onclick="document.getElementById('pay-modal').style.display='flex'">Pay Now</button>
    @endif
    @if($order->status === 'dispensed')
    <a href="{{ route('customer.orders.receipt', $order) }}" target="_blank" class="btn btn-success">View Receipt</a>
    @endif
</div>

{{-- Payment Confirmation Modal --}}
<div id="pay-modal" style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.5);z-index:9999;align-items:center;justify-content:center;">
    <div style="background:#fff;border-radius:var(--radius);max-width:400px;width:90%;padding:24px;box-shadow:0 10px 40px rgba(0,0,0,0.2);">
        <div style="font-size:18px;font-weight:700;color:var(--navy);margin-bottom:8px;">Confirm Payment</div>
        <div style="font-size:14px;color:var(--muted);margin-bottom:20px;">You are about to confirm payment for this order. This action cannot be undone.</div>
        <div style="background:#f4f6f9;border:1px solid var(--border);border-radius:var(--radius);padding:12px;margin-bottom:20px;">
            <div style="font-size:13px;margin-bottom:6px;"><strong>Order:</strong> {{ $order->order_number }}</div>
            <div style="font-size:13px;margin-bottom:6px;"><strong>Payment Method:</strong> {{ strtoupper($order->payment_method) }}</div>
            <div style="font-size:15px;font-weight:700;color:var(--green);margin-top:10px;padding-top:10px;border-top:1px solid var(--border);"><strong>Total:</strong> &#8369;{{ number_format($order->total_amount, 2) }}</div>
        </div>
        <div style="display:flex;gap:10px;">
            <button type="button" class="btn btn-secondary" style="flex:1;justify-content:center;" onclick="document.getElementById('pay-modal').style.display='none'">Cancel</button>
            <form method="POST" action="{{ route('customer.orders.pay', $order) }}" style="flex:1;">
                @csrf @method('PATCH')
                <button type="submit" class="btn btn-primary w-100" style="justify-content:center;">Confirm Payment</button>
            </form>
        </div>
    </div>
</div>

<div style="display:grid;grid-template-columns:2fr 1fr;gap:20px;">
    <div class="pharma-card">
        <div class="pharma-card-header">
            <span class="pharma-card-title">Order Items</span>
            @php $sc = ['pending'=>'warning','confirmed'=>'info','dispensed'=>'success','cancelled'=>'danger'][$order->status] ?? 'dark' @endphp
            <span class="badge badge-{{ $sc }}" style="font-size:12px;padding:4px 12px;">{{ strtoupper($order->status) }}</span>
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
                        <td colspan="4" style="text-align:right;font-weight:600;padding:12px 16px;color:var(--slate);">Total Amount</td>
                        <td style="font-weight:700;font-size:16px;color:var(--green);padding:12px 16px;">&#8369;{{ number_format($order->total_amount, 2) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <div>
        <div class="pharma-card">
            <div class="pharma-card-header"><span class="pharma-card-title">Order Information</span></div>
            <div class="pharma-card-body">
                <div class="medicine-detail-row"><span class="medicine-detail-label">Order Number</span><span class="medicine-detail-value">{{ $order->order_number }}</span></div>
                <div class="medicine-detail-row"><span class="medicine-detail-label">Date Placed</span><span class="medicine-detail-value">{{ $order->created_at->format('M d, Y g:i A') }}</span></div>
                <div class="medicine-detail-row"><span class="medicine-detail-label">Payment Method</span><span class="medicine-detail-value">{{ strtoupper($order->payment_method) }}</span></div>
                <div class="medicine-detail-row">
                    <span class="medicine-detail-label">Payment Status</span>
                    <span class="badge badge-{{ $order->payment_status=='paid'?'success':'warning' }}">{{ $order->payment_status }}</span>
                </div>
                <div class="medicine-detail-row"><span class="medicine-detail-label">Prescription</span><span class="medicine-detail-value">{{ $order->prescription_required ? 'Required' : 'Not required' }}</span></div>
                @if($order->notes)
                <div style="margin-top:10px;padding:10px;background:#f4f6f9;border-radius:var(--radius);border:1px solid var(--border);">
                    <div class="text-muted" style="font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:4px;">Notes</div>
                    <div style="font-size:13px;">{{ $order->notes }}</div>
                </div>
                @endif
            </div>
        </div>

        <div class="pharma-card">
            <div class="pharma-card-header"><span class="pharma-card-title">Order Progress</span></div>
            <div class="pharma-card-body">
                @php
                    $steps = ['pending', 'confirmed', 'dispensed'];
                    $currentIdx = array_search($order->status, $steps);
                @endphp
                @if($order->status !== 'cancelled')
                    @foreach($steps as $i => $step)
                    <div style="display:flex;align-items:center;gap:12px;padding:9px 0;{{ $i < count($steps)-1 ? 'border-bottom:1px solid #f0f2f5;' : '' }}">
                        <div style="
                            width:26px;height:26px;border-radius:50%;
                            display:flex;align-items:center;justify-content:center;
                            font-size:12px;font-weight:700;flex-shrink:0;
                            background:{{ $currentIdx !== false && $i <= $currentIdx ? 'var(--green)' : '#e8ecf0' }};
                            color:{{ $currentIdx !== false && $i <= $currentIdx ? '#fff' : '#a0aec0' }};">
                            {{ $currentIdx !== false && $i <= $currentIdx ? '✓' : ($i + 1) }}
                        </div>
                        <span style="font-size:13px;font-weight:{{ $currentIdx !== false && $i === $currentIdx ? '700' : '400' }};color:{{ $currentIdx !== false && $i <= $currentIdx ? 'var(--navy)' : '#a0aec0' }};">
                            {{ ucfirst($step) }}
                        </span>
                    </div>
                    @endforeach
                @else
                    <div style="text-align:center;padding:10px;">
                        <span class="badge badge-danger" style="font-size:13px;padding:6px 14px;">Cancelled</span>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

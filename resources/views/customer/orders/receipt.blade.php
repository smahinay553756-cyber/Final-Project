@extends('layouts.app')
@section('title', 'Receipt — '.$order->order_number)
@section('page-title', 'Receipt')
@section('page-subtitle', 'Official receipt details')

@section('content')
<div class="pharma-card">
    <div style="text-align:center;border-bottom:2px dashed var(--border);padding-bottom:16px;margin-bottom:16px;">
        <h1 style="font-size:22px;font-weight:800;letter-spacing:2px;text-transform:uppercase;margin:0;">Pharmacy</h1>
        <p style="margin:4px 0 0 0;font-size:11px;color:#666;">Management System</p>
        <p style="margin:6px 0 0 0;font-size:11px;color:#666;">Official Receipt</p>
    </div>

    <div style="margin-bottom:16px;">
        <div style="display:flex;justify-content:space-between;gap:16px;font-size:12px;margin:6px 0;">
            <span style="color:#666;">Receipt No.</span>
            <span style="font-weight:700;">{{ $order->order_number }}</span>
        </div>
        <div style="display:flex;justify-content:space-between;gap:16px;font-size:12px;margin:6px 0;">
            <span style="color:#666;">Date</span>
            <span style="font-weight:700;">{{ $order->dispensed_at?->format('M d, Y') ?? now()->format('M d, Y') }}</span>
        </div>
        <div style="display:flex;justify-content:space-between;gap:16px;font-size:12px;margin:6px 0;">
            <span style="color:#666;">Time</span>
            <span style="font-weight:700;">{{ $order->dispensed_at?->format('g:i A') ?? now()->format('g:i A') }}</span>
        </div>
        <div style="display:flex;justify-content:space-between;gap:16px;font-size:12px;margin:6px 0;">
            <span style="color:#666;">Customer</span>
            <span style="font-weight:700;">{{ $order->customer_name }}</span>
        </div>

        @if($order->is_walkin)
            <div style="display:flex;justify-content:space-between;gap:16px;font-size:12px;margin:6px 0;">
                <span style="color:#666;">Type</span>
                <span style="font-weight:700;">Walk-in</span>
            </div>
        @elseif($order->user?->phone)
            <div style="display:flex;justify-content:space-between;gap:16px;font-size:12px;margin:6px 0;">
                <span style="color:#666;">Phone</span>
                <span style="font-weight:700;">{{ $order->user->phone }}</span>
            </div>
        @endif
    </div>

    <hr style="border:none;border-top:1px dashed var(--border);margin:14px 0;">

    <div style="margin-bottom:4px;">
        @foreach($order->items as $item)
            <div style="margin-bottom:10px;">
                <div style="font-size:13px;font-weight:800;">{{ $item->medicine->name }}</div>
                <div style="font-size:11px;color:#666;margin-top:2px;">
                    {{ $item->medicine->dosage_strength }}{{ $item->medicine->dosage_unit }} {{ $item->medicine->dosage_form }}{{ $item->medicine->brand ? ' — '.$item->medicine->brand : '' }}
                </div>
                <div style="display:flex;justify-content:space-between;font-size:12px;margin-top:4px;">
                    <span>{{ $item->quantity }} x &#8369;{{ number_format($item->unit_price, 2) }}</span>
                    <span>&#8369;{{ number_format($item->subtotal, 2) }}</span>
                </div>
            </div>
        @endforeach
    </div>

    <div style="border-top:2px dashed var(--border);padding-top:12px;margin-top:12px;">
        <div style="display:flex;justify-content:space-between;font-size:13px;margin-bottom:6px;">
            <span style="color:#666;">Subtotal</span>
            <span style="font-weight:800;">&#8369;{{ number_format($order->total_amount, 2) }}</span>
        </div>
        <div style="display:flex;justify-content:space-between;font-size:13px;margin-bottom:6px;">
            <span style="color:#666;">Payment Method</span>
            <span style="font-weight:800;">{{ strtoupper($order->payment_method) }}</span>
        </div>
        <div style="display:flex;justify-content:space-between;font-size:13px;margin-bottom:6px;">
            <span style="color:#666;">Payment Status</span>
            <span style="font-weight:800;">{{ strtoupper($order->payment_status) }}</span>
        </div>
        <div style="display:flex;justify-content:space-between;font-size:16px;font-weight:900;border-top:1px solid #000;padding-top:8px;margin-top:4px;">
            <span>TTL</span>
            <span>&#8369;{{ number_format($order->total_amount, 2) }}</span>
        </div>
    </div>

    @if($order->prescription_required)
        <div style="font-size:11px;color:#c0392b;margin-top:12px;text-align:center;font-weight:800;">
            PRESCRIPTION REQUIRED — Please present valid Rx
        </div>
    @endif

    <div style="background:#f8f9fb;border:1px solid #e2e8f0;padding:10px 12px;margin-top:14px;font-size:12px;">
        <div style="color:#666;font-size:11px;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:4px;">Dispensed by</div>
        <div style="font-weight:900;font-size:13px;">{{ $order->dispenser?->name ?? 'Staff' }}</div>
    </div>

    <div style="text-align:center;margin-top:20px;padding-top:16px;border-top:2px dashed var(--border);">
        <p style="font-size:11px;color:#666;margin-bottom:4px;">This serves as your official receipt.</p>
        <p style="font-size:11px;color:#666;margin-bottom:4px;">Please keep this for your records.</p>
        <div style="font-size:14px;font-weight:900;letter-spacing:1px;margin-top:8px;">THANK YOU!</div>
    </div>

    <div style="text-align:center;margin-top:18px;">
        <button class="btn btn-success" onclick="window.print()">Print Receipt</button>
        <a class="btn btn-outline-success" href="{{ route('customer.orders.index') }}" style="margin-left:8px;">Back to Orders</a>
    </div>
</div>
@endsection


@extends('layouts.app')
@section('title', $medicine->name)
@section('page-title', $medicine->name)
@section('page-subtitle', 'Medicine Details')

@section('sidebar-nav')
<div class="nav-section-title">Main</div>
<a href="{{ route('admin.dashboard') }}">Dashboard</a>
<div class="nav-section-title">Inventory</div>
<a href="{{ route('admin.medicines.index') }}" class="active">Medicines</a>
<a href="{{ route('admin.supplies.index') }}">Supplies Log</a>
<div class="nav-section-title">Sales</div>
<a href="{{ route('admin.orders.index') }}">Orders</a>
<div class="nav-section-title">Management</div>
<a href="{{ route('admin.users.index') }}">Users</a>
@endsection

@section('content')
<div style="display:flex;gap:8px;margin-bottom:16px;">
    <a href="{{ route('admin.medicines.edit', $medicine) }}" class="btn btn-warning">Edit</a>
    <a href="{{ route('admin.medicines.index') }}" class="btn btn-secondary">Back</a>
</div>

<div style="display:grid;grid-template-columns:2fr 1fr;gap:20px;">
    <div>
        <div class="pharma-card">
            <div class="pharma-card-header">
                <span class="pharma-card-title">Medicine Details</span>
                @php $sc = ['active'=>'success','inactive'=>'warning','discontinued'=>'danger'][$medicine->status] ?? 'dark' @endphp
                <span class="badge badge-{{ $sc }}">{{ $medicine->status }}</span>
            </div>
            <div class="detail-grid">
                <div class="detail-item"><div class="detail-item-label">Medicine Name</div><div class="detail-item-value">{{ $medicine->name }}</div></div>
                <div class="detail-item"><div class="detail-item-label">Generic Name</div><div class="detail-item-value">{{ $medicine->generic_name ?? '—' }}</div></div>
                <div class="detail-item"><div class="detail-item-label">Brand</div><div class="detail-item-value">{{ $medicine->brand ?? '—' }}</div></div>
                <div class="detail-item"><div class="detail-item-label">Category</div><div class="detail-item-value"><span class="badge badge-primary">{{ $medicine->category }}</span></div></div>
                <div class="detail-item"><div class="detail-item-label">Dosage Form</div><div class="detail-item-value">{{ $medicine->dosage_form }}</div></div>
                <div class="detail-item"><div class="detail-item-label">Dosage Strength</div><div class="detail-item-value">{{ $medicine->dosage_strength }}{{ $medicine->dosage_unit }}</div></div>
                <div class="detail-item"><div class="detail-item-label">Weight per Unit</div><div class="detail-item-value">{{ $medicine->weight_grams ? $medicine->weight_grams.' g' : '—' }}</div></div>
                <div class="detail-item"><div class="detail-item-label">Manufacturer</div><div class="detail-item-value">{{ $medicine->manufacturer ?? '—' }}</div></div>
                <div class="detail-item"><div class="detail-item-label">Batch Number</div><div class="detail-item-value">{{ $medicine->batch_number ?? '—' }}</div></div>
                <div class="detail-item"><div class="detail-item-label">Manufacture Date</div><div class="detail-item-value">{{ $medicine->manufacture_date?->format('M d, Y') ?? '—' }}</div></div>
                <div class="detail-item">
                    <div class="detail-item-label">Expiry Date</div>
                    <div class="detail-item-value">
                        @if($medicine->expiry_date)
                            @if($medicine->isExpired())
                                <span class="badge badge-danger">{{ $medicine->expiry_date->format('M d, Y') }} — Expired</span>
                            @else
                                {{ $medicine->expiry_date->format('M d, Y') }}
                            @endif
                        @else —
                        @endif
                    </div>
                </div>
                <div class="detail-item"><div class="detail-item-label">Storage Condition</div><div class="detail-item-value">{{ $medicine->storage_condition ?? '—' }}</div></div>
                <div class="detail-item"><div class="detail-item-label">Requires Prescription</div><div class="detail-item-value">{{ $medicine->requires_prescription ? 'Yes' : 'No' }}</div></div>
                <div class="detail-item"><div class="detail-item-label">Supplier</div><div class="detail-item-value">{{ $medicine->supplier?->name ?? '—' }}</div></div>
            </div>
        </div>

        @if($medicine->description)
        <div class="pharma-card">
            <div class="pharma-card-header"><span class="pharma-card-title">Description</span></div>
            <div class="pharma-card-body"><p>{{ $medicine->description }}</p></div>
        </div>
        @endif

        @if($medicine->side_effects || $medicine->contraindications)
        <div class="pharma-card">
            <div class="pharma-card-header"><span class="pharma-card-title">Clinical Information</span></div>
            <div class="pharma-card-body">
                @if($medicine->side_effects)
                    <div class="section-divider">Side Effects</div>
                    <p style="margin-bottom:14px;">{{ $medicine->side_effects }}</p>
                @endif
                @if($medicine->contraindications)
                    <div class="section-divider">Contraindications</div>
                    <p>{{ $medicine->contraindications }}</p>
                @endif
            </div>
        </div>
        @endif
    </div>

    <div>
        <div class="pharma-card">
            <div class="pharma-card-header"><span class="pharma-card-title">Stock &amp; Pricing</span></div>
            <div class="pharma-card-body">
                <div style="text-align:center;padding:14px 0 18px;">
                    <div style="font-size:44px;font-weight:700;letter-spacing:-2px;color:{{ $medicine->isLowStock() ? 'var(--red)' : 'var(--green)' }};">
                        {{ $medicine->stock_quantity }}
                    </div>
                    <div style="font-size:12px;color:var(--muted);margin-top:2px;">Units in Stock</div>
                    @if($medicine->isLowStock())
                        <span class="badge badge-danger" style="margin-top:8px;">Low Stock</span>
                    @endif
                </div>
                <div class="stock-bar-wrap" style="margin-bottom:16px;">
                    @php
                        $pct = $medicine->reorder_level > 0 ? min(100, ($medicine->stock_quantity / ($medicine->reorder_level * 3)) * 100) : 100;
                        $cls = $pct < 33 ? 'low' : ($pct < 66 ? 'medium' : '');
                    @endphp
                    <div class="stock-bar"><div class="stock-bar-fill {{ $cls }}" style="width:{{ $pct }}%"></div></div>
                    <small class="text-muted">Reorder at {{ $medicine->reorder_level }} units</small>
                </div>
                <div style="border-top:1px solid var(--border);padding-top:14px;">
                    <div class="medicine-detail-row">
                        <span class="medicine-detail-label">Unit Cost</span>
                        <span class="medicine-detail-value">&#8369;{{ number_format($medicine->unit_price, 2) }}</span>
                    </div>
                    <div class="medicine-detail-row">
                        <span class="medicine-detail-label">Selling Price</span>
                        <span class="medicine-detail-value text-primary" style="font-size:16px;">&#8369;{{ number_format($medicine->selling_price, 2) }}</span>
                    </div>
                    <div class="medicine-detail-row">
                        <span class="medicine-detail-label">Margin</span>
                        <span class="medicine-detail-value text-success">&#8369;{{ number_format($medicine->selling_price - $medicine->unit_price, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

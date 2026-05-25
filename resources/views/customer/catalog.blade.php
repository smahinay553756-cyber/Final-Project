@extends('layouts.app')
@section('title', 'Medicine Catalog')
@section('page-title', 'Medicine Catalog')
@section('page-subtitle', 'Browse available medicines')

@section('sidebar-nav')
<div class="nav-section-title">Main</div>
<a href="{{ route('customer.dashboard') }}">Dashboard</a>
<div class="nav-section-title">Shop</div>
<a href="{{ route('customer.catalog') }}" class="active">Medicine Catalog</a>
<div class="nav-section-title">My Orders</div>
<a href="{{ route('customer.orders.index') }}">My Orders</a>
@endsection

@section('content')
<div class="pharma-card" style="margin-bottom:18px;">
    <div class="pharma-card-body" style="padding:12px 18px;">
        <form method="GET" style="display:flex;gap:10px;flex-wrap:wrap;">
            <input type="text" name="search" class="form-control" placeholder="Search by name, generic name, or brand..." value="{{ request('search') }}" style="max-width:300px;">
            <select name="category" class="form-control" style="max-width:180px;">
                <option value="">All Categories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat }}" {{ request('category')==$cat?'selected':'' }}>{{ $cat }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-primary">Search</button>
            <a href="{{ route('customer.catalog') }}" class="btn btn-secondary">Reset</a>
        </form>
    </div>
</div>

@if($medicines->isEmpty())
    <div class="empty-state"><p>No medicines found matching your search.</p></div>
@else
<div class="medicine-grid">
    @foreach($medicines as $med)
    <div class="medicine-card">
        <div class="medicine-card-header">
            <div class="medicine-card-name">{{ $med->name }}</div>
            <div class="medicine-card-generic">{{ $med->generic_name }}</div>
        </div>
        <div class="medicine-card-body">
            <div class="medicine-detail-row">
                <span class="medicine-detail-label">Brand</span>
                <span class="medicine-detail-value">{{ $med->brand ?? '—' }}</span>
            </div>
            <div class="medicine-detail-row">
                <span class="medicine-detail-label">Category</span>
                <span class="badge badge-primary">{{ $med->category }}</span>
            </div>
            <div class="medicine-detail-row">
                <span class="medicine-detail-label">Dosage Form</span>
                <span class="medicine-detail-value">{{ $med->dosage_form }}</span>
            </div>
            <div class="medicine-detail-row">
                <span class="medicine-detail-label">Strength</span>
                <span class="medicine-detail-value">{{ $med->dosage_strength }}{{ $med->dosage_unit }}</span>
            </div>
            <div class="medicine-detail-row">
                <span class="medicine-detail-label">Weight / Unit</span>
                <span class="medicine-detail-value">{{ $med->weight_grams ? $med->weight_grams.'g' : '—' }}</span>
            </div>
            <div class="medicine-detail-row">
                <span class="medicine-detail-label">Prescription</span>
                <span class="medicine-detail-value">{{ $med->requires_prescription ? 'Required (Rx)' : 'Over the Counter' }}</span>
            </div>
            <div class="medicine-detail-row">
                <span class="medicine-detail-label">In Stock</span>
                <span class="medicine-detail-value">{{ $med->stock_quantity }} units</span>
            </div>
        </div>
        <div class="medicine-card-footer">
            <div>
                <div class="medicine-price">&#8369;{{ number_format($med->selling_price, 2) }}</div>
                <div class="medicine-price-label">per {{ strtolower($med->dosage_form) }}</div>
            </div>
            <a href="{{ route('customer.orders.create') }}?medicine_id={{ $med->id }}" class="btn btn-primary btn-sm">Order</a>
        </div>
    </div>
    @endforeach
</div>
<div style="margin-top:18px;">{{ $medicines->withQueryString()->links() }}</div>
@endif
@endsection

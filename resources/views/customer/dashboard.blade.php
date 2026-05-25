@extends('layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'My Dashboard')
@section('page-subtitle', 'Welcome back, ' . auth()->user()->name)

@section('sidebar-nav')
<div class="nav-section-title">Main</div>
<a href="{{ route('customer.dashboard') }}" class="{{ request()->routeIs('customer.dashboard') ? 'active' : '' }}">Dashboard</a>
<div class="nav-section-title">Shop</div>
<a href="{{ route('customer.catalog') }}" class="{{ request()->routeIs('customer.catalog') ? 'active' : '' }}">Medicine Catalog</a>
<div class="nav-section-title">My Orders</div>
<a href="{{ route('customer.orders.index') }}" class="{{ request()->routeIs('customer.orders*') ? 'active' : '' }}">My Orders</a>
@endsection

@section('content')
<div class="stats-grid">
    <a href="{{ route('customer.orders.index') }}" style="text-decoration:none;">
        <div class="stat-card">
            <div class="stat-value">{{ $totalOrders }}</div>
            <div class="stat-label">Total Orders</div>
        </div>
    </a>
    <a href="{{ route('customer.orders.index') }}?filter=pending" style="text-decoration:none;">
        <div class="stat-card warning">
            <div class="stat-value">{{ $pendingOrders }}</div>
            <div class="stat-label">Pending Orders</div>
        </div>
    </a>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">
    <div class="pharma-card">
        <div class="pharma-card-header">
            <span class="pharma-card-title">Recent Orders</span>
            <a href="{{ route('customer.orders.index') }}" class="btn btn-secondary btn-sm">View All</a>
        </div>
        <div style="padding:0;">
            @if($recentOrders->isEmpty())
                <div class="empty-state">
                    <p>You have not placed any orders yet.</p>
                    <a href="{{ route('customer.catalog') }}" class="btn btn-primary">Browse Medicines</a>
                </div>
            @else
            <table class="pharma-table">
                <thead>
                    <tr><th>Order No.</th><th>Items</th><th>Total</th><th>Status</th></tr>
                </thead>
                <tbody>
                @foreach($recentOrders as $order)
                <tr>
                    <td><strong>{{ $order->order_number }}</strong></td>
                    <td>{{ $order->items->count() }}</td>
                    <td>&#8369;{{ number_format($order->total_amount, 2) }}</td>
                    <td>
                        @php $sc = ['pending'=>'warning','confirmed'=>'info','dispensed'=>'success','cancelled'=>'danger'][$order->status] ?? 'dark' @endphp
                        <span class="badge badge-{{ $sc }}">{{ $order->status }}</span>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </div>

    <div class="pharma-card">
        <div class="pharma-card-header">
            <span class="pharma-card-title">Available Medicines</span>
            <a href="{{ route('customer.catalog') }}" class="btn btn-primary btn-sm">Browse All</a>
        </div>
        <div style="padding:0;">
            <table class="pharma-table">
                <thead>
                    <tr><th>Medicine</th><th>Dosage</th><th>Price</th><th></th></tr>
                </thead>
                <tbody>
                @foreach($featuredMeds as $med)
                <tr>
                    <td>
                        <strong>{{ $med->name }}</strong><br>
                        <small class="text-muted">{{ $med->brand }}</small>
                    </td>
                    <td><small>{{ $med->dosage_strength }}{{ $med->dosage_unit }}</small></td>
                    <td class="text-primary fw-700">&#8369;{{ number_format($med->selling_price, 2) }}</td>
                    <td><a href="{{ route('customer.orders.create') }}?medicine_id={{ $med->id }}" class="btn btn-primary btn-sm">Order</a></td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

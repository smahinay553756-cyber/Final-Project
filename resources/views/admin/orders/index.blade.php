@extends('layouts.app')
@section('title', 'Orders')
@section('page-title', 'Orders')
@section('page-subtitle', 'View all customer orders')

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
<div class="pharma-card">
    <div style="padding:12px 16px;border-bottom:1px solid var(--border);">
        <form method="GET" action="{{ route('admin.orders.index') }}" style="display:flex;gap:8px;">
            <input type="text" name="search" class="form-control" placeholder="Search by order number or customer name..." value="{{ request('search') }}" style="max-width:320px;">
            <button type="submit" class="btn btn-primary btn-sm">Search</button>
            @if(request('search'))
                <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary btn-sm">Clear</a>
            @endif
        </form>
    </div>
    <div style="padding:0;">
        @if($orders->isEmpty())
            <div class="empty-state"><p>No orders have been placed yet.</p></div>
        @else
        <table class="pharma-table">
            <thead>
                <tr>
                    <th>Order No.</th>
                    <th>Customer</th>
                    <th>Items</th>
                    <th>Total</th>
                    <th>Payment</th>
                    <th>Status</th>
                    <th>Handled By</th>
                    <th>Date</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            @foreach($orders as $order)
            <tr>
                <td><strong>{{ $order->order_number }}</strong></td>
                <td>
                    {{ $order->customer_name }}
                    @if($order->is_walkin)<span class="badge badge-info" style="font-size:10px;margin-left:4px;">Walk-in</span>@endif
                </td>
                <td>{{ $order->items->count() }}</td>
                <td><strong>&#8369;{{ number_format($order->total_amount, 2) }}</strong></td>
                <td>
                    <span class="badge badge-{{ $order->payment_status=='paid'?'success':'warning' }}">{{ $order->payment_status }}</span><br>
                    <small class="text-muted">{{ strtoupper($order->payment_method) }}</small>
                </td>
                <td>
                    @php $sc = ['pending'=>'warning','confirmed'=>'info','dispensed'=>'success','cancelled'=>'danger'][$order->status] ?? 'dark' @endphp
                    <span class="badge badge-{{ $sc }}">{{ $order->status }}</span>
                </td>
                <td><small>{{ $order->dispenser?->name ?? '—' }}</small></td>
                <td><small>{{ $order->created_at->format('M d, Y') }}</small></td>
                <td>
                    <div style="display:flex;gap:4px;">
                        <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('admin.orders.receipt', $order) }}" class="btn btn-success btn-sm">Receipt</a>
                    </div>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>
@endsection

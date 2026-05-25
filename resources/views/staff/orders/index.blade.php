@extends('layouts.app')
@section('title', 'Orders')
@section('page-title', 'Orders')
@section('page-subtitle', 'Manage customer orders')

@section('sidebar-nav')
<div class="nav-section-title">Main</div>
<a href="{{ route('staff.dashboard') }}">Dashboard</a>
<div class="nav-section-title">Orders</div>
<a href="{{ route('staff.orders.index') }}" class="active">All Orders</a>
<a href="{{ route('staff.orders.walkin') }}">Walk-in Order</a>
<div class="nav-section-title">Inventory</div>
<a href="{{ route('staff.stock.index') }}">Stock Management</a>
@endsection

@section('content')
<div class="pharma-card">
    <div class="pharma-card-header">
        <span class="pharma-card-title">All Orders</span>
        <a href="{{ route('staff.orders.walkin') }}" class="btn btn-primary btn-sm">+ Walk-in Order</a>
    </div>
    <div style="padding:12px 16px 0;display:flex;gap:8px;border-bottom:1px solid var(--border);">
        <a href="{{ route('staff.orders.index') }}?type=all" style="padding:8px 16px;font-size:13px;font-weight:600;text-decoration:none;border-bottom:2px solid {{ $filter=='all' ? 'var(--green)' : 'transparent' }};color:{{ $filter=='all' ? 'var(--green)' : 'var(--muted)' }};">All</a>
        <a href="{{ route('staff.orders.index') }}?type=online" style="padding:8px 16px;font-size:13px;font-weight:600;text-decoration:none;border-bottom:2px solid {{ $filter=='online' ? 'var(--green)' : 'transparent' }};color:{{ $filter=='online' ? 'var(--green)' : 'var(--muted)' }};">Online</a>
        <a href="{{ route('staff.orders.index') }}?type=walkin" style="padding:8px 16px;font-size:13px;font-weight:600;text-decoration:none;border-bottom:2px solid {{ $filter=='walkin' ? 'var(--green)' : 'transparent' }};color:{{ $filter=='walkin' ? 'var(--green)' : 'var(--muted)' }};">Walk-in</a>
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
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @foreach($orders as $order)
            <tr>
                <td><strong>{{ $order->order_number }}</strong></td>
                <td>
                    {{ $order->customer_name }}
                    @if($order->is_walkin)
                        <span class="badge badge-info" style="font-size:10px;margin-left:4px;">Walk-in</span>
                    @else
                        <span class="badge badge-success" style="font-size:10px;margin-left:4px;">Online</span>
                    @endif
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
                <td><small>{{ $order->created_at->format('M d, Y') }}</small></td>
                <td>
                    <div style="display:flex;gap:4px;flex-wrap:wrap;">
                        <a href="{{ route('staff.orders.show', $order) }}" class="btn btn-info btn-sm">View</a>
                        @if($order->status === 'pending')
                            <form method="POST" action="{{ route('staff.orders.status', [$order, 'confirmed']) }}">
                                @csrf @method('PATCH')
                                <button class="btn btn-success btn-sm">Confirm</button>
                            </form>
                        @endif
                        @if($order->status === 'confirmed')
                            <form method="POST" action="{{ route('staff.orders.status', [$order, 'dispensed']) }}">
                                @csrf @method('PATCH')
                                <button class="btn btn-primary btn-sm">Dispense</button>
                            </form>
                        @endif
                        @if($order->status === 'dispensed')
                            <a href="{{ route('staff.orders.receipt', $order) }}" target="_blank" class="btn btn-success btn-sm">Receipt</a>
                        @endif
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

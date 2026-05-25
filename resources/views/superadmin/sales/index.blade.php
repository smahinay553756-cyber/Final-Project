@extends('layouts.app')
@section('title', 'Sales')
@section('page-title', 'Sales')
@section('page-subtitle', 'All customer orders and transactions')

@section('sidebar-nav')
<div class="nav-section-title">Main</div>
<a href="{{ route('superadmin.dashboard') }}">Dashboard</a>
<div class="nav-section-title">Reports</div>
<a href="{{ route('superadmin.sales.index') }}" class="active">Sales</a>
<div class="nav-section-title">Inventory</div>
<a href="{{ route('superadmin.supplies.index') }}">Supplies Log</a>
@endsection

@section('content')
<div class="pharma-card">
    <div style="padding:0;max-height:600px;overflow-y:auto;">
        @if($orders->isEmpty())
            <div class="empty-state"><p>No orders yet.</p></div>
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
            </tr>
            @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>
@endsection

@extends('layouts.app')
@section('title', 'My Orders')
@section('page-title', 'My Orders')
@section('page-subtitle', 'Track your medicine orders')

@section('sidebar-nav')
<div class="nav-section-title">Main</div>
<a href="{{ route('customer.dashboard') }}">Dashboard</a>
<div class="nav-section-title">Shop</div>
<a href="{{ route('customer.catalog') }}">Medicine Catalog</a>
<div class="nav-section-title">My Orders</div>
<a href="{{ route('customer.orders.index') }}" class="active">My Orders</a>
@endsection

@section('content')
<div class="pharma-card">
    <div style="padding:0;">
        @if($orders->isEmpty())
            <div class="empty-state">
                <p>You have not placed any orders yet.</p>
                <a href="{{ route('customer.catalog') }}" class="btn btn-primary">Browse Medicines</a>
            </div>
        @else
        <table class="pharma-table">
            <thead>
                <tr>
                    <th>Order No.</th>
                    <th>Medicine(s)</th>
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
                    @foreach($order->items as $item)
                        <div>{{ $item->medicine->name }} &times; {{ $item->quantity }}</div>
                    @endforeach
                </td>
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
                    <div style="display:flex;gap:4px;">
                        <a href="{{ route('customer.orders.show', $order) }}" class="btn btn-info btn-sm">View</a>
                        @if($order->payment_status !== 'paid' && $order->status !== 'cancelled')
                        <a href="{{ route('customer.orders.show', $order) }}" class="btn btn-primary btn-sm">Pay</a>
                        @endif
                        @if($order->status === 'dispensed')
                        <a href="{{ route('customer.orders.receipt', $order) }}" target="_blank" class="btn btn-success btn-sm">Receipt</a>
                        @endif
                        @if($order->status === 'pending')
                        <form method="POST" action="{{ route('customer.orders.cancel', $order) }}" onsubmit="return confirm('Cancel this order?')">
                            @csrf @method('PATCH')
                            <button class="btn btn-danger btn-sm">Cancel</button>
                        </form>
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

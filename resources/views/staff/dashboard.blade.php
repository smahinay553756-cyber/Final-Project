@extends('layouts.app')
@section('title', 'Staff Dashboard')
@section('page-title', 'Staff Dashboard')
@section('page-subtitle', 'Order management overview')

@section('sidebar-nav')
<div class="nav-section-title">Main</div>
<a href="{{ route('staff.dashboard') }}" class="{{ request()->routeIs('staff.dashboard') ? 'active' : '' }}">Dashboard</a>
<div class="nav-section-title">Orders</div>
<a href="{{ route('staff.orders.index') }}" class="{{ request()->routeIs('staff.orders*') ? 'active' : '' }}">All Orders</a>
<a href="{{ route('staff.orders.walkin') }}" class="{{ request()->routeIs('staff.orders.walkin') ? 'active' : '' }}">Walk-in Order</a>
<div class="nav-section-title">Inventory</div>
<a href="{{ route('staff.stock.index') }}" class="{{ request()->routeIs('staff.stock*') ? 'active' : '' }}">Stock Management</a>
@endsection

@section('content')
<div class="stats-grid">
    <a href="{{ route('staff.orders.index') }}" style="text-decoration:none;">
        <div class="stat-card" style="border-left:4px solid #2d6a4f;">
            <div class="stat-value">&#8369;{{ number_format($todaySales, 2) }}</div>
            <div class="stat-label">My Sales Today</div>
        </div>
    </a>
    <a href="{{ route('staff.orders.index') }}" style="text-decoration:none;">
        <div class="stat-card info">
            <div class="stat-value">{{ $todayOrders }}</div>
            <div class="stat-label">My Dispensed Today</div>
        </div>
    </a>
    <a href="{{ route('staff.orders.index') }}?filter=pending" style="text-decoration:none;">
        <div class="stat-card warning">
            <div class="stat-value">{{ $pendingOrders }}</div>
            <div class="stat-label">Pending Orders</div>
        </div>
    </a>
    <a href="{{ route('staff.orders.index') }}?filter=confirmed" style="text-decoration:none;">
        <div class="stat-card">
            <div class="stat-value">{{ $confirmedOrders }}</div>
            <div class="stat-label">Confirmed Orders</div>
        </div>
    </a>
</div>

{{-- My Sales Chart --}}
<div class="pharma-card" style="margin-bottom:20px;">
    <div class="pharma-card-header">
        <span class="pharma-card-title">My Sales</span>
        <div style="display:flex;gap:6px;">
            <a href="{{ route('staff.dashboard') }}?chart=day" class="btn btn-sm {{ $filter=='day' ? 'btn-primary' : 'btn-secondary' }}">Day</a>
            <a href="{{ route('staff.dashboard') }}?chart=month" class="btn btn-sm {{ $filter=='month' ? 'btn-primary' : 'btn-secondary' }}">Month</a>
            <a href="{{ route('staff.dashboard') }}?chart=year" class="btn btn-sm {{ $filter=='year' ? 'btn-primary' : 'btn-secondary' }}">Year</a>
        </div>
    </div>
    <div style="padding:16px;">
        <canvas id="salesChart" height="80"></canvas>
    </div>
</div>

<div class="pharma-card">
    <div class="pharma-card-header">
        <span class="pharma-card-title">Recent Orders</span>
        <a href="{{ route('staff.orders.index') }}" class="btn btn-secondary btn-sm">View All</a>
    </div>
    <div style="padding:0;">
        @if($recentOrders->isEmpty())
            <div class="empty-state"><p>No orders yet.</p></div>
        @else
        <table class="pharma-table">
            <thead>
                <tr><th>Order No.</th><th>Customer</th><th>Total</th><th>Payment</th><th>Status</th><th>Date</th><th></th></tr>
            </thead>
            <tbody>
            @foreach($recentOrders as $order)
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
                <td>&#8369;{{ number_format($order->total_amount, 2) }}</td>
                <td><span class="badge badge-{{ $order->payment_status=='paid'?'success':'warning' }}">{{ $order->payment_status }}</span></td>
                <td>
                    @php $sc = ['pending'=>'warning','confirmed'=>'info','dispensed'=>'success','cancelled'=>'danger'][$order->status] ?? 'dark' @endphp
                    <span class="badge badge-{{ $sc }}">{{ $order->status }}</span>
                </td>
                <td><small>{{ $order->created_at->format('M d, Y') }}</small></td>
                <td><a href="{{ route('staff.orders.show', $order) }}" class="btn btn-info btn-sm">View</a></td>
            </tr>
            @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    new Chart(document.getElementById('salesChart').getContext('2d'), {
        type: 'line',
        data: {
            labels: @json($labels),
            datasets: [{
                label: 'My Sales (₱)',
                data: @json($salesData),
                borderColor: '#2d6a4f',
                backgroundColor: 'rgba(45,106,79,0.1)',
                borderWidth: 2,
                pointBackgroundColor: '#2d6a4f',
                pointRadius: 4,
                tension: 0.4,
                fill: true,
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { callback: val => '₱' + val.toLocaleString() }
                }
            }
        }
    });
</script>
@endsection

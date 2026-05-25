@extends('layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'System overview')

@section('sidebar-nav')
<div class="nav-section-title">Main</div>
<a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard</a>
<div class="nav-section-title">Inventory</div>
<a href="{{ route('admin.medicines.index') }}" class="{{ request()->routeIs('admin.medicines*') ? 'active' : '' }}">Medicines</a>
<a href="{{ route('admin.supplies.index') }}" class="{{ request()->routeIs('admin.supplies*') ? 'active' : '' }}">Supplies Log</a>
<div class="nav-section-title">Management</div>
<a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users*') ? 'active' : '' }}">Users</a>
@endsection

@section('content')
<div class="stats-grid">
    <a href="{{ route('admin.medicines.index') }}" style="text-decoration:none;">
        <div class="stat-card">
            <div class="stat-value">{{ $totalMedicines }}</div>
            <div class="stat-label">Total Medicines</div>
        </div>
    </a>
    <a href="{{ route('admin.medicines.index') }}?filter=low_stock" style="text-decoration:none;">
        <div class="stat-card warning">
            <div class="stat-value">{{ $lowStockCount }}</div>
            <div class="stat-label">Low Stock Items</div>
        </div>
    </a>
    <a href="{{ route('admin.medicines.index') }}?filter=expired" style="text-decoration:none;">
        <div class="stat-card danger">
            <div class="stat-value">{{ $expiredCount }}</div>
            <div class="stat-label">Expired Medicines</div>
        </div>
    </a>
    <div class="stat-card" style="border-left:4px solid #2d6a4f;">
        <div class="stat-value">&#8369;{{ number_format($totalSales, 2) }}</div>
        <div class="stat-label">Total Sales</div>
    </div>
    <a href="{{ route('admin.users.index') }}?filter=customer" style="text-decoration:none;">
        <div class="stat-card">
            <div class="stat-value">{{ $totalCustomers }}</div>
            <div class="stat-label">Customers</div>
        </div>
    </a>
    <a href="{{ route('admin.supplies.index') }}" style="text-decoration:none;">
        <div class="stat-card warning">
            <div class="stat-value">{{ $pendingSupplies }}</div>
            <div class="stat-label">Pending Supplies</div>
        </div>
    </a>
    <a href="{{ route('admin.users.index') }}?filter=staff" style="text-decoration:none;">
        <div class="stat-card">
            <div class="stat-value">{{ $totalStaff }}</div>
            <div class="stat-label">Staff</div>
        </div>
    </a>
</div>

{{-- Sales Line Chart --}}
<div class="pharma-card" style="margin-bottom:20px;">
    <div class="pharma-card-header">
        <span class="pharma-card-title">Sales Overview</span>
        <div style="display:flex;gap:6px;">
            <a href="{{ route('admin.dashboard') }}?chart=day" class="btn btn-sm {{ $chartFilter=='day' ? 'btn-primary' : 'btn-secondary' }}">Day</a>
            <a href="{{ route('admin.dashboard') }}?chart=month" class="btn btn-sm {{ $chartFilter=='month' ? 'btn-primary' : 'btn-secondary' }}">Month</a>
            <a href="{{ route('admin.dashboard') }}?chart=year" class="btn btn-sm {{ $chartFilter=='year' ? 'btn-primary' : 'btn-secondary' }}">Year</a>
        </div>
    </div>
    <div style="padding:16px;">
        <canvas id="salesChart" height="80"></canvas>
    </div>
</div>

<div class="pharma-card">
    <div class="pharma-card-header">
        <span class="pharma-card-title">Low Stock Medicines</span>
        <a href="{{ route('admin.medicines.index') }}" class="btn btn-secondary btn-sm">View All</a>
    </div>
    <div style="padding:0;">
        @if($lowStockMeds->isEmpty())
            <div class="empty-state"><p>All stock levels are sufficient.</p></div>
        @else
        <table class="pharma-table">
            <thead>
                <tr><th>Medicine</th><th>Stock</th><th>Reorder At</th><th></th></tr>
            </thead>
            <tbody>
            @foreach($lowStockMeds as $med)
            <tr>
                <td>
                    <strong>{{ $med->name }}</strong><br>
                    <small class="text-muted">{{ $med->dosage_strength }}{{ $med->dosage_unit }}</small>
                </td>
                <td><span class="badge badge-danger">{{ $med->stock_quantity }}</span></td>
                <td>{{ $med->reorder_level }}</td>
                <td><a href="{{ route('admin.medicines.edit', $med) }}" class="btn btn-warning btn-sm">Update</a></td>
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
            labels: @json($chartLabels),
            datasets: [{
                label: 'Sales (₱)',
                data: @json($chartData),
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

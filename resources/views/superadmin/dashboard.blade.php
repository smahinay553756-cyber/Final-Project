@extends('layouts.app')
@section('title', 'Super Admin Dashboard')
@section('page-title', 'Super Admin Dashboard')
@section('page-subtitle', 'Manage account approvals and removals')

@section('sidebar-nav')
<div class="nav-section-title">Main</div>
<a href="{{ route('superadmin.dashboard') }}" class="{{ request()->routeIs('superadmin.dashboard') ? 'active' : '' }}">Dashboard</a>
<div class="nav-section-title">Reports</div>
<a href="{{ route('superadmin.sales.index') }}" class="{{ request()->routeIs('superadmin.sales*') ? 'active' : '' }}">Sales</a>
<div class="nav-section-title">Inventory</div>
<a href="{{ route('superadmin.supplies.index') }}" class="{{ request()->routeIs('superadmin.supplies*') ? 'active' : '' }}">Supplies Log</a>
@endsection

@section('content')

<div class="stats-grid" style="margin-bottom:20px;">
    <div class="stat-card" style="border-left:4px solid #2d6a4f;">
        <div class="stat-value">&#8369;{{ number_format($totalSales, 2) }}</div>
        <div class="stat-label">Total Sales</div>
    </div>
</div>

<div class="pharma-card" style="margin-bottom:20px;">
    <div class="pharma-card-header">
        <span class="pharma-card-title">Sales Overview</span>
        <div style="display:flex;gap:6px;">
            <a href="{{ route('superadmin.dashboard') }}?chart=day" class="btn btn-sm {{ $filter=='day' ? 'btn-primary' : 'btn-secondary' }}">Day</a>
            <a href="{{ route('superadmin.dashboard') }}?chart=month" class="btn btn-sm {{ $filter=='month' ? 'btn-primary' : 'btn-secondary' }}">Month</a>
            <a href="{{ route('superadmin.dashboard') }}?chart=year" class="btn btn-sm {{ $filter=='year' ? 'btn-primary' : 'btn-secondary' }}">Year</a>
        </div>
    </div>
    <div style="padding:16px;">
        <canvas id="salesChart" height="80"></canvas>
    </div>
</div>

@if($pendingUsers->isNotEmpty())
<div class="pharma-card" style="margin-bottom:20px;">
    <div class="pharma-card-header">
        <span class="pharma-card-title">Pending Account Approvals</span>
        <span class="badge badge-warning">{{ $pendingUsers->count() }} pending</span>
    </div>
    <div style="padding:0;">
        <table class="pharma-table">
            <thead>
                <tr><th>Name</th><th>Username</th><th>Email</th><th>Role</th><th>Registered</th><th>Actions</th></tr>
            </thead>
            <tbody>
            @foreach($pendingUsers as $user)
            <tr>
                <td><strong>{{ $user->name }}</strong></td>
                <td>{{ $user->username }}</td>
                <td>{{ $user->email }}</td>
                <td><span class="badge badge-info">{{ ucfirst($user->role) }}</span></td>
                <td><small>{{ $user->created_at->format('M d, Y') }}</small></td>
                <td>
                    <div style="display:flex;gap:4px;">
                        <form method="POST" action="{{ route('superadmin.users.approve', $user) }}">
                            @csrf @method('PATCH')
                            <button class="btn btn-success btn-sm">Approve</button>
                        </form>
                        <form method="POST" action="{{ route('superadmin.users.reject', $user) }}" onsubmit="return confirm('Reject and delete this account?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm">Reject</button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

@if($removalRequests->isNotEmpty())
<div class="pharma-card" style="margin-bottom:20px;">
    <div class="pharma-card-header">
        <span class="pharma-card-title">Pending Removal Requests</span>
        <span class="badge badge-warning">{{ $removalRequests->count() }} pending</span>
    </div>
    <div style="padding:0;">
        <table class="pharma-table">
            <thead>
                <tr><th>User to Remove</th><th>Role</th><th>Requested By</th><th>Reason</th><th>Date</th><th>Actions</th></tr>
            </thead>
            <tbody>
            @foreach($removalRequests as $req)
            <tr>
                <td><strong>{{ $req->targetUser->name }}</strong><br><small class="text-muted">{{ $req->targetUser->email }}</small></td>
                <td><span class="badge badge-info">{{ ucfirst($req->targetUser->role) }}</span></td>
                <td>{{ $req->requester->name }}</td>
                <td><small>{{ $req->reason ?? '—' }}</small></td>
                <td><small>{{ $req->created_at->format('M d, Y') }}</small></td>
                <td>
                    <div style="display:flex;gap:4px;">
                        <form method="POST" action="{{ route('superadmin.removals.approve', $req) }}">
                            @csrf @method('PATCH')
                            <button class="btn btn-success btn-sm">Approve</button>
                        </form>
                        <form method="POST" action="{{ route('superadmin.removals.reject', $req) }}">
                            @csrf @method('PATCH')
                            <button class="btn btn-secondary btn-sm">Reject</button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

<div class="pharma-card">
    <div class="pharma-card-header">
        <span class="pharma-card-title">All Users</span>
    </div>
    <div style="padding:12px 16px;border-bottom:1px solid var(--border);">
        <form method="GET" action="{{ route('superadmin.dashboard') }}" style="display:flex;gap:8px;">
            <input type="text" name="search" class="form-control" placeholder="Search by name, email or username..." value="{{ request('search') }}" style="max-width:300px;">
            <button type="submit" class="btn btn-primary btn-sm">Search</button>
            @if(request('search'))
                <a href="{{ route('superadmin.dashboard') }}" class="btn btn-secondary btn-sm">Clear</a>
            @endif
        </form>
    </div>
    <div style="padding:0;">
        <table class="pharma-table">
            <thead>
                <tr><th>Name</th><th>Username</th><th>Email</th><th>Role</th><th>Status</th><th>Registered</th><th>Actions</th></tr>
            </thead>
            <tbody>
            @foreach($allUsers as $user)
            <tr>
                <td><strong>{{ $user->name }}</strong></td>
                <td>{{ $user->username }}</td>
                <td>{{ $user->email }}</td>
                <td><span class="badge badge-primary">{{ ucfirst($user->role) }}</span></td>
                <td>
                    @if($user->approved)
                        <span class="badge badge-success">Approved</span>
                    @else
                        <span class="badge badge-warning">Pending</span>
                    @endif
                </td>
                <td><small>{{ $user->created_at->format('M d, Y') }}</small></td>
                <td>
                    @if(in_array($user->role, ['admin', 'staff']))
                        <form method="POST" action="{{ route('superadmin.users.remove', $user) }}" onsubmit="return confirm('Remove {{ $user->name }}? This cannot be undone.')">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm">Remove</button>
                        </form>
                    @endif
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
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
                label: 'Sales (₱)',
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

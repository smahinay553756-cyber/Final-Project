@extends('layouts.app')
@section('title', 'Customers')
@section('page-title', 'Customers')
@section('page-subtitle', 'View all registered customers and their orders')

@section('sidebar-nav')
<div class="nav-section-title">Main</div>
<a href="{{ route('admin.dashboard') }}">Dashboard</a>
<div class="nav-section-title">Inventory</div>
<a href="{{ route('admin.medicines.index') }}">Medicines</a>
<a href="{{ route('admin.supplies.index') }}">Supplies Log</a>
<div class="nav-section-title">Sales</div>
<a href="{{ route('admin.orders.index') }}">Orders</a>
<div class="nav-section-title">Management</div>
<a href="{{ route('admin.users.index') }}">Users</a>
<a href="{{ route('admin.customers.index') }}" class="active">Customers</a>
@endsection

@section('content')
<div class="pharma-card">
    <div class="pharma-card-header">
        <span class="pharma-card-title">All Customers</span>
        <span class="badge badge-info">{{ $customers->total() }} total</span>
    </div>
    <div style="padding:12px 16px;border-bottom:1px solid var(--border);">
        <form method="GET" action="{{ route('admin.customers.index') }}" style="display:flex;gap:8px;">
            <input type="text" name="search" class="form-control" placeholder="Search by name, email or username..." value="{{ request('search') }}" style="max-width:320px;">
            <button type="submit" class="btn btn-primary btn-sm">Search</button>
            @if(request('search'))
                <a href="{{ route('admin.customers.index') }}" class="btn btn-secondary btn-sm">Clear</a>
            @endif
        </form>
    </div>
    <div style="padding:0;">
        @if($customers->isEmpty())
            <div class="empty-state"><p>No customers found.</p></div>
        @else
        <table class="pharma-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Total Orders</th>
                    <th>Last Order</th>
                    <th>Joined</th>
                </tr>
            </thead>
            <tbody>
            @foreach($customers as $customer)
            <tr>
                <td>
                    <div style="display:flex;align-items:center;gap:10px;">
                        <div style="width:30px;height:30px;border-radius:50%;background:var(--green);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:12px;flex-shrink:0;">
                            {{ strtoupper(substr($customer->name, 0, 1)) }}
                        </div>
                        <strong>{{ $customer->name }}</strong>
                    </div>
                </td>
                <td>{{ $customer->username }}</td>
                <td>{{ $customer->email }}</td>
                <td>{{ $customer->phone ?? '—' }}</td>
                <td><span class="badge badge-info">{{ $customer->orders->count() }}</span></td>
                <td><small>{{ $customer->orders->sortByDesc('created_at')->first()?->created_at->format('M d, Y') ?? '—' }}</small></td>
                <td><small>{{ $customer->created_at->format('M d, Y') }}</small></td>
            </tr>
            @endforeach
            </tbody>
        </table>
        <div style="padding:14px 16px;">{{ $customers->links() }}</div>
        @endif
    </div>
</div>
@endsection

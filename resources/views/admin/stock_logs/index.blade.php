@extends('layouts.app')
@section('title', 'Supplies Log')
@section('page-title', 'Supplies Log')
@section('page-subtitle', 'Staff stock requests and history')

@section('sidebar-nav')
<div class="nav-section-title">Main</div>
<a href="{{ route('admin.dashboard') }}">Dashboard</a>
<div class="nav-section-title">Inventory</div>
<a href="{{ route('admin.medicines.index') }}">Medicines</a>
<a href="{{ route('admin.supplies.index') }}" class="active">Supplies Log</a>
<div class="nav-section-title">Sales</div>
<a href="{{ route('admin.orders.index') }}">Orders</a>
<div class="nav-section-title">Management</div>
<a href="{{ route('admin.users.index') }}">Users</a>
@endsection

@section('content')

@if($pending->isNotEmpty())
<div class="pharma-card" style="margin-bottom:20px;">
    <div class="pharma-card-header">
        <span class="pharma-card-title">Pending Stock Requests</span>
        <span class="badge badge-warning">{{ $pending->count() }} pending</span>
    </div>
    <div style="padding:0;">
        <table class="pharma-table">
            <thead>
                <tr><th>Submitted</th><th>Staff</th><th>Medicine</th><th>Type</th><th>Qty</th><th>Batch</th><th>Expiry</th><th>Notes</th><th>Actions</th></tr>
            </thead>
            <tbody>
            @foreach($pending as $log)
            <tr>
                <td><small>{{ $log->created_at->format('M d, Y g:i A') }}</small></td>
                <td>{{ $log->staff->name }}</td>
                <td><strong>{{ $log->medicine->name }}</strong><br><small class="text-muted">{{ $log->medicine->dosage_strength }}{{ $log->medicine->dosage_unit }}</small></td>
                <td>
                    @if($log->type === 'in')
                        <span class="badge badge-success">Stock In</span>
                    @else
                        <span class="badge badge-warning">Stock Out</span>
                    @endif
                </td>
                <td><strong>{{ $log->quantity }}</strong></td>
                <td>{{ $log->batch_number ?? '—' }}</td>
                <td>{{ $log->expiry_date?->format('M d, Y') ?? '—' }}</td>
                <td><small>{{ $log->notes ?? '—' }}</small></td>
                <td>
                    <div style="display:flex;gap:4px;">
                        <form method="POST" action="{{ route('admin.supplies.approve', $log) }}">
                            @csrf @method('PATCH')
                            <button class="btn btn-success btn-sm">Approve</button>
                        </form>
                        <form method="POST" action="{{ route('admin.supplies.reject', $log) }}">
                            @csrf @method('PATCH')
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
@else
<div class="pharma-card" style="margin-bottom:20px;">
    <div class="pharma-card-body">
        <div class="empty-state"><p>No pending stock requests.</p></div>
    </div>
</div>
@endif

<div class="pharma-card">
    <div class="pharma-card-header"><span class="pharma-card-title">Stock History</span></div>
    <div style="padding:0;">
        @if($logs->isEmpty())
            <div class="empty-state"><p>No approved or rejected requests yet.</p></div>
        @else
        <table class="pharma-table">
            <thead>
                <tr><th>Date</th><th>Medicine</th><th>Type</th><th>Qty</th><th>Before</th><th>After</th><th>Staff</th><th>Status</th><th>Approved By</th></tr>
            </thead>
            <tbody>
            @foreach($logs as $log)
            <tr>
                <td><small>{{ $log->approved_at?->format('M d, Y g:i A') ?? $log->created_at->format('M d, Y') }}</small></td>
                <td><strong>{{ $log->medicine->name }}</strong></td>
                <td>
                    @if($log->type === 'in')
                        <span class="badge badge-success">Stock In</span>
                    @else
                        <span class="badge badge-warning">Stock Out</span>
                    @endif
                </td>
                <td>{{ $log->type === 'in' ? '+' : '-' }}{{ $log->quantity }}</td>
                <td>{{ $log->stock_before }}</td>
                <td>{{ $log->stock_after }}</td>
                <td>{{ $log->staff->name }}</td>
                <td>
                    @if($log->status === 'approved')
                        <span class="badge badge-success">Approved</span>
                    @else
                        <span class="badge badge-danger">Rejected</span>
                    @endif
                </td>
                <td>{{ $log->approver?->name ?? '—' }}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
        <div style="padding:14px 16px;">{{ $logs->links() }}</div>
        @endif
    </div>
</div>
@endsection

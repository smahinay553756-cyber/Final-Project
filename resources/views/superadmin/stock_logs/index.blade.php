@extends('layouts.app')
@section('title', 'Supplies Log')
@section('page-title', 'Supplies Log')
@section('page-subtitle', 'Staff stock in/out requests and admin approval history')

@section('sidebar-nav')
<div class="nav-section-title">Main</div>
<a href="{{ route('superadmin.dashboard') }}">Dashboard</a>
<div class="nav-section-title">Reports</div>
<a href="{{ route('superadmin.sales.index') }}">Sales</a>
<a href="{{ route('superadmin.customers.index') }}">Customers</a>
<div class="nav-section-title">Inventory</div>
<a href="{{ route('superadmin.supplies.index') }}" class="active">Supplies Log</a>
@endsection

@section('content')

@if($pending->isNotEmpty())
<div class="pharma-card" style="margin-bottom:20px;">
    <div class="pharma-card-header">
        <span class="pharma-card-title">Pending Requests</span>
        <span class="badge badge-warning">{{ $pending->count() }} pending</span>
    </div>
    <div style="padding:0;">
        <table class="pharma-table">
            <thead>
                <tr><th>Date</th><th>Medicine</th><th>Type</th><th>Qty</th><th>Staff</th><th>Notes</th></tr>
            </thead>
            <tbody>
            @foreach($pending as $log)
            <tr>
                <td><small>{{ $log->created_at->format('M d, Y g:i A') }}</small></td>
                <td><strong>{{ $log->medicine->name }}</strong></td>
                <td>
                    @if($log->type === 'in')
                        <span class="badge badge-success">Stock In</span>
                    @else
                        <span class="badge badge-warning">Stock Out</span>
                    @endif
                </td>
                <td>{{ $log->type === 'in' ? '+' : '-' }}{{ $log->quantity }}</td>
                <td>{{ $log->staff->name }}</td>
                <td><small>{{ $log->notes ?? '—' }}</small></td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

<div class="pharma-card">
    <div class="pharma-card-header">
        <span class="pharma-card-title">Admin Approval History</span>
    </div>
    <div style="padding:0;">
        @if($logs->isEmpty())
            <div class="empty-state"><p>No approval history yet.</p></div>
        @else
        <table class="pharma-table">
            <thead>
                <tr><th>Date</th><th>Medicine</th><th>Type</th><th>Qty</th><th>Before</th><th>After</th><th>Staff</th><th>Status</th><th>Approved By</th><th>Notes</th></tr>
            </thead>
            <tbody>
            @foreach($logs as $log)
            <tr>
                <td><small>{{ $log->created_at->format('M d, Y g:i A') }}</small></td>
                <td><strong>{{ $log->medicine->name }}</strong><br><small class="text-muted">{{ $log->medicine->dosage_strength }}{{ $log->medicine->dosage_unit }}</small></td>
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
                <td><small>{{ $log->notes ?? '—' }}</small></td>
            </tr>
            @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>
@endsection

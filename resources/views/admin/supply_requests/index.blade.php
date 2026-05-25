@extends('layouts.app')
@section('title', 'Supplies Log')
@section('page-title', 'Supplies Log')
@section('page-subtitle', 'Review and approve supplier stock submissions')

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
<div class="pharma-card">
    <div style="padding:0;">
        @if($requests->isEmpty())
            <div class="empty-state"><p>No Supplies Log have been submitted.</p></div>
        @else
        <table class="pharma-table">
            <thead>
                <tr>
                    <th>Supplier</th>
                    <th>Medicine</th>
                    <th>Qty</th>
                    <th>Unit Cost</th>
                    <th>Batch No.</th>
                    <th>Expiry Date</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @foreach($requests as $req)
            <tr>
                <td>{{ $req->supplier->name }}</td>
                <td>
                    <strong>{{ $req->medicine->name }}</strong><br>
                    <small class="text-muted">{{ $req->medicine->dosage_strength }}{{ $req->medicine->dosage_unit }}</small>
                </td>
                <td><strong>{{ $req->quantity_supplied }}</strong></td>
                <td>&#8369;{{ number_format($req->unit_cost, 2) }}</td>
                <td>{{ $req->batch_number ?? '—' }}</td>
                <td>{{ $req->expiry_date?->format('M d, Y') ?? '—' }}</td>
                <td>
                    @php $sc = ['pending'=>'warning','approved'=>'success','rejected'=>'danger'][$req->status] ?? 'dark' @endphp
                    <span class="badge badge-{{ $sc }}">{{ $req->status }}</span>
                </td>
                <td><small>{{ $req->created_at->format('M d, Y') }}</small></td>
                <td>
                    @if($req->status === 'pending')
                    <div style="display:flex;gap:4px;">
                        <form method="POST" action="{{ route('admin.supply_requests.approve', $req) }}">
                            @csrf @method('PATCH')
                            <button class="btn btn-success btn-sm">Approve</button>
                        </form>
                        <form method="POST" action="{{ route('admin.supply_requests.reject', $req) }}">
                            @csrf @method('PATCH')
                            <button class="btn btn-danger btn-sm">Reject</button>
                        </form>
                    </div>
                    @else
                        <span class="text-muted" style="font-size:12px;">Processed</span>
                    @endif
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
        <div style="padding:14px 16px;">{{ $requests->links() }}</div>
        @endif
    </div>
</div>
@endsection

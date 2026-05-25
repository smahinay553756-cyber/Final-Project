@extends('layouts.app')
@section('title', 'Medicines')
@section('page-title', 'Medicine Inventory')
@section('page-subtitle', 'Manage all medicines in stock')
@section('topbar-actions')
    <a href="{{ route('admin.medicines.create') }}" class="btn btn-primary">Add Medicine</a>
@endsection

@section('sidebar-nav')
<div class="nav-section-title">Main</div>
<a href="{{ route('admin.dashboard') }}">Dashboard</a>
<div class="nav-section-title">Inventory</div>
<a href="{{ route('admin.medicines.index') }}" class="active">Medicines</a>
<a href="{{ route('admin.supplies.index') }}">Supplies Log</a>
<div class="nav-section-title">Sales</div>
<a href="{{ route('admin.orders.index') }}">Orders</a>
<div class="nav-section-title">Management</div>
<a href="{{ route('admin.users.index') }}">Users</a>
@endsection

@section('content')
<div class="pharma-card">
    <div class="pharma-card-header">
        <form method="GET" style="display:flex;gap:10px;flex-wrap:wrap;flex:1;">
            <input type="text" name="search" class="form-control" placeholder="Search by name, generic name, or brand..." value="{{ request('search') }}" style="max-width:300px;">
            <select name="category" class="form-control" style="max-width:180px;">
                <option value="">All Categories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                @endforeach
            </select>
            <select name="status" class="form-control" style="max-width:140px;">
                <option value="">All Status</option>
                <option value="active" {{ request('status')=='active'?'selected':'' }}>Active</option>
                <option value="inactive" {{ request('status')=='inactive'?'selected':'' }}>Inactive</option>
                <option value="discontinued" {{ request('status')=='discontinued'?'selected':'' }}>Discontinued</option>
            </select>
            <button type="submit" class="btn btn-primary">Search</button>
            <a href="{{ route('admin.medicines.index') }}" class="btn btn-secondary">Reset</a>
        </form>
    </div>
    <div style="padding:0;overflow-x:auto;">
        @if($medicines->isEmpty())
            <div class="empty-state"><p>No medicines found.</p></div>
        @else
        <table class="pharma-table" style="min-width:900px;">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Medicine</th>
                    <th>Category</th>
                    <th>Form / Dosage</th>
                    <th>Weight (g)</th>
                    <th>Stock</th>
                    <th>Selling Price</th>
                    <th>Expiry Date</th>
                    <th>Rx</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @foreach($medicines as $med)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                    <strong>{{ $med->name }}</strong><br>
                    <small class="text-muted">{{ $med->generic_name }}</small><br>
                    <small class="text-muted">{{ $med->brand }}</small>
                </td>
                <td><span class="badge badge-primary">{{ $med->category }}</span></td>
                <td>
                    {{ $med->dosage_form }}<br>
                    <small class="text-muted">{{ $med->dosage_strength }}{{ $med->dosage_unit }}</small>
                </td>
                <td>{{ $med->weight_grams ? $med->weight_grams.'g' : '—' }}</td>
                <td>
                    @if($med->isLowStock())
                        <span class="badge badge-danger">{{ $med->stock_quantity }} — Low</span>
                    @else
                        <span class="badge badge-success">{{ $med->stock_quantity }}</span>
                    @endif
                </td>
                <td>&#8369;{{ number_format($med->selling_price, 2) }}</td>
                <td>
                    @if($med->expiry_date)
                        @if($med->isExpired())
                            <span class="badge badge-danger">{{ $med->expiry_date->format('M d, Y') }}</span>
                        @else
                            {{ $med->expiry_date->format('M d, Y') }}
                        @endif
                    @else
                        —
                    @endif
                </td>
                <td>{{ $med->requires_prescription ? 'Yes' : 'No' }}</td>
                <td>
                    @php $sc = ['active'=>'success','inactive'=>'warning','discontinued'=>'danger'][$med->status] ?? 'dark' @endphp
                    <span class="badge badge-{{ $sc }}">{{ $med->status }}</span>
                </td>
                <td>
                    <div style="display:flex;gap:4px;">
                        <a href="{{ route('admin.medicines.show', $med) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('admin.medicines.edit', $med) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form method="POST" action="{{ route('admin.medicines.destroy', $med) }}" onsubmit="return confirm('Delete this medicine?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm">Delete</button>
                        </form>
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

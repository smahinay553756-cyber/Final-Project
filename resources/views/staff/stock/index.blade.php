@extends('layouts.app')
@section('title', 'Stock Management')
@section('page-title', 'Stock Management')
@section('page-subtitle', 'Submit stock requests for admin approval')

@section('sidebar-nav')
<div class="nav-section-title">Main</div>
<a href="{{ route('staff.dashboard') }}">Dashboard</a>
<div class="nav-section-title">Orders</div>
<a href="{{ route('staff.orders.index') }}">All Orders</a>
<a href="{{ route('staff.orders.walkin') }}">Walk-in Order</a>
<div class="nav-section-title">Inventory</div>
<a href="{{ route('staff.stock.index') }}" class="active">Stock Management</a>
@endsection

@section('content')
@if($pendingCount > 0)
<div class="alert alert-warning">You have {{ $pendingCount }} pending stock request(s) awaiting admin approval.</div>
@endif
<div class="pharma-card">
    <div style="padding:0;max-height:600px;overflow-y:auto;">
        @if($medicines->isEmpty())
            <div class="empty-state"><p>No medicines found.</p></div>
        @else
        <table class="pharma-table">
            <thead>
                <tr>
                    <th>Medicine</th>
                    <th>Category</th>
                    <th>Dosage</th>
                    <th>Stock</th>
                    <th>Reorder At</th>
                    <th>Expiry</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @foreach($medicines as $med)
            <tr>
                <td>
                    <strong>{{ $med->name }}</strong><br>
                    <small class="text-muted">{{ $med->brand }}</small>
                </td>
                <td><span class="badge badge-primary">{{ $med->category }}</span></td>
                <td><small>{{ $med->dosage_strength }}{{ $med->dosage_unit }} {{ $med->dosage_form }}</small></td>
                <td>
                    @if($med->isLowStock())
                        <span class="badge badge-danger">{{ $med->stock_quantity }} — Low</span>
                    @else
                        <span class="badge badge-success">{{ $med->stock_quantity }}</span>
                    @endif
                </td>
                <td>{{ $med->reorder_level }}</td>
                <td><small>{{ $med->expiry_date?->format('M d, Y') ?? '—' }}</small></td>
                <td>
                    <div style="display:flex;gap:4px;">
                        <button type="button" class="btn btn-success btn-sm" onclick="openModal('in', {{ $med->id }}, '{{ $med->name }}', {{ $med->stock_quantity }})">Stock In</button>
                        <button type="button" class="btn btn-warning btn-sm" onclick="openModal('out', {{ $med->id }}, '{{ $med->name }}', {{ $med->stock_quantity }})">Stock Out</button>
                    </div>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>

{{-- Stock Modal --}}
<div id="stock-modal" style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.5);z-index:9999;align-items:center;justify-content:center;">
    <div style="background:#fff;border-radius:var(--radius);max-width:420px;width:90%;padding:24px;box-shadow:0 10px 40px rgba(0,0,0,0.2);">
        <div style="font-size:18px;font-weight:700;color:var(--navy);margin-bottom:4px;" id="modal-title"></div>
        <div style="font-size:13px;color:var(--muted);margin-bottom:20px;" id="modal-subtitle"></div>

        <form method="POST" id="stock-form">
            @csrf
            <div class="form-group">
                <label class="form-label">Quantity <span style="color:var(--red)">*</span></label>
                <input type="number" name="quantity" class="form-control" min="1" required>
            </div>
            <div id="stock-in-fields">
                <div class="form-group">
                    <label class="form-label">Batch Number</label>
                    <input type="text" name="batch_number" class="form-control" placeholder="Optional">
                </div>
                <div class="form-group">
                    <label class="form-label">Expiry Date</label>
                    <input type="date" name="expiry_date" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Notes</label>
                <input type="text" name="notes" class="form-control" placeholder="Optional">
            </div>
            <div style="display:flex;gap:10px;margin-top:6px;">
                <button type="button" class="btn btn-secondary" style="flex:1;justify-content:center;" onclick="closeModal()">Cancel</button>
                <button type="submit" class="btn btn-primary" style="flex:1;justify-content:center;" id="modal-submit-btn">Confirm</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function openModal(type, id, name, stock) {
        const isIn = type === 'in';
        document.getElementById('modal-title').textContent = isIn ? 'Stock In — ' + name : 'Stock Out — ' + name;
        document.getElementById('modal-subtitle').textContent = isIn ? 'Add stock to inventory.' : 'Current stock: ' + stock + ' units.';
        document.getElementById('stock-in-fields').style.display = isIn ? 'block' : 'none';
        document.getElementById('modal-submit-btn').textContent = isIn ? 'Submit Request' : 'Submit Request';
        document.getElementById('modal-submit-btn').className = isIn ? 'btn btn-success' : 'btn btn-warning';
        document.getElementById('stock-form').action = '/staff/stock/' + id + '/' + type;
        document.querySelector('#stock-form input[name=quantity]').value = '';
        document.getElementById('stock-modal').style.display = 'flex';
    }

    function closeModal() {
        document.getElementById('stock-modal').style.display = 'none';
    }
</script>
@endsection

@extends('layouts.app')
@section('title', 'Edit Medicine')
@section('page-title', 'Edit Medicine')
@section('page-subtitle', 'Update medicine information')

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
        <span class="pharma-card-title">{{ $medicine->name }}</span>
        <a href="{{ route('admin.medicines.index') }}" class="btn btn-secondary btn-sm">Back</a>
    </div>
    <div class="pharma-card-body">
        <form method="POST" action="{{ route('admin.medicines.update', $medicine) }}">
            @csrf @method('PUT')

            <div class="section-divider">Basic Information</div>
            <div class="form-grid-3">
                <div class="form-group">
                    <label class="form-label">Medicine Name <span style="color:var(--red)">*</span></label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $medicine->name) }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Generic Name</label>
                    <input type="text" name="generic_name" class="form-control" value="{{ old('generic_name', $medicine->generic_name) }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Brand Name</label>
                    <input type="text" name="brand" class="form-control" value="{{ old('brand', $medicine->brand) }}">
                </div>
            </div>
            <div class="form-grid-3">
                <div class="form-group">
                    <label class="form-label">Category <span style="color:var(--red)">*</span></label>
                    <input type="text" name="category" class="form-control" list="categories-list" value="{{ old('category', $medicine->category) }}" required>
                    <datalist id="categories-list">
                        <option value="Antibiotic"><option value="Analgesic/Antipyretic">
                        <option value="Antihypertensive"><option value="Antidiabetic">
                        <option value="Bronchodilator"><option value="Vitamin/Supplement">
                        <option value="Antacid"><option value="Antihistamine">
                    </datalist>
                </div>
                <div class="form-group">
                    <label class="form-label">Dosage Form <span style="color:var(--red)">*</span></label>
                    <select name="dosage_form" class="form-control" required>
                        @foreach(['Tablet','Capsule','Syrup','Suspension','Injection','Inhaler','Cream','Ointment','Drops','Patch','Suppository','Powder'] as $form)
                            <option value="{{ $form }}" {{ old('dosage_form',$medicine->dosage_form)==$form?'selected':'' }}>{{ $form }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Manufacturer</label>
                    <input type="text" name="manufacturer" class="form-control" value="{{ old('manufacturer', $medicine->manufacturer) }}">
                </div>
            </div>

            <div class="section-divider">Dosage &amp; Weight</div>
            <div class="form-grid-3">
                <div class="form-group">
                    <label class="form-label">Dosage Strength</label>
                    <input type="number" step="0.01" name="dosage_strength" class="form-control" value="{{ old('dosage_strength', $medicine->dosage_strength) }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Dosage Unit</label>
                    <select name="dosage_unit" class="form-control">
                        @foreach(['mg','g','ml','mcg','IU','%'] as $unit)
                            <option value="{{ $unit }}" {{ old('dosage_unit',$medicine->dosage_unit)==$unit?'selected':'' }}>{{ $unit }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Weight per Unit (grams)</label>
                    <input type="number" step="0.0001" name="weight_grams" class="form-control" value="{{ old('weight_grams', $medicine->weight_grams) }}">
                </div>
            </div>

            <div class="section-divider">Batch &amp; Dates</div>
            <div class="form-grid-3">
                <div class="form-group">
                    <label class="form-label">Batch Number</label>
                    <input type="text" name="batch_number" class="form-control" value="{{ old('batch_number', $medicine->batch_number) }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Manufacture Date</label>
                    <input type="date" name="manufacture_date" class="form-control" value="{{ old('manufacture_date', $medicine->manufacture_date?->format('Y-m-d')) }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Expiry Date</label>
                    <input type="date" name="expiry_date" class="form-control" value="{{ old('expiry_date', $medicine->expiry_date?->format('Y-m-d')) }}">
                </div>
            </div>

            <div class="section-divider">Stock &amp; Pricing</div>
            <div class="form-grid-3">
                <div class="form-group">
                    <label class="form-label">Stock Quantity <span style="color:var(--red)">*</span></label>
                    <input type="number" name="stock_quantity" class="form-control" value="{{ old('stock_quantity', $medicine->stock_quantity) }}" min="0" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Reorder Level <span style="color:var(--red)">*</span></label>
                    <input type="number" name="reorder_level" class="form-control" value="{{ old('reorder_level', $medicine->reorder_level) }}" min="0" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Storage Condition</label>
                    <input type="text" name="storage_condition" class="form-control" value="{{ old('storage_condition', $medicine->storage_condition) }}">
                </div>
            </div>
            <div class="form-grid-3">
                <div class="form-group">
                    <label class="form-label">Unit Cost (&#8369;) <span style="color:var(--red)">*</span></label>
                    <input type="number" step="0.01" name="unit_price" class="form-control" value="{{ old('unit_price', $medicine->unit_price) }}" min="0" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Selling Price (&#8369;) <span style="color:var(--red)">*</span></label>
                    <input type="number" step="0.01" name="selling_price" class="form-control" value="{{ old('selling_price', $medicine->selling_price) }}" min="0" required>
                </div>
            </div>

            <div class="section-divider">Additional Details</div>
            <div class="form-grid-2">
                <div class="form-group">
                    <label class="form-label">Status <span style="color:var(--red)">*</span></label>
                    <select name="status" class="form-control" required>
                        @foreach(['active','inactive','discontinued'] as $st)
                            <option value="{{ $st }}" {{ old('status',$medicine->status)==$st?'selected':'' }}>{{ ucfirst($st) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group" style="display:flex;align-items:center;gap:10px;padding-top:22px;">
                    <input type="checkbox" name="requires_prescription" id="rx" value="1" {{ old('requires_prescription',$medicine->requires_prescription) ? 'checked' : '' }} style="width:auto;accent-color:var(--green);">
                    <label for="rx" class="form-label" style="margin:0;cursor:pointer;">Requires Prescription (Rx)</label>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="3">{{ old('description', $medicine->description) }}</textarea>
            </div>
            <div class="form-grid-2">
                <div class="form-group">
                    <label class="form-label">Side Effects</label>
                    <textarea name="side_effects" class="form-control" rows="3">{{ old('side_effects', $medicine->side_effects) }}</textarea>
                </div>
                <div class="form-group">
                    <label class="form-label">Contraindications</label>
                    <textarea name="contraindications" class="form-control" rows="3">{{ old('contraindications', $medicine->contraindications) }}</textarea>
                </div>
            </div>

            <div style="display:flex;gap:10px;margin-top:6px;">
                <button type="submit" class="btn btn-primary">Update Medicine</button>
                <a href="{{ route('admin.medicines.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection

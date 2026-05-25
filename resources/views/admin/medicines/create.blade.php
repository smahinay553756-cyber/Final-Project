@extends('layouts.app')
@section('title', 'Add Medicine')
@section('page-title', 'Add New Medicine')
@section('page-subtitle', 'Add a new medicine to inventory')

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
        <span class="pharma-card-title">Medicine Information</span>
        <a href="{{ route('admin.medicines.index') }}" class="btn btn-secondary btn-sm">Back</a>
    </div>
    <div class="pharma-card-body">
        <form method="POST" action="{{ route('admin.medicines.store') }}">
            @csrf

            <div class="section-divider">Basic Information</div>
            <div class="form-grid-3">
                <div class="form-group">
                    <label class="form-label">Medicine Name <span style="color:var(--red)">*</span></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Generic Name</label>
                    <input type="text" name="generic_name" class="form-control" value="{{ old('generic_name') }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Brand Name</label>
                    <input type="text" name="brand" class="form-control" value="{{ old('brand') }}">
                </div>
            </div>

            <div class="form-grid-3">
                <div class="form-group">
                    <label class="form-label">Category <span style="color:var(--red)">*</span></label>
                    <input type="text" name="category" class="form-control @error('category') is-invalid @enderror"
                           list="categories-list" value="{{ old('category') }}" required placeholder="e.g. Antibiotic">
                    <datalist id="categories-list">
                        <option value="Antibiotic">
                        <option value="Analgesic/Antipyretic">
                        <option value="Antihypertensive">
                        <option value="Antidiabetic">
                        <option value="Bronchodilator">
                        <option value="Vitamin/Supplement">
                        <option value="Antacid">
                        <option value="Antihistamine">
                        <option value="Antifungal">
                        <option value="Antiviral">
                        <option value="Cardiovascular">
                        <option value="Dermatological">
                    </datalist>
                    @error('category')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Dosage Form <span style="color:var(--red)">*</span></label>
                    <select name="dosage_form" class="form-control @error('dosage_form') is-invalid @enderror" required>
                        <option value="">Select form</option>
                        @foreach(['Tablet','Capsule','Syrup','Suspension','Injection','Inhaler','Cream','Ointment','Drops','Patch','Suppository','Powder'] as $form)
                            <option value="{{ $form }}" {{ old('dosage_form')==$form?'selected':'' }}>{{ $form }}</option>
                        @endforeach
                    </select>
                    @error('dosage_form')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Manufacturer</label>
                    <input type="text" name="manufacturer" class="form-control" value="{{ old('manufacturer') }}">
                </div>
            </div>

            <div class="section-divider">Dosage &amp; Weight</div>
            <div class="form-grid-3">
                <div class="form-group">
                    <label class="form-label">Dosage Strength</label>
                    <input type="number" step="0.01" name="dosage_strength" class="form-control" value="{{ old('dosage_strength') }}" placeholder="e.g. 500">
                </div>
                <div class="form-group">
                    <label class="form-label">Dosage Unit</label>
                    <select name="dosage_unit" class="form-control">
                        <option value="">Select unit</option>
                        @foreach(['mg','g','ml','mcg','IU','%'] as $unit)
                            <option value="{{ $unit }}" {{ old('dosage_unit')==$unit?'selected':'' }}>{{ $unit }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Weight per Unit (grams)</label>
                    <input type="number" step="0.0001" name="weight_grams" class="form-control" value="{{ old('weight_grams') }}" placeholder="e.g. 0.5">
                </div>
            </div>

            <div class="section-divider">Batch &amp; Dates</div>
            <div class="form-grid-3">
                <div class="form-group">
                    <label class="form-label">Batch Number</label>
                    <input type="text" name="batch_number" class="form-control" value="{{ old('batch_number') }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Manufacture Date</label>
                    <input type="date" name="manufacture_date" class="form-control" value="{{ old('manufacture_date') }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Expiry Date</label>
                    <input type="date" name="expiry_date" class="form-control" value="{{ old('expiry_date') }}">
                </div>
            </div>

            <div class="section-divider">Stock &amp; Pricing</div>
            <div class="form-grid-3">
                <div class="form-group">
                    <label class="form-label">Stock Quantity <span style="color:var(--red)">*</span></label>
                    <input type="number" name="stock_quantity" class="form-control @error('stock_quantity') is-invalid @enderror" value="{{ old('stock_quantity', 0) }}" min="0" required>
                    @error('stock_quantity')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Reorder Level <span style="color:var(--red)">*</span></label>
                    <input type="number" name="reorder_level" class="form-control" value="{{ old('reorder_level', 10) }}" min="0" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Storage Condition</label>
                    <input type="text" name="storage_condition" class="form-control" value="{{ old('storage_condition') }}" placeholder="e.g. Room Temperature">
                </div>
            </div>
            <div class="form-grid-3">
                <div class="form-group">
                    <label class="form-label">Unit Cost (&#8369;) <span style="color:var(--red)">*</span></label>
                    <input type="number" step="0.01" name="unit_price" class="form-control @error('unit_price') is-invalid @enderror" value="{{ old('unit_price') }}" min="0" required>
                    @error('unit_price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Selling Price (&#8369;) <span style="color:var(--red)">*</span></label>
                    <input type="number" step="0.01" name="selling_price" class="form-control @error('selling_price') is-invalid @enderror" value="{{ old('selling_price') }}" min="0" required>
                    @error('selling_price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Supplier</label>
                    <select name="supplied_by" class="form-control">
                        <option value="">None</option>
                        @foreach($suppliers as $s)
                            <option value="{{ $s->id }}" {{ old('supplied_by')==$s->id?'selected':'' }}>{{ $s->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="section-divider">Additional Details</div>
            <div class="form-grid-2">
                <div class="form-group">
                    <label class="form-label">Status <span style="color:var(--red)">*</span></label>
                    <select name="status" class="form-control" required>
                        <option value="active" {{ old('status','active')=='active'?'selected':'' }}>Active</option>
                        <option value="inactive" {{ old('status')=='inactive'?'selected':'' }}>Inactive</option>
                        <option value="discontinued" {{ old('status')=='discontinued'?'selected':'' }}>Discontinued</option>
                    </select>
                </div>
                <div class="form-group" style="display:flex;align-items:center;gap:10px;padding-top:22px;">
                    <input type="checkbox" name="requires_prescription" id="rx" value="1" {{ old('requires_prescription') ? 'checked' : '' }} style="width:auto;accent-color:var(--green);">
                    <label for="rx" class="form-label" style="margin:0;cursor:pointer;">Requires Prescription (Rx)</label>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
            </div>
            <div class="form-grid-2">
                <div class="form-group">
                    <label class="form-label">Side Effects</label>
                    <textarea name="side_effects" class="form-control" rows="3">{{ old('side_effects') }}</textarea>
                </div>
                <div class="form-group">
                    <label class="form-label">Contraindications</label>
                    <textarea name="contraindications" class="form-control" rows="3">{{ old('contraindications') }}</textarea>
                </div>
            </div>

            <div style="display:flex;gap:10px;margin-top:6px;">
                <button type="submit" class="btn btn-primary">Save Medicine</button>
                <a href="{{ route('admin.medicines.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection

@extends('layouts.app')
@section('title', 'Place Order')
@section('page-title', 'Place Order')
@section('page-subtitle', $medicine->name)

@section('sidebar-nav')
<div class="nav-section-title">Main</div>
<a href="{{ route('customer.dashboard') }}">Dashboard</a>
<div class="nav-section-title">Shop</div>
<a href="{{ route('customer.catalog') }}" class="active">Medicine Catalog</a>
<div class="nav-section-title">My Orders</div>
<a href="{{ route('customer.orders.index') }}">My Orders</a>
@endsection

@section('content')
<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;max-width:900px;">
    <div class="pharma-card">
        <div class="pharma-card-header" style="background:var(--green);border:none;">
            <div>
                <div style="font-size:16px;font-weight:700;color:#fff;">{{ $medicine->name }}</div>
                <div style="font-size:12px;color:rgba(255,255,255,0.75);margin-top:2px;">{{ $medicine->generic_name }}</div>
            </div>
            <span class="badge" style="background:rgba(255,255,255,0.2);color:#fff;">{{ $medicine->category }}</span>
        </div>
        <div class="pharma-card-body">
            <div class="medicine-detail-row"><span class="medicine-detail-label">Brand</span><span class="medicine-detail-value">{{ $medicine->brand ?? '—' }}</span></div>
            <div class="medicine-detail-row"><span class="medicine-detail-label">Dosage Form</span><span class="medicine-detail-value">{{ $medicine->dosage_form }}</span></div>
            <div class="medicine-detail-row"><span class="medicine-detail-label">Strength</span><span class="medicine-detail-value">{{ $medicine->dosage_strength }}{{ $medicine->dosage_unit }}</span></div>
            <div class="medicine-detail-row"><span class="medicine-detail-label">Weight / Unit</span><span class="medicine-detail-value">{{ $medicine->weight_grams ? $medicine->weight_grams.'g' : '—' }}</span></div>
            <div class="medicine-detail-row"><span class="medicine-detail-label">Manufacturer</span><span class="medicine-detail-value">{{ $medicine->manufacturer ?? '—' }}</span></div>
            <div class="medicine-detail-row"><span class="medicine-detail-label">Expiry Date</span><span class="medicine-detail-value">{{ $medicine->expiry_date?->format('M d, Y') ?? '—' }}</span></div>
            <div class="medicine-detail-row"><span class="medicine-detail-label">Storage</span><span class="medicine-detail-value">{{ $medicine->storage_condition ?? '—' }}</span></div>
            <div class="medicine-detail-row"><span class="medicine-detail-label">In Stock</span><span class="medicine-detail-value text-success fw-700">{{ $medicine->stock_quantity }} units</span></div>
            <div class="medicine-detail-row"><span class="medicine-detail-label">Prescription</span><span class="medicine-detail-value">{{ $medicine->requires_prescription ? 'Required (Rx)' : 'Over the Counter' }}</span></div>
            <div style="border-top:1px solid var(--border);margin-top:12px;padding-top:12px;text-align:center;">
                <div style="font-size:26px;font-weight:700;color:var(--green);letter-spacing:-0.5px;">&#8369;{{ number_format($medicine->selling_price, 2) }}</div>
                <div class="text-muted" style="font-size:12px;">per {{ strtolower($medicine->dosage_form) }}</div>
            </div>
        </div>
    </div>

    <div class="pharma-card">
        <div class="pharma-card-header">
            <span class="pharma-card-title">Order Details</span>
            <a href="{{ route('customer.catalog') }}" class="btn btn-secondary btn-sm">Back</a>
        </div>
        <div class="pharma-card-body">
            @if($medicine->requires_prescription)
                <div class="alert alert-warning">This medicine requires a valid prescription. Please bring it when picking up your order.</div>
            @endif

            <form method="POST" action="{{ route('customer.orders.store') }}" id="order-form">
                @csrf
                <input type="hidden" name="medicine_id" value="{{ $medicine->id }}">
                <input type="hidden" name="pay_later" id="pay-later-input" value="0">

                <div class="form-group">
                    <label class="form-label">Quantity <span style="color:var(--red)">*</span></label>
                    <input type="number" name="quantity" id="qty-input"
                           class="form-control @error('quantity') is-invalid @enderror"
                           value="{{ old('quantity', 1) }}" min="1" max="{{ $medicine->stock_quantity }}" required>
                    <small class="text-muted">Maximum available: {{ $medicine->stock_quantity }}</small>
                    @error('quantity')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Payment Method <span style="color:var(--red)">*</span></label>
                    <select name="payment_method" class="form-control" required>
                        <option value="cash"  {{ old('payment_method')=='cash'  ?'selected':'' }}>Cash</option>
                        <option value="card"  {{ old('payment_method')=='card'  ?'selected':'' }}>Card</option>
                        <option value="gcash" {{ old('payment_method')=='gcash' ?'selected':'' }}>GCash</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Notes</label>
                    <textarea name="notes" class="form-control" rows="2" placeholder="Special instructions...">{{ old('notes') }}</textarea>
                </div>

                <div style="background:#f4f6f9;border:1px solid var(--border);border-radius:var(--radius);padding:12px;margin-bottom:14px;">
                    <div style="display:flex;justify-content:space-between;margin-bottom:5px;font-size:13px;">
                        <span class="text-muted">Unit Price</span>
                        <span>&#8369;{{ number_format($medicine->selling_price, 2) }}</span>
                    </div>
                    <div style="display:flex;justify-content:space-between;margin-bottom:5px;font-size:13px;">
                        <span class="text-muted">Quantity</span>
                        <span id="summary-qty">1</span>
                    </div>
                    <div style="border-top:1px solid var(--border);margin:8px 0;"></div>
                    <div style="display:flex;justify-content:space-between;font-size:16px;font-weight:700;">
                        <span>Total</span>
                        <span class="text-primary" id="summary-total">&#8369;{{ number_format($medicine->selling_price, 2) }}</span>
                    </div>
                </div>

                <button type="button" class="btn btn-primary w-100" style="justify-content:center;padding:10px;" onclick="showConfirmModal()">
                    Place Order
                </button>
            </form>
        </div>
    </div>
</div>

{{-- Confirmation Modal --}}
<div id="confirm-modal" style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.5);z-index:9999;align-items:center;justify-content:center;">
    <div style="background:#fff;border-radius:var(--radius);max-width:400px;width:90%;padding:24px;box-shadow:0 10px 40px rgba(0,0,0,0.2);">
        <div style="font-size:18px;font-weight:700;color:var(--navy);margin-bottom:8px;">Confirm Order</div>
        <div style="font-size:14px;color:var(--muted);margin-bottom:20px;">Are you sure you want to place this order? Please confirm your payment method and order details.</div>
        <div style="background:#f4f6f9;border:1px solid var(--border);border-radius:var(--radius);padding:12px;margin-bottom:20px;">
            <div style="font-size:13px;margin-bottom:6px;"><strong>Medicine:</strong> {{ $medicine->name }}</div>
            <div style="font-size:13px;margin-bottom:6px;"><strong>Quantity:</strong> <span id="modal-qty">1</span></div>
            <div style="font-size:13px;margin-bottom:6px;"><strong>Payment:</strong> <span id="modal-payment">Cash</span></div>
            <div style="font-size:14px;font-weight:700;color:var(--green);margin-top:10px;padding-top:10px;border-top:1px solid var(--border);"><strong>Total:</strong> <span id="modal-total">&#8369;{{ number_format($medicine->selling_price, 2) }}</span></div>
        </div>
        <div style="display:flex;gap:10px;">
            <button type="button" class="btn btn-secondary" style="flex:1;justify-content:center;" onclick="hideConfirmModal()">Cancel</button>
            <button type="button" class="btn btn-secondary" style="flex:1;justify-content:center;" onclick="submitOrderPayLater()">Pay Later</button>
            <button type="button" class="btn btn-primary" style="flex:1;justify-content:center;" onclick="submitOrder()">Confirm & Pay</button>
        </div>
    </div>
</div>

@if($medicine->description || $medicine->side_effects)
<div class="pharma-card" style="max-width:900px;margin-top:0;">
    <div class="pharma-card-header"><span class="pharma-card-title">Medicine Information</span></div>
    <div class="pharma-card-body">
        @if($medicine->description)
            <div class="section-divider">Description</div>
            <p style="margin-bottom:14px;">{{ $medicine->description }}</p>
        @endif
        @if($medicine->side_effects)
            <div class="section-divider">Side Effects</div>
            <p style="margin-bottom:14px;">{{ $medicine->side_effects }}</p>
        @endif
        @if($medicine->contraindications)
            <div class="section-divider">Contraindications</div>
            <p>{{ $medicine->contraindications }}</p>
        @endif
    </div>
</div>
@endif

<script>
const price = {{ $medicine->selling_price }};
const qtyInput = document.getElementById('qty-input');
const paymentSelect = document.querySelector('select[name=payment_method]');

function updateTotal() {
    const qty = parseInt(qtyInput.value) || 1;
    document.getElementById('summary-qty').textContent = qty;
    document.getElementById('summary-total').textContent = '\u20B1' + (price * qty).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
}

function showConfirmModal() {
    const qty = parseInt(qtyInput.value) || 1;
    const total = (price * qty).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    const payment = paymentSelect.options[paymentSelect.selectedIndex].text;
    document.getElementById('modal-qty').textContent = qty;
    document.getElementById('modal-payment').textContent = payment;
    document.getElementById('modal-total').innerHTML = '\u20B1' + total;
    document.getElementById('confirm-modal').style.display = 'flex';
}

function hideConfirmModal() {
    document.getElementById('confirm-modal').style.display = 'none';
}

function submitOrder() {
    document.getElementById('pay-later-input').value = '0';
    document.getElementById('order-form').submit();
}

function submitOrderPayLater() {
    document.getElementById('pay-later-input').value = '1';
    document.getElementById('order-form').submit();
}

qtyInput.addEventListener('input', updateTotal);
updateTotal();
</script>
@endsection

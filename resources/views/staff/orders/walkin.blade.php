@extends('layouts.app')
@section('title', 'Walk-in Order')
@section('page-title', 'Walk-in Order')
@section('page-subtitle', 'Process a walk-in customer transaction')

@section('sidebar-nav')
<div class="nav-section-title">Main</div>
<a href="{{ route('staff.dashboard') }}">Dashboard</a>
<div class="nav-section-title">Orders</div>
<a href="{{ route('staff.orders.index') }}">All Orders</a>
<a href="{{ route('staff.orders.walkin') }}" class="active">Walk-in Order</a>
<div class="nav-section-title">Inventory</div>
<a href="{{ route('staff.stock.index') }}">Stock Management</a>
@endsection

@section('content')
<form method="POST" action="{{ route('staff.orders.walkin.store') }}" id="walkin-form">
    @csrf

    @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif

    <div style="display:grid;grid-template-columns:1fr 380px;gap:20px;">

        {{-- Left: Medicine Selection --}}
        <div>
            <div class="pharma-card">
                <div class="pharma-card-header">
                    <span class="pharma-card-title">Select Medicines</span>
                    <input type="text" id="med-search" class="form-control" placeholder="Search medicine..." style="width:220px;" oninput="filterMedicines()">
                </div>
                <div style="padding:12px;max-height:600px;overflow-y:auto;">
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;" id="medicine-grid">
                        @foreach($medicines as $med)
                        <button type="button" class="med-card" data-id="{{ $med->id }}" data-name="{{ $med->name }}" data-price="{{ $med->selling_price }}" data-stock="{{ $med->stock_quantity }}" data-search="{{ strtolower($med->name . ' ' . $med->brand . ' ' . $med->generic_name) }}"
                            onclick="addToCart({{ $med->id }}, '{{ addslashes($med->name) }}', {{ $med->selling_price }}, {{ $med->stock_quantity }})"
                            style="text-align:left;padding:10px 12px;border:1.5px solid var(--border);border-radius:var(--radius);background:#fff;cursor:pointer;transition:all 0.15s;font-family:var(--font);">
                            <div style="font-size:13px;font-weight:600;color:var(--navy);">{{ $med->name }}</div>
                            <div style="font-size:11px;color:var(--muted);">{{ $med->dosage_strength }}{{ $med->dosage_unit }} {{ $med->dosage_form }}</div>
                            <div style="font-size:13px;font-weight:700;color:var(--green);margin-top:4px;">&#8369;{{ number_format($med->selling_price, 2) }}</div>
                            <div style="font-size:11px;color:{{ $med->stock_quantity <= $med->reorder_level ? 'var(--red)' : 'var(--muted)' }};">Stock: {{ $med->stock_quantity }}</div>
                        </button>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- Right: Cart & Checkout --}}
        <div style="display:flex;flex-direction:column;">
            <div class="pharma-card">
                <div class="pharma-card-header">
                    <span class="pharma-card-title">Order Summary</span>
                    <button type="button" class="btn btn-secondary btn-sm" onclick="clearCart()">Clear</button>
                </div>
                <div style="padding:12px;">
                    <div id="cart-items" style="min-height:80px;margin-bottom:12px;">
                        <div id="cart-empty" style="text-align:center;color:var(--muted);font-size:13px;padding:20px 0;">No items added yet.</div>
                    </div>
                    <div style="border-top:2px solid var(--border);padding-top:12px;">
                        <div style="display:flex;justify-content:space-between;font-size:16px;font-weight:700;">
                            <span>Total</span>
                            <span style="color:var(--green);" id="cart-total">&#8369;0.00</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pharma-card" style="margin-top:16px;flex:1;">
                <div class="pharma-card-header"><span class="pharma-card-title">Customer & Payment</span></div>
                <div class="pharma-card-body">
                    <div class="form-group">
                        <label class="form-label">Customer Name</label>
                        <input type="text" name="walkin_name" class="form-control" placeholder="Walk-in Customer (optional)" value="{{ old('walkin_name') }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Payment Method <span style="color:var(--red)">*</span></label>
                        <select name="payment_method" class="form-control" required>
                            <option value="cash" {{ old('payment_method','cash')==='cash'?'selected':'' }}>Cash</option>
                            <option value="card" {{ old('payment_method')==='card'?'selected':'' }}>Card</option>
                            <option value="gcash" {{ old('payment_method')==='gcash'?'selected':'' }}>GCash</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Payment Status <span style="color:var(--red)">*</span></label>
                        <select name="payment_status" class="form-control" required>
                            <option value="paid" {{ old('payment_status','paid')==='paid'?'selected':'' }}>Paid</option>
                            <option value="pending" {{ old('payment_status')==='pending'?'selected':'' }}>Pending</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Notes</label>
                        <input type="text" name="notes" class="form-control" placeholder="Optional" value="{{ old('notes') }}">
                    </div>
                    <div id="cart-inputs"></div>
                    <button type="submit" class="btn btn-primary w-100" style="justify-content:center;padding:10px;" id="checkout-btn" disabled>
                        Complete Transaction
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('scripts')
<script>
    let cart = {};

    function addToCart(id, name, price, stock) {
        if (cart[id]) {
            if (cart[id].qty >= stock) {
                alert('Maximum stock reached for ' + name);
                return;
            }
            cart[id].qty++;
        } else {
            cart[id] = { id, name, price, stock, qty: 1 };
        }
        renderCart();
    }

    function changeQty(id, delta) {
        if (!cart[id]) return;
        cart[id].qty += delta;
        if (cart[id].qty <= 0) {
            delete cart[id];
        } else if (cart[id].qty > cart[id].stock) {
            cart[id].qty = cart[id].stock;
        }
        renderCart();
    }

    function clearCart() {
        cart = {};
        renderCart();
    }

    function renderCart() {
        const container = document.getElementById('cart-items');
        const empty     = document.getElementById('cart-empty');
        const inputs    = document.getElementById('cart-inputs');
        const totalEl   = document.getElementById('cart-total');
        const btn       = document.getElementById('checkout-btn');

        const items = Object.values(cart);

        if (items.length === 0) {
            container.innerHTML = '<div id="cart-empty" style="text-align:center;color:var(--muted);font-size:13px;padding:20px 0;">No items added yet.</div>';
            inputs.innerHTML = '';
            totalEl.textContent = '₱0.00';
            btn.disabled = true;
            return;
        }

        let total = 0;
        let html  = '';
        let inputHtml = '';

        items.forEach((item, i) => {
            const sub = item.price * item.qty;
            total += sub;
            html += `
                <div style="display:flex;align-items:center;justify-content:space-between;padding:8px 0;border-bottom:1px solid #f0f2f5;">
                    <div style="flex:1;">
                        <div style="font-size:13px;font-weight:600;color:var(--navy);">${item.name}</div>
                        <div style="font-size:12px;color:var(--muted);">₱${item.price.toFixed(2)} each</div>
                    </div>
                    <div style="display:flex;align-items:center;gap:6px;">
                        <button type="button" onclick="changeQty(${item.id}, -1)" style="width:24px;height:24px;border:1px solid var(--border);border-radius:4px;background:#fff;cursor:pointer;font-size:14px;line-height:1;">-</button>
                        <span style="font-size:13px;font-weight:600;min-width:20px;text-align:center;">${item.qty}</span>
                        <button type="button" onclick="changeQty(${item.id}, 1)" style="width:24px;height:24px;border:1px solid var(--border);border-radius:4px;background:#fff;cursor:pointer;font-size:14px;line-height:1;">+</button>
                        <span style="font-size:13px;font-weight:700;color:var(--green);min-width:70px;text-align:right;">₱${sub.toFixed(2)}</span>
                    </div>
                </div>`;
            inputHtml += `<input type="hidden" name="items[${i}][medicine_id]" value="${item.id}">`;
            inputHtml += `<input type="hidden" name="items[${i}][quantity]" value="${item.qty}">`;
        });

        container.innerHTML = html;
        inputs.innerHTML = inputHtml;
        totalEl.textContent = '₱' + total.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
        btn.disabled = false;
    }

    function filterMedicines() {
        const q = document.getElementById('med-search').value.toLowerCase();
        document.querySelectorAll('.med-card').forEach(card => {
            card.style.display = card.dataset.search.includes(q) ? '' : 'none';
        });
    }
</script>
@endsection

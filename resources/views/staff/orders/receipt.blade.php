<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt — {{ $order->order_number }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Courier New', monospace; background: #f0f2f5; display: flex; justify-content: center; padding: 40px 16px; }
        .receipt { background: #fff; width: 380px; padding: 32px 28px; box-shadow: 0 4px 24px rgba(0,0,0,0.10); }

        .receipt-header { text-align: center; border-bottom: 2px dashed #ccc; padding-bottom: 16px; margin-bottom: 16px; }
        .receipt-header h1 { font-size: 22px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; }
        .receipt-header p { font-size: 11px; color: #666; margin-top: 4px; }

        .receipt-meta { margin-bottom: 16px; }
        .receipt-meta-row { display: flex; justify-content: space-between; font-size: 12px; margin-bottom: 4px; }
        .receipt-meta-row span:first-child { color: #666; }
        .receipt-meta-row span:last-child { font-weight: 600; }

        .receipt-divider { border: none; border-top: 1px dashed #ccc; margin: 14px 0; }

        .receipt-items { margin-bottom: 4px; }
        .receipt-item { margin-bottom: 10px; }
        .receipt-item-name { font-size: 13px; font-weight: 700; }
        .receipt-item-detail { font-size: 11px; color: #666; margin-top: 2px; }
        .receipt-item-row { display: flex; justify-content: space-between; font-size: 12px; margin-top: 4px; }

        .receipt-total-section { border-top: 2px dashed #ccc; padding-top: 12px; margin-top: 12px; }
        .receipt-total-row { display: flex; justify-content: space-between; font-size: 13px; margin-bottom: 6px; }
        .receipt-total-row.grand { font-size: 16px; font-weight: 700; border-top: 1px solid #000; padding-top: 8px; margin-top: 4px; }

        .receipt-footer { text-align: center; margin-top: 20px; padding-top: 16px; border-top: 2px dashed #ccc; }
        .receipt-footer p { font-size: 11px; color: #666; margin-bottom: 4px; }
        .receipt-footer .thank-you { font-size: 14px; font-weight: 700; letter-spacing: 1px; margin-top: 8px; }

        .receipt-staff { background: #f8f9fb; border: 1px solid #e2e8f0; padding: 10px 12px; margin-top: 14px; font-size: 12px; }
        .receipt-staff-label { color: #666; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px; }
        .receipt-staff-name { font-weight: 700; font-size: 13px; }

        .print-btn { display: block; width: 380px; margin: 20px auto 0; padding: 12px; background: #2d6a4f; color: #fff; border: none; font-size: 14px; font-weight: 600; cursor: pointer; letter-spacing: 0.5px; }
        .print-btn:hover { background: #1b4332; }
        .back-btn { display: block; width: 380px; margin: 10px auto 0; padding: 12px; background: #fff; color: #2d6a4f; border: 2px solid #2d6a4f; font-size: 14px; font-weight: 600; cursor: pointer; letter-spacing: 0.5px; }
        .back-btn:hover { background: #f0f7f4; }

        @media print {
            body { background: #fff; padding: 0; }
            .print-btn { display: none; }
            .receipt { box-shadow: none; }
        }
    </style>
</head>
<body>

<div>
    <div class="receipt">
        <div class="receipt-header">
            <h1>Pharmacy</h1>
            <p>Management System</p>
            <p style="margin-top:6px;font-size:11px;">Official Receipt</p>
        </div>

        <div class="receipt-meta">
            <div class="receipt-meta-row">
                <span>Receipt No.</span>
                <span>{{ $order->order_number }}</span>
            </div>
            <div class="receipt-meta-row">
                <span>Date</span>
                <span>{{ $order->dispensed_at?->format('M d, Y') ?? now()->format('M d, Y') }}</span>
            </div>
            <div class="receipt-meta-row">
                <span>Time</span>
                <span>{{ $order->dispensed_at?->format('g:i A') ?? now()->format('g:i A') }}</span>
            </div>
            <div class="receipt-meta-row">
                <span>Customer</span>
                <span>{{ $order->customer_name }}</span>
            </div>
            @if($order->is_walkin)
            <div class="receipt-meta-row">
                <span>Type</span>
                <span>Walk-in</span>
            </div>
            @elseif($order->user?->phone)
            <div class="receipt-meta-row">
                <span>Phone</span>
                <span>{{ $order->user->phone }}</span>
            </div>
            @endif
        </div>

        <hr class="receipt-divider">

        <div class="receipt-items">
            @foreach($order->items as $item)
            <div class="receipt-item">
                <div class="receipt-item-name">{{ $item->medicine->name }}</div>
                <div class="receipt-item-detail">{{ $item->medicine->dosage_strength }}{{ $item->medicine->dosage_unit }} {{ $item->medicine->dosage_form }}{{ $item->medicine->brand ? ' — '.$item->medicine->brand : '' }}</div>
                <div class="receipt-item-row">
                    <span>{{ $item->quantity }} x &#8369;{{ number_format($item->unit_price, 2) }}</span>
                    <span>&#8369;{{ number_format($item->subtotal, 2) }}</span>
                </div>
            </div>
            @endforeach
        </div>

        <div class="receipt-total-section">
            <div class="receipt-total-row">
                <span>Subtotal</span>
                <span>&#8369;{{ number_format($order->total_amount, 2) }}</span>
            </div>
            <div class="receipt-total-row">
                <span>Payment Method</span>
                <span>{{ strtoupper($order->payment_method) }}</span>
            </div>
            <div class="receipt-total-row">
                <span>Payment Status</span>
                <span>{{ strtoupper($order->payment_status) }}</span>
            </div>
            <div class="receipt-total-row grand">
                <span>TOTAL</span>
                <span>&#8369;{{ number_format($order->total_amount, 2) }}</span>
            </div>
        </div>

        @if($order->prescription_required)
        <div style="font-size:11px;color:#c0392b;margin-top:10px;text-align:center;font-weight:600;">
            PRESCRIPTION REQUIRED — Please present valid Rx
        </div>
        @endif

        <div class="receipt-staff">
            <div class="receipt-staff-label">Dispensed by</div>
            <div class="receipt-staff-name">{{ $order->dispenser?->name ?? 'Staff' }}</div>
        </div>

        <div class="receipt-footer">
            <p>This serves as your official receipt.</p>
            <p>Please keep this for your records.</p>
            <div class="thank-you">THANK YOU!</div>
        </div>
    </div>

    <button class="print-btn" onclick="window.print()">Print Receipt</button>
    <a class="back-btn" id="backBtn" style="display:none; text-align:center; text-decoration:none;" href="{{ route('staff.orders.index') }}">Back to Orders</a>

<script>
    window.onafterprint = function() {
        document.getElementById('backBtn').style.display = 'block';
    };
</script>
</div>

</body>
</html>

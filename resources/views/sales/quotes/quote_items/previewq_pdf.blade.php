<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>PO #{{ $quote->quote_number ?? $quote->po_number ?? '—' }}</title>

  <style>
    /* ----- Page & Base ----- */
    @page { size: letter portrait; margin: 18mm 15mm 16mm; }
    html, body { font-family: "Helvetica", Arial, sans-serif; color:#111; }
    body { font-size: 12px; line-height: 1.45; }

    /* Utilities */
    .w-100{width:100%} .w-60{width:60%} .w-40{width:40%} .w-50{width:50%}
    .mt-6{margin-top:6px} .mt-12{margin-top:12px} .mt-18{margin-top:18px}
    .mb-6{margin-bottom:6px} .mb-12{margin-bottom:12px}
    .px-10{padding:0 10px} .py-6{padding:6px 0}
    .text-right{text-align:right} .text-left{text-align:left} .text-center{text-align:center}
    .small{font-size:11px} .xs{font-size:10px; color:#666}
    .fw-600{font-weight:600} .fw-700{font-weight:700}
    .muted{color:#666}

    /* Header */
    .brand-row { border-bottom: 3px solid #111; padding-bottom: 8px; }
    .brand-left { vertical-align: top; }
    .brand-right { text-align: right; vertical-align: top; }
    .po-badge { font-size: 22px; letter-spacing: .5px; font-weight: 700; }

    /* Info blocks */
    .grid-3 { width:100%; border-collapse: collapse; table-layout: fixed; margin-top: 12px; }
    .grid-3 td { vertical-align: top; padding:8px 10px; border:1px solid #ddd; }
    .block-title { font-size:11px; letter-spacing:.6px; color:#555; font-weight:700; margin-bottom:6px; text-transform: uppercase; }
    .mono { font-family: "Menlo","Consolas",monospace; font-size: 12px; }

    /* Items table */
    table.items { width:100%; border-collapse: collapse; margin-top: 14px; }
    .items thead th {
      background: #111; color:#fff; font-weight:700; padding:8px 10px; font-size:11px; letter-spacing:.3px;
      border:1px solid #111;
    }
    .items tbody td { border:1px solid #ddd; padding:8px 10px; vertical-align: top; }
    .items tbody tr:nth-child(even) td { background: #fafafa; }
    .nowrap { white-space: nowrap; }

    /* Totals panel */
    .totals-wrap { width:100%; margin-top: 10px; }
    .totals-left { width:60%; vertical-align: top; }
    .totals-right { width:40%; vertical-align: top; }
    table.totals { width:100%; border-collapse: collapse; }
    .totals td { padding:6px 10px; border:1px solid #ddd; }
    .totals tr td:first-child { background:#f6f6f6; font-weight:600; }
    .grand td { background:#111 !important; color:#fff; font-weight:700; border-color:#111; }

    /* Footer note */
    .footnote { margin-top: 16px; border-top:1px solid #e5e5e5; padding-top:10px; }

    /* Logo fallback box if no img */
    .logo-fallback { display:inline-block; padding:6px 10px; border:2px solid #111; font-weight:700; letter-spacing:.5px; }
  </style>
</head>
<body>

  {{-- HEADER --}}
  <table class="w-100 brand-row">
    <tr>
      <td class="brand-left">
        @if(!empty($companyLogoBase64))
          <img src="data:image/png;base64,{{ $companyLogoBase64 }}" alt="Logo" style="height:52px;">
        @else
          <span class="logo-fallback">{{ $companyName ?? 'YOUR COMPANY' }}</span>
        @endif
        <div class="small mt-6">
          {{ $companyName ?? ($quote->company->name ?? '') }}<br>
          {{ $companyAddress ?? ($quote->company->address ?? '') }}
        </div>
      </td>
      <td class="brand-right">
        <div class="po-badge">PURCHASE ORDER</div>
        <div class="small mt-6">
          <span class="fw-600">PO #:</span> {{ $quote->quote_number ?? $quote->po_number ?? '—' }}<br>
          <span class="fw-600">Date:</span> {{ optional($quote->quote_date ?? $quote->created_at)->format('M d, Y') ?? date('M d, Y') }}
        </div>
      </td>
    </tr>
  </table>

  {{-- INFO BLOCKS: Vendor / Bill To / Ship To --}}
  <table class="grid-3">
    <tr>
      <td>
        <div class="block-title">Vendor</div>
        <div class="fw-600">{{ $vendor->name ?? ($quote->vendor_name ?? '—') }}</div>
        <div class="small">
          {!! nl2br(e($vendor->address ?? ($quote->vendor_address ?? ''))) !!}
        </div>
        @if(!empty($vendor->email) || !empty($vendor->phone))
          <div class="xs mt-6">
            {{ $vendor->email ?? '' }} {{ !empty($vendor->email) && !empty($vendor->phone) ? '•' : '' }}
            {{ $vendor->phone ?? '' }}
          </div>
        @endif
      </td>
      <td>
        <div class="block-title">Bill To</div>
        <div class="fw-600">{{ $quote->customer->name ?? $quote->customer_name ?? '—' }}</div>
        <div class="small">
          {!! nl2br(e($quote->customer->billing_address ?? $quote->billing_address ?? '')) !!}
        </div>
        @if(!empty($quote->customer->email) || !empty($quote->customer->phone))
          <div class="xs mt-6">
            {{ $quote->customer->email ?? '' }} {{ (!empty($quote->customer->email) && !empty($quote->customer->phone)) ? '•' : '' }}
            {{ $quote->customer->phone ?? '' }}
          </div>
        @endif
      </td>
      <td>
        <div class="block-title">Ship To</div>
        <div class="fw-600">{{ $quote->ship_to_name ?? ($quote->customer->shipping_name ?? $quote->customer->name ?? '—') }}</div>
        <div class="small">
          {!! nl2br(e($quote->ship_to_address ?? ($quote->customer->shipping_address ?? ''))) !!}
        </div>
        <div class="xs mt-6">
          <span class="fw-600">Terms:</span> {{ $quote->payment_terms ?? '—' }}<br>
          <span class="fw-600">Delivery:</span> {{ $quote->delivery_terms ?? '—' }}
        </div>
      </td>
    </tr>
  </table>

  {{-- ITEMS --}}
  <table class="items">
    <thead>
      <tr>
        <th style="width:40px;">#</th>
        <th>Description</th>
        <th style="width:90px;" class="text-right">Qty</th>
        <th style="width:80px;">Unit</th>
        <th style="width:110px;" class="text-right">Unit Price</th>
        <th style="width:120px;" class="text-right">Amount</th>
      </tr>
    </thead>
    <tbody>
      @php
        $rows = $quoteItems ?? $quote->items ?? [];
        $currency = $quote->currency ?? '$';
        $lineNo = 1; $subtotal = 0;
      @endphp

      @forelse($rows as $row)
        @php
          $qty  = (float)($row->quantity ?? $row['quantity'] ?? 0);
          $unit = $row->uom ?? $row['uom'] ?? '';
          $price = (float)($row->unit_price ?? $row['unit_price'] ?? $row->price ?? 0);
          $amount = $qty * $price; $subtotal += $amount;
        @endphp
        <tr>
          <td class="text-center">{{ $lineNo++ }}</td>
          <td>
            <div class="fw-600">{{ $row->name ?? $row['name'] ?? $row->description ?? $row['description'] ?? 'Item' }}</div>
            @if(!empty($row->description) || !empty($row['description']))
              <div class="xs muted mt-6">{!! nl2br(e($row->description ?? $row['description'])) !!}</div>
            @endif
            @if(!empty($row->sku) || !empty($row['sku']))
              <div class="xs mono mt-6">SKU: {{ $row->sku ?? $row['sku'] }}</div>
            @endif
          </td>
          <td class="text-right nowrap">{{ number_format($qty, 2) }}</td>
          <td class="nowrap">{{ $unit }}</td>
          <td class="text-right nowrap">{{ $currency }}{{ number_format($price, 2) }}</td>
          <td class="text-right nowrap">{{ $currency }}{{ number_format($amount, 2) }}</td>
        </tr>
      @empty
        <tr>
          <td colspan="6" class="text-center muted py-6">No items.</td>
        </tr>
      @endforelse
    </tbody>
  </table>

  {{-- TOTALS --}}
  @php
    $discount = (float)($quote->discount_total ?? 0);
    $tax      = (float)($quote->tax_total ?? $quote->tax ?? 0);
    $shipping = (float)($quote->shipping_total ?? 0);
    $grand    = max(0, $subtotal - $discount + $tax + $shipping);
  @endphp

  <table class="totals-wrap">
    <tr>
      <td class="totals-left">
        @if(!empty($quote->notes))
          <div class="block-title">Notes / Instructions</div>
          <div class="small">{!! nl2br(e($quote->notes)) !!}</div>
        @endif
        @if(!empty($quote->footer))
          <div class="footnote small">{!! nl2br(e($quote->footer)) !!}</div>
        @endif
      </td>
      <td class="totals-right">
        <table class="totals">
          <tr><td>Subtotal</td><td class="text-right">{{ $currency }}{{ number_format($subtotal, 2) }}</td></tr>
          @if($discount > 0)
            <tr><td>Discount</td><td class="text-right">-{{ $currency }}{{ number_format($discount, 2) }}</td></tr>
          @endif
          @if($shipping > 0)
            <tr><td>Shipping</td><td class="text-right">{{ $currency }}{{ number_format($shipping, 2) }}</td></tr>
          @endif
          @if($tax > 0)
            <tr><td>Tax</td><td class="text-right">{{ $currency }}{{ number_format($tax, 2) }}</td></tr>
          @endif
          <tr class="grand">
            <td>Total</td>
            <td class="text-right">{{ $currency }}{{ number_format($grand, 2) }}</td>
          </tr>
        </table>
      </td>
    </tr>
  </table>

  {{-- Optional signature strip (uncomment if needed)
  <div class="mt-18 small">
    Authorized Signature: _____________________________ &nbsp;&nbsp; Date: _____________
  </div> --}}

</body>
</html>

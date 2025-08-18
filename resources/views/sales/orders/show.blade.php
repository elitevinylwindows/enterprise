<div class="modal-header">
    <h5 class="modal-title">Order #{{ $order->order_number }}</h5>
</div>

<div class="modal-body">
    {{-- Company Info --}}
    <div class="mb-3">
        <strong>Elite Vinyl Windows</strong><br>
        4231 Liberty Blvd, CA 90280<br>
        Tel: (562) 945-7700 | Fax: (562) 800-7064<br>
        Website: www.elitevinylwindows.com
    </div>

    {{-- Header Details --}}
    <div class="row mb-4">
        <div class="col-md-4"><strong>Quotation #:</strong> {{ $order->quote->quote_number ?? '-' }}</div>
        <div class="col-md-4"><strong>Invoice #:</strong> {{ $order->invoice->invoice_number ?? '-' }}</div>
        <div class="col-md-4"><strong>Sales Agent:</strong> {{ $order->user->name ?? '-' }}</div>
        <div class="col-md-4"><strong>Direct Extension:</strong> {{ $order->quote->user->phone_extension ?? '-' }}</div>
        <div class="col-md-4"><strong>Delivery Date:</strong> {{ $order->due_date ?? '-' }}</div>
    </div>

    {{-- Addresses --}}
    <div class="row">
        <div class="col-md-6">
            <h6>Billing Address</h6>
            {{ $order->customer->billing_address ?? $order->customer->billing_address }}<br>
            {{ $order->customer->billing_city ?? $order->customer->billing_city }},
            {{ $order->customer->billing_state ?? $order->customer->billing_state }},
            {{ $order->customer->billing_zip ?? $order->customer->billing_zip }}<br>
            {{ $order->customer->billing_phone }}
        </div>
        <div class="col-md-6">
            <h6>Delivery Address</h6>
            {{ $order->customer->delivery_address ?? $order->customer->delivery_address }}<br>
            {{ $order->customer->delivery_city ?? $order->customer->delivery_city }},
            {{ $order->customer->delivery_state ?? $order->customer->delivery_state }},
            {{ $order->customer->delivery_zip ?? $order->customer->delivery_zip }}<br>
            {{ $order->customer->delivery_phone }}
        </div>
    </div>

    {{-- Order Notes --}}
    <div class="mt-4 mb-2"><strong>Order Notes:</strong> {{ $order->quote->notes ?? '-' }}</div>

    {{-- Items Table --}}
    <div class="table-responsive">
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th style="width: 0%;">Item</th>
                    <th>Qty</th>
                    <th>Size</th>
                    <th style="width: 0%;">Glass</th>
                    <th style="width: 0%;">Grid</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items->where('is_modification', 0) as $index => $item)
                <tr>
                    <td style="width: 0%;">{{ $item->description ?? 'N/A' }}</td>
                    <td>{{ $item->qty }}</td>
                    <td>{{ $item->width }}" x {{ $item->height }}"</td>
                    <td style="width: 0%;">{{ $item->glass ?? 'N/A' }}</td>
                    <td style="width: 0%;">{{ $item->grid ?? 'N/A' }}</td>
                    <td>${{ number_format($item->price, 2) }}</td>
                    <td>${{ number_format($item->total, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
            </table>
            @if(!$modificationsByDate->isEmpty())
                @foreach ($modificationsByDate as $date => $modifications)
                    <table class="table table-bordered  mt-4 modificationsTable" data-mod-date="{{ $date }}">
                        <thead class="table-light">
                            <tr>
                                <th colspan="9" class="text-center">Modifications ({{ $date }})</th>
                            </tr>
                            <tr>
                                <th>Item</th>
                                <th>Qty</th>
                                <th>Size</th>
                                <th>Glass</th>
                                <th>Grid</th>
                                <th>Price</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($modifications as $modification)
                                <tr data-id="{{ $modification->id }}" data-type="modification">
                                    <td style="text-wrap:auto">{{ $modification->description }}</td>
                                    <td>{{ $modification->qty }}</td>
                                    <td>{{ $modification->width }}" x {{ $modification->height }}"</td>
                                    <td>{{ $modification->glass }}</td>
                                    <td>{{ $modification->grid }}</td>
                                    <td>${{ number_format($modification->price, 2) }}</td>
                                    <td>${{ number_format($modification->total, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endforeach
            @endif
</div> {{-- CLOSE .table-responsive right after the table --}}

{{-- Totals --}}
<div class="row mt-4">
    <div class="col-md-6 offset-md-6">
        <table class="table">
            <tr>
                <th>Discount:</th>
                <td id="discount">${{ number_format($order->discount, 2) }}</td>
            </tr>
            <tr>
                <th>Shipping:</th>
                <td id="shipping">${{ number_format($order->shipping, 2) }}</td>
            </tr>
            <tr>
                <th>Subtotal:</th>
                <td id="subtotal-amount">
                    ${{ number_format($order->items->sum('total') + $order->shipping, 2) }}
                </td>
            </tr>
            <tr>
                <th>Tax:</th>
                <td id="tax-amount">${{ number_format($order->tax, 2) }}</td>
            </tr>
            <tr>
                <th>Total:</th>
                <td><strong id="total-amount">
                    ${{ number_format(($order->items->sum('total') - $order->discount) + $order->shipping + $order->tax, 2) }}
                </strong></td>
            </tr>
        </table>
    </div>
</div>

@php
  $pdfUrl = asset('storage/orders/order_' . $order->order_number . '.pdf');
@endphp

<div class="pdf-tile">
  <div class="thumb-wrap icon-only">
    {{-- Medium PDF icon as the thumbnail --}}
    <i class="fa-solid fa-file-pdf pdf-icon" aria-hidden="true"></i>
    <div class="tile-overlay"></div>
  </div>

  {{-- Center eye: open in a new tab --}}
  <a href="{{ $pdfUrl }}" target="_blank" rel="noopener" class="tile-eye" title="Open">
    <i class="fa-solid fa-eye"></i>
  </a>

  {{-- Top-right neutral 3-dot menu --}}
  <div class="dropdown tile-menu">
    <button class="tile-dot" type="button" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false" aria-label="More">
      <i class="fa-solid fa-ellipsis-vertical"></i>
    </button>
    <ul class="dropdown-menu dropdown-menu-end shadow">
      <li>
        <a class="dropdown-item" href="{{ $pdfUrl }}" target="_blank" rel="noopener">
          <i class="fa-solid fa-up-right-from-square me-2"></i> Open
        </a>
      </li>
      <li>
        <a class="dropdown-item" href="{{ $pdfUrl }}" download>
          <i class="fa-solid fa-download me-2"></i> Download
        </a>
      </li>
    </ul>
  </div>

  <div class="pdf-label">
    <i class="fa-solid fa-file-pdf me-1"></i> PDF
  </div>
</div>


<style>
.pdf-tile{ position:relative; display:inline-block; width:160px; aspect-ratio:3/4; border-radius:14px; }
.pdf-tile .thumb-wrap{ position:relative; width:100%; height:100%; overflow:hidden; border-radius:14px; }
.pdf-tile .thumb-wrap.icon-only{
  display:flex; align-items:center; justify-content:center;
  background:linear-gradient(135deg,#ffffff 0%,#f5f6f8 100%); border:1px solid rgba(0,0,0,.06);
}
.pdf-icon{ font-size:clamp(44px,7.5vw,72px); color:#c71f1f; filter:drop-shadow(0 1px 1px rgba(0,0,0,.15)); }

.tile-overlay{ position:absolute; inset:0; background:linear-gradient(180deg,rgba(0,0,0,.08),rgba(0,0,0,.25)); opacity:0; transition:opacity .2s; }
.tile-eye{ position:absolute; inset:0; display:flex; align-items:center; justify-content:center; color:#fff; font-size:1.25rem; text-decoration:none; opacity:0; transform:translateY(4px); transition:all .2s; z-index:2; }

.tile-menu{ position:absolute; top:8px; right:8px; z-index:3; }
/* Neutral 3-dot button (no red background) */
.tile-dot{
  background:#fff !important; color:#6c757d !important; border:1px solid rgba(0,0,0,.08) !important;
  padding:4px 6px; line-height:1; border-radius:999px; box-shadow:0 1px 2px rgba(0,0,0,.06);
}
.tile-dot:hover{ background:#f8f9fa !important; color:#212529 !important; }

.pdf-label{
  position:absolute; left:8px; bottom:8px; z-index:2; background:rgba(255,255,255,.95); color:#333;
  font-size:.75rem; padding:2px 8px; border-radius:999px; backdrop-filter:saturate(180%) blur(2px);
}

.pdf-tile:hover .tile-eye{ opacity:1; transform:none; }
.pdf-tile:hover .tile-overlay{ opacity:1; }
</style>



    {{-- Thank You --}}
    <div class="mt-5 text-center">
        <em>Thank you for your order. We appreciate your business.</em>
    </div>
</div>

<div class="modal-footer">
    {{-- <button class="btn btn-success">Send</button> --}}
    {{-- <button class="btn btn-primary">Save</button> --}}
    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
</div>



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
        <div class="col-md-4"><strong>Sales Agent:</strong> {{ $order->quote->user->name ?? '-' }}</div>
        <div class="col-md-4"><strong>Direct Extension:</strong> {{ $order->quote->user->phone_extension ?? '-' }}</div>
        <div class="col-md-4"><strong>Delivery Date:</strong> {{ $order->delivery_date ?? '-' }}</div>
    </div>

    {{-- Addresses --}}
    <div class="row">
        <div class="col-md-6">
            <h6>Billing Address</h6>
            {{ $order->customer->billing_address ?? $order->customer->address }}<br>
            {{ $order->customer->billing_city ?? $order->customer->city }},
            {{ $order->customer->billing_state ?? $order->customer->state }},
            {{ $order->customer->billing_zip ?? $order->customer->zip }}<br>
            {{ $order->customer->phone }}
        </div>
        <div class="col-md-6">
            <h6>Delivery Address</h6>
            {{ $order->customer->delivery_address ?? $order->customer->address }}<br>
            {{ $order->customer->delivery_city ?? $order->customer->city }},
            {{ $order->customer->delivery_state ?? $order->customer->state }},
            {{ $order->customer->delivery_zip ?? $order->customer->zip }}<br>
            {{ $order->customer->phone }}
        </div>
    </div>

    {{-- Order Notes --}}
    <div class="mt-4 mb-2"><strong>Order Notes:</strong> {{ $order->quote->notes ?? '-' }}</div>

    {{-- Items Table --}}
    <div class="table-responsive">
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Item</th>
                    <th>Qty</th>
                    <th>Size</th>
                    <th>Frame Type</th>
                    <th>Glass</th>
                    <th>Grid</th>
                    
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->quote->items as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->unit ?? '-' }}</td>
                    <td>{{ $item->qty }}</td>
                    <td>{{ $item->size ?? '-' }}</td>
                    <td>{{ $item->frame_type ?? '-' }}</td>
                    <td>{{ $item->glass ?? '-' }}</td>
                    <td>{{ $item->grid ?? '-' }}</td>       
                    <td>${{ number_format($item->total, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Totals --}}
    <div class="text-end mt-4">
        <p><strong>Total Qty:</strong> {{ $order->quote->items->sum('qty') }}</p>
        <p><strong>Shipping:</strong> ${{ number_format($order->shipping, 2) }}</p>
        <p><strong>Subtotal:</strong> ${{ number_format($order->subtotal, 2) }}</p>
        <p><strong>Discount:</strong> ${{ number_format($invoice->discount, 2) }}</p>
        <p><strong>Tax:</strong> ${{ number_format($order->tax, 2) }}</p>
        <h5><strong>Total:</strong> ${{ number_format($order->total, 2) }}</h5>
    </div>

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

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
        <div class="col-md-4"><strong>Quotation #:</strong> {{ $invoice->quote->quote_number ?? '-' }}</div>
        <div class="col-md-4"><strong>Invoice #:</strong> {{ $invoice->invoice->invoice_number ?? '-' }}</div>
        <div class="col-md-4"><strong>Sales Agent:</strong> {{ $invoice->quote->user->name ?? '-' }}</div>
        <div class="col-md-4"><strong>Direct Extension:</strong> {{ $invoice->quote->user->phone_extension ?? '-' }}</div>
        <div class="col-md-4"><strong>Delivery Date:</strong> {{ $invoice->delivery_date ?? '-' }}</div>
    </div>

    {{-- Addresses --}}
    <div class="row">
        <div class="col-md-6">
            <h6><strong>Billing Address</strong></h6>
            {{ $invoice->customer->billing_address ?? $invoice->customer->address }}<br>
            {{ $invoice->customer->billing_city ?? $invoice->customer->city }},
            {{ $invoice->customer->billing_state ?? $invoice->customer->state }},
            {{ $invoice->customer->billing_zip ?? $invoice->customer->zip }}<br>
            {{ $invoice->customer->phone }}
        </div>
        <div class="col-md-6">
            <h6><strong>Delivery Address</strong></h6>
            {{ $invoice->customer->delivery_address ?? $invoice->customer->address }}<br>
            {{ $invoice->customer->delivery_city ?? $invoice->customer->city }},
            {{ $invoice->customer->delivery_state ?? $invoice->customer->state }},
            {{ $invoice->customer->delivery_zip ?? $invoice->customer->zip }}<br>
            {{ $invoice->customer->phone }}
        </div>
    </div>

    {{-- Notes --}}
    <div class="mt-4 mb-2"><strong>Quote Notes:</strong> {{ $invoice->quote->notes ?? '-' }}</div>

    {{-- Items Table --}}
    <div class="table-responsive">
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Unit</th>
                    <th>Size</th>
                    <th>Frame Type</th>
                    <th>Color</th>
                    <th>Glass</th>
                    <th>Grid</th>
                    <th>Qty</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($invoice->quote->items as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->unit ?? '-' }}</td>
                    <td>{{ $item->size ?? '-' }}</td>
                    <td>{{ $item->frame_type ?? '-' }}</td>
                    <td>{{ $item->color ?? '-' }}</td>
                    <td>{{ $item->glass ?? '-' }}</td>
                    <td>{{ $item->grid ?? '-' }}</td>
                    <td>{{ $item->qty }}</td>
                    <td>${{ number_format($item->total, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Totals --}}
    <div class="text-end mt-4">
        <p><strong>Total Qty:</strong> {{ $invoice->quote->items->sum('qty') }}</p>
        <p><strong>Shipping:</strong> ${{ number_format($order->shipping, 2) }}</p>
        <p><strong>Subtotal:</strong> ${{ number_format($invoice->subtotal, 2) }}</p>
        <p><strong>Discount:</strong> ${{ number_format($invoice->discount, 2) }}</p>
        <p><strong>Tax:</strong> ${{ number_format($invoice->tax, 2) }}</p>
        <h5><strong>Total:</strong> ${{ number_format($invoice->total, 2) }}</h5>
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

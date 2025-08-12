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
        <div class="col-md-4"><strong>Invoice #:</strong> {{ $invoice->invoice_number ?? '-' }}</div>
        <div class="col-md-4"><strong>Sales Agent:</strong> {{ $invoice->order->user->name ?? '-' }}</div>
        <div class="col-md-4"><strong>Direct Extension:</strong> {{ $invoice->quote->user->phone_extension ?? '-' }}</div>
        <div class="col-md-4"><strong>Delivery Date:</strong> {{ $invoice->delivery_date ?? '-' }}</div>
    </div>

    {{-- Addresses --}}
    <div class="row">
        <div class="col-md-6">
            <h6><strong>Billing Address</strong></h6>
            {{ $invoice->customer->billing_address ?? $invoice->customer->billing_address }}<br>
            {{ $invoice->customer->billing_city ?? $invoice->customer->billing_city }},
            {{ $invoice->customer->billing_state ?? $invoice->customer->billing_state }},
            {{ $invoice->customer->billing_zip ?? $invoice->customer->billing_zip }}<br>
            {{ $invoice->customer->billing_phone }}
        </div>
        <div class="col-md-6">
            <h6><strong>Delivery Address</strong></h6>
            {{ $invoice->customer->delivery_address ?? $invoice->customer->delivery_address }}<br>
            {{ $invoice->customer->delivery_city ?? $invoice->customer->delivery_city }},
            {{ $invoice->customer->delivery_state ?? $invoice->customer->delivery_state }},
            {{ $invoice->customer->delivery_zip ?? $invoice->customer->delivery_zip }}<br>
            {{ $invoice->customer->delivery_phone }}
        </div>
    </div>

    {{-- Notes --}}
    <div class="mt-4 mb-2"><strong>Quote Notes:</strong> {{ $invoice->quote->notes ?? '-' }}</div>

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
                @foreach($invoice->order->items as $index => $item)
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
         <div class="row mt-4">
            <div class="col-md-6 offset-md-6">
                <table class="table">
                    <tr>
                        <th>Discount:</th>
                        <td id="discount">-${{ number_format($invoice->discount, 2) }}</td>
                    </tr>
                    <tr>
                        <th>Shipping:</th>
                        <td id="shipping">${{ number_format($invoice->shipping, 2) }}</td>
                    </tr>
                    <tr>
                        <th>Subtotal:</th>
                        <td id="subtotal-amount">
                            ${{ number_format($invoice->sub_total, 2) }}
                        </td>
                    </tr>
                    <tr>
                        <th>Tax:</th>
                        <td id="tax-amount">${{ number_format($invoice->tax, 2) }}</td>
                    </tr>
                    <tr>
                        <th>Total:</th>
                        <td><strong id="total-amount">${{ number_format(($invoice->order->items->sum('total') - $invoice->discount) + $invoice->shipping + $invoice->tax, 2) }}</strong></td>
                    </tr>
                </table>
            </div>
        </div>

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

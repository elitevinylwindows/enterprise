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
                @foreach($order->items as $index => $item)
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
                        <td><strong id="total-amount">${{ number_format(($order->items->sum('total') - $order->discount) + $order->shipping + $order->tax, 2) }}</strong></td>
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

<div class="modal-body">
    {{-- Company Info --}}
    <div class="mb-3">
        <strong>Elite Vinyl Windows</strong><br>
        1234 Company Address, CA 90000<br>
        Tel: (123) 456-7890 | Fax: (123) 456-7891<br>
        Website: www.elitevw.com
    </div>

    {{-- Header Details --}}
    <div class="row mb-4">
        <div class="col-md-3"><strong>Quotation #:</strong> {{ $invoice->quote->quote_number ?? '-' }}</div>
        <div class="col-md-3"><strong>Invoice #:</strong> {{ $invoice->invoice_number ?? '-' }}</div>
        <div class="col-md-3"><strong>Delivery Date:</strong> {{ $invoice->order->delivery_date ?? '-' }}</div>
        <div class="col-md-3">
            <strong>Due Date:</strong> {{ $invoice->due_date }}
        </div>

        {{-- Addresses --}}
        <div class="row">
            <div class="col-md-6">
                <h6>Billing Address</h6>
                {{ $invoice->order->customer->billing_address ?? $invoice->order->customer->address }}<br>
                {{ $invoice->order->customer->billing_city ?? $invoice->order->customer->city }},
                {{ $invoice->order->customer->billing_state ?? $invoice->order->customer->state }},
                {{ $invoice->order->customer->billing_zip ?? $invoice->order->customer->zip }}<br>
                {{ $invoice->order->customer->phone }}
            </div>
            <div class="col-md-6">
                <h6>Delivery Address</h6>
                {{ $invoice->order->customer->delivery_address ?? $invoice->order->customer->address }}<br>
                {{ $invoice->order->customer->delivery_city ?? $invoice->order->customer->city }},
                {{ $invoice->order->customer->delivery_state ?? $invoice->order->customer->state }},
                {{ $invoice->order->customer->delivery_zip ?? $invoice->order->customer->zip }}<br>
                {{ $invoice->order->customer->phone }}
            </div>
        </div>

        {{-- Order Notes --}}
        <div class="mt-4 mb-2"><strong>Quote Notes:</strong> {{ $invoice->order->quote->notes ?? '-' }}</div>

        {{-- Items Table --}}
        <div class="table-responsive">
            <table class="table table-bordered mt-3">
                <thead class="table-secondary">
                    <thead>
                        <tr>
                            <th style="width: 0%;">Item</th>
                            <th style="width: 0%;">Glass</th>
                            <th style="width: 0%;">Grid</th>
                            <th>Qty</th>
                            <th>Size</th>
                            <th>Price</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                <tbody>
                    @foreach ($invoice->order->items as $index => $item)
                    <tr>
                        <td style="text-wrap:auto;">{{ $item->description ?? 'N/A' }}</td>
                        <td style="text-wrap:auto;">{{ $item->glass ?? 'N/A' }}</td>
                        <td style="text-wrap:auto;">{{ $item->grid ?? 'N/A' }}</td>
                        <td>{{ $item->qty }}</td>
                        <td>{{ $item->width }}" x {{ $item->height }}"</td>
                        <td>${{ number_format($item->price, 2) }}</td>
                        <td>${{ number_format($item->total, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Required Payment Type:</strong>
                            <select class="form-control w-100 mb-2" name="required_payment_type"
                                id="required_payment_type">
                                <option value="fixed" {{ $invoice->required_payment_type == 'fixed' ? 'selected' : '' }}
                                    selected>Fixed Amount</option>
                                <option value="percentage" {{ $invoice->required_payment_type == 'percentage' ?
                                    'selected' :
                                    '' }}>Percentage</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div id="fixed_amount_group"
                                style="{{ $invoice->required_payment_type == 'fixed' ? '' : 'display:none;' }}">
                                <strong>Fixed Amount:</strong>
                                <input type="number" step="0.01" class="form-control w-100"
                                    value="{{ number_format($invoice->required_payment, 2) }}"
                                    name="required_payment_fixed" id="required_payment_fixed">
                            </div>
                            <div id="percentage_group"
                                style="{{ $invoice->required_payment_type == 'percentage' ? '' : 'display:none;' }}">
                                <strong>Percentage (%):</strong>
                                <input type="number" step="0.01" class="form-control w-100"
                                    value="{{ number_format($invoice->required_payment_percentage, 2) }}"
                                    name="required_payment_percentage" id="required_payment_percentage">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <table class="table">
                        <tr>
                            <th class="w-auto">Discount:</th>
                            <td id="discount-amount" class="w-auto">
                                {{ number_format($invoice->discount, 2) }}
                            </td>
                        </tr>
                        <tr>
                            <th class="w-auto">Subtotal:</th>
                            <td id="subtotal-amount" class="w-auto">
                                {{ number_format($invoice->sub_total, 2) }}
                            </td>
                        </tr>
                        <tr>
                            <th class="w-auto">Tax (%):</th>
                            <td id="tax-amount" class="w-auto">
                                {{ number_format($invoice->tax, 2) }}
                            </td>
                        </tr>
                        <tr>
                            <th class="w-auto">Shipping:</th>
                            <td id="shipping-amount" class="w-auto">
                                {{ number_format($invoice->shipping, 2) }}
                            </td>
                        </tr>
                        <tr>
                            <th class="w-auto">Total:</th>
                            <td class="w-auto"><strong id="total-amount">
                                    {{ number_format($invoice->total, 2) }}
                                </strong></td>
                        </tr>
                    </table>
                </div>
            </div>
            </form>
        </div>

        {{-- Thank You --}}
        <div class="mt-5 text-center">
            <em>Thank you for your order. We appreciate your business.</em>
        </div>
    </div>

    <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    </div>

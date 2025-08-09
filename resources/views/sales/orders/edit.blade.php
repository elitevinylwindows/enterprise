<div class="modal-body">
    <form method="POST" action="{{ route('sales.orders.update', $order->id) }}" id="orderUpdateForm">
        @csrf
        @method('PUT')
        <div class="row mb-3">
            <div class="col-md-4">
                <label>Quote Number</label>
                <input type="text" name="quote_number" id="quote_number" value="{{ $order->quote->quote_number }}" class="form-control"
                    placeholder="Enter Quote Number">
            </div>
            <div class="col-md-4">
                <label>Order Number</label>
                <input type="text" name="order_number" id="order_number" value="{{ $order->order_number }}" class="form-control" readonly>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <label>Customer #</label>
                <input type="text" name="customer_number" id="customer_number" value="{{ $order->customer->customer_number }}" class="form-control" readonly>
            </div>
            <div class="col-md-4">
                <label>Customer Name</label>
                <input type="text" name="customer_name" id="customer_name" value="{{ $order->customer->customer_name }}" class="form-control" readonly>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <label>Entry Date</label>
                <input type="date" name="entry_date" class="form-control"  value="{{ $order->entry_date }}" readonly>
            </div>
            <div class="col-md-4">
                <label>Delivery Date</label>
                <input type="date" name="delivery_date" class="form-control" value="{{ $order->expected_delivery_date }}">
            </div>
            <div class="col-md-4">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="active" {{ $order->status === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="draft" {{ $order->status === 'draft' ? 'selected' : '' }}>Draft</option>
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12">
                <label>Order Notes</label>
                <textarea name="notes" id="order_notes" class="form-control" rows="3"></textarea>
            </div>
        </div>

        <table id="quoteDetailsTable" class="table table-bordered table-striped">
            <thead class="table-light">
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
                @foreach($order->items as $item)
                <tr data-id="{{ $item->item_id }}">
                    <td style="text-wrap:auto">{{ $item->description ?? 'N/A' }}</td>
                    <td>{{ $item->qty }}</td>
                    <td>{{ $item->size }}"</td>
                    <td>{{ $item->glass ?? 'N/A' }}</td>
                    <td>{{ $item->grid ?? 'N/A' }}</td>
                    <td>${{ number_format($item->price, 2) }}</td>
                    <td class="item-total" data-id="{{ $item->item_id }}">${{ number_format($item->total, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <hr>

        <div class="row mt-4">
            <div class="col-md-6 offset-md-6">
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Discount:</span>
                        <strong id="discountDisplay">${{ number_format($order->discount, 2) }}</strong>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Shipping:</span>
                        <input type="number" step="0.01" value="{{ number_format($order->shipping, 2) }}" class="form-control w-25" name="shipping" id="shipping">
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Subtotal:</span>
                        <strong id="subtotalDisplay">${{ number_format(($order->sub_total + $order->shipping) - $order->discount, 2) }}</strong>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Tax:</span>
                        <strong id="taxDisplay">%{{ number_format($order->tax, 2) }}</strong>
                    </li>

                    <li class="list-group-item d-flex justify-content-between">
                        <span>Total:</span>
                        <strong id="totalDisplay">${{ number_format($order->total, 2) }}</strong>
                    </li>
                </ul>
            </div>
        </div>
    </form>
</div>

<div class="modal-footer">
    <button type="submit" class="btn btn-primary">Update Order</button>
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
</div>
<script>
    $(document).ready(function() {
            $('#shipping').on('input focusout', function() {
            const shippingCost = parseFloat($(this).val()) || 0;
            const subtotal = parseFloat($('#subtotalDisplay').text().replace(/[^0-9.-]+/g,"")) || 0;
            const tax = parseFloat($('#taxDisplay').text().replace(/[^0-9.-]+/g,"")) || 0;
            const discount = parseFloat($('#discountDisplay').text().replace(/[^0-9.-]+/g,"")) || 0;

            const total = subtotal + tax + shippingCost - discount;
            $('#totalDisplay').text('$' + total.toFixed(2));
        });
    });


</script>

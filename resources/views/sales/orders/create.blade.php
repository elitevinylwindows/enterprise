<div class="modal fade" id="createOrderModal" tabindex="-1" aria-labelledby="createOrderLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <form method="POST" action="{{ route('sales.orders.store') }}" id="orderCreateForm">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create Order</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label>Quote Number</label>
                            <input type="text" name="quote_number" id="quote_number" class="form-control" placeholder="Enter Quote Number">
                        </div>
                        <div class="col-md-4">
                            <label>Order Number</label>
                            <input type="text" name="order_number" id="order_number" class="form-control" readonly>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label>Customer #</label>
                            <input type="text" name="customer_number" id="customer_number" class="form-control" readonly>
                        </div>
                        <div class="col-md-4">
                            <label>Customer Name</label>
                            <input type="text" name="customer_name" id="customer_name" class="form-control" readonly>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label>Entry Date</label>
                            <input type="date" name="entry_date" class="form-control" value="{{ date('Y-m-d') }}" readonly>
                        </div>
                        <div class="col-md-4">
                            <label>Delivery Date</label>
                            <input type="date" name="delivery_date" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="active">Active</option>
                                <option value="draft">Draft</option>
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
                        </tbody>
                    </table>
                    <hr>

                    <div class="row mt-4">
                        <div class="col-md-6 offset-md-6">
                            <ul class="list-group">
                              <li class="list-group-item d-flex justify-content-between">
                                    <span>Discount:</span>
                                    <strong id="discountDisplay">$0.00</strong>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Subtotal:</span>
                                    <strong id="subtotalDisplay">$0.00</strong>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Tax:</span>
                                    <strong id="taxDisplay">%0.00</strong>
                                </li>
                                 <li class="list-group-item d-flex justify-content-between">
                                    <span>Shipping:</span>
                                    <input type="number" step="0.01" class="form-control w-25" name="shipping" id="shipping">
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Total:</span>
                                    <strong id="totalDisplay">$0.00</strong>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Create Order</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    document.getElementById('quote_number').addEventListener('change', function() {
        const quoteNumber = this.value;
        if (!quoteNumber) return;

        fetch(`/sales/quotes/fetch-info/${quoteNumber}`)
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    const q = data.data;
                    console.log(q);
                    // Check if all elements exist before assigning values
                    const setValue = (id, value) => {
                        const el = document.getElementById(id);
                        if (el) el.value = value;
                    };
                    setValue('order_number', q.order_number ?? '');
                    setValue('customer_number', q.quote.customer_number);
                    setValue('customer_name', q.quote.customer_name);
                    $('#discountDisplay').text("$"+parseFloat(q.quote.discount).toFixed(2) ?? '');
                    $('#subtotalDisplay').text("$"+parseFloat(q.quote.sub_total).toFixed(2) ?? '');
                    $('#taxDisplay').text("$"+parseFloat(q.quote.tax).toFixed(2) ?? '');
                    $('#totalDisplay').text("$"+parseFloat(q.quote.total).toFixed(2) ?? '');
                    $('#shipping').val(parseFloat(q.quote.shipping).toFixed(2) ?? '');

                    const tbody = document.querySelector('#quoteDetailsTable tbody');
                    tbody.innerHTML = '';

                    if (Array.isArray(q.quote.items)) {
                      q.quote.items.forEach(item => {
                        const itemDesc = item.description || '';
                        const qty = item.qty || 1;
                        const size = item.size || '';
                        const glass = item.glass || '';
                        const grid = item.grid || '';
                        const price = parseFloat(item.price || 0).toFixed(2);
                        const total = (qty * price).toFixed(2);

                        const row = `
                          <tr data-id="${item.item_id}">
                            <td style="text-wrap:auto">${itemDesc}</td>
                            <td>${qty}</td>
                            <td>${size}</td>
                            <td>${glass}</td>
                            <td>${grid}</td>
                            <td>$${price}</td>
                            <td class="item-total" data-id="${item.item_id}">$${total}</td>
                          </tr>
                        `;
                        tbody.insertAdjacentHTML('beforeend', row);
                      });
                    }

                } else {
                    alert('Quote not found');
                    return; // Prevent further execution
                }
            })
            .catch(err => {
                console.error(err);
                alert('Error fetching quote');
            });

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

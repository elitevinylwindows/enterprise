<!-- Invoice Create Modal -->
<div class="modal fade" id="createInvoiceModal" tabindex="-1" aria-labelledby="createInvoiceLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <form method="POST" action="{{ route('sales.invoices.store') }}" id="invoiceCreateForm">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Create Invoice</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          {{-- Row 1 --}}
          <div class="row mb-3">
            <div class="col-md-4">
              <label>Quote Number</label>
              <input type="text" name="quote_number" id="invoice_quote_number" class="form-control" placeholder="Enter Quote Number">
            </div>
            <div class="col-md-4">
              <label>Customer Number</label>
              <input type="text" name="customer_number" id="invoice_customer_number" class="form-control" readonly>
            </div>
            <div class="col-md-4">
              <label>Customer Name</label>
              <input type="text" name="customer_name" id="invoice_customer_name" class="form-control" readonly>
            </div>
          </div>

          {{-- Row 2 --}}
          <div class="row mb-3">
            <div class="col-md-4">
              <label>Invoice Number</label>
              <input type="text" name="invoice_number" id="invoice_number" class="form-control" readonly>
            </div>
            <div class="col-md-4">
              <label>Invoice Date</label>
              <input type="date" name="invoice_date" class="form-control" value="{{ date('Y-m-d') }}">
            </div>
            <div class="col-md-4">
              <label>Order Number</label>
              <input type="text" name="order_number" id="order_number" class="form-control" readonly>
            </div>
          </div>

          {{-- Notes + Status --}}
          <div class="row mt-3">
            <div class="col-md-8">
              <label>Notes</label>
              <textarea name="notes" class="form-control" rows="3"></textarea>
            </div>
            <div class="col-md-4">
              <label>Status</label>
              <select name="status" class="form-control">
                <option value="draft">Draft</option>
                <option value="active">Active</option>
              </select>
            </div>
          </div>

          <hr>

          {{-- Billing & Delivery --}}
          <div class="row">
            <div class="col-md-6">
              <h6>Billing Information</h6>
              <input type="text" name="billing_address" id="billing_address" class="form-control mb-2" placeholder="Billing Address" readonly>
              <input type="text" name="billing_city" id="billing_city" class="form-control mb-2" placeholder="City" readonly>
              <input type="text" name="billing_state" id="billing_state" class="form-control mb-2" placeholder="State" readonly>
              <input type="text" name="billing_zip" id="billing_zip" class="form-control mb-2" placeholder="ZIP" readonly>
              <input type="text" name="billing_phone" id="billing_phone" class="form-control mb-2" placeholder="Phone" readonly>
              <input type="email" name="billing_email" id="billing_email" class="form-control mb-2" placeholder="Email" readonly>
            </div>

            <div class="col-md-6">
              <h6>Delivery Information</h6>
              <input type="text" name="delivery_address" id="delivery_address" class="form-control mb-2" placeholder="Delivery Address" readonly>
              <input type="text" name="delivery_city" id="delivery_city" class="form-control mb-2" placeholder="City" readonly>
              <input type="text" name="delivery_state" id="delivery_state" class="form-control mb-2" placeholder="State" readonly>
              <input type="text" name="delivery_zip" id="delivery_zip" class="form-control mb-2" placeholder="ZIP" readonly>
              <input type="text" name="delivery_phone" id="delivery_phone" class="form-control mb-2" placeholder="Phone" readonly>
              <input type="email" name="delivery_email" id="delivery_email" class="form-control mb-2" placeholder="Email" readonly>
            </div>
          </div>

          {{-- Summary Totals --}}
          <div class="row mt-4">
            <div class="col-md-4 ms-auto">
              <ul class="list-group">
                <li class="list-group-item d-flex justify-content-between">
                  <span>Subtotal:</span>
                  <strong id="subtotalDisplay">$0.00</strong>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                  <span>Tax:</span>
                  <strong id="taxDisplay">$0.00</strong>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                  <span>Total:</span>
                  <strong id="totalDisplay">$0.00</strong>
                </li>
              </ul>
            </div>
          </div>
        </div>

        {{-- Footer --}}
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Create Invoice</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script>
document.getElementById('invoice_quote_number').addEventListener('change', function () {
    const quoteNumber = this.value;
    if (!quoteNumber) return;

    fetch(`/sales/quotes/fetch-info/${quoteNumber}`)
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const q = data.data.quote;
                document.getElementById('invoice_customer_number').value = q.customer.customer_number;
                document.getElementById('invoice_customer_name').value = q.customer.customer_name;
                document.getElementById('order_number').value = q.order.order_number ?? '';
                document.getElementById('invoice_number').value = data.data.invoice_number ?? '';

                document.getElementById('billing_address').value = q.customer.billing_address ?? '';
                document.getElementById('billing_city').value = q.customer.billing_city ?? '';
                document.getElementById('billing_state').value = q.customer.billing_state ?? '';
                document.getElementById('billing_zip').value = q.customer.billing_zip ?? '';
                document.getElementById('billing_phone').value = q.customer.phone ?? '';
                document.getElementById('billing_email').value = q.customer.email ?? '';

                document.getElementById('delivery_address').value = q.customer.delivery_address ?? '';
                document.getElementById('delivery_city').value = q.customer.delivery_city ?? '';
                document.getElementById('delivery_state').value = q.customer.delivery_state ?? '';
                document.getElementById('delivery_zip').value = q.customer.delivery_zip ?? '';
                document.getElementById('delivery_phone').value = q.customer.phone ?? '';
                document.getElementById('delivery_email').value = q.customer.email ?? '';

                document.getElementById('subtotalDisplay').innerText = `$${parseFloat(q.sub_total || 0).toFixed(2)}`;
                document.getElementById('taxDisplay').innerText = `$${parseFloat(q.tax || 0).toFixed(2)}`;
                document.getElementById('totalDisplay').innerText = `$${parseFloat(q.total || 0).toFixed(2)}`;
            } else {
                alert('Quote not found');
            }
        })
        .catch(err => {
            console.error(err);
            alert('Error fetching quote data');
        });
});
</script>

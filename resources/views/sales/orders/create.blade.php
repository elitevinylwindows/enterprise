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
              <label>Quote Notes</label>
              <textarea name="notes" id="quote_notes" class="form-control" rows="3" readonly></textarea>
            </div>
        </div>

          <hr>
          <div class="row">
            <div class="col-md-6">
              <h6>Billing Information</h6>
              <input type="text" name="billing_address" id="billing_address" class="form-control mb-2" placeholder="Billing Address" readonly>
              <input type="text" name="billing_city" id="billing_city" class="form-control mb-2" placeholder="City" readonly>
              <input type="text" name="billing_state" id="billing_state" class="form-control mb-2" placeholder="State" readonly>
              <input type="text" name="billing_zip" id="billing_zip" class="form-control mb-2" placeholder="ZIP" readonly>
              <input type="text" name="phone" id="customer_phone" class="form-control mb-2" placeholder="Phone" readonly>
              <input type="email" name="email" id="customer_email" class="form-control mb-2" placeholder="Email" readonly>
            </div>
            <div class="col-md-6">
              <h6>Delivery Information</h6>
              <input type="text" name="delivery_address" id="delivery_address" class="form-control mb-2" placeholder="Delivery Address" readonly>
              <input type="text" name="delivery_city" id="delivery_city" class="form-control mb-2" placeholder="City" readonly>
              <input type="text" name="delivery_state" id="delivery_state" class="form-control mb-2" placeholder="State" readonly>
              <input type="text" name="delivery_zip" id="delivery_zip" class="form-control mb-2" placeholder="ZIP" readonly>
              <input type="text" name="phone" id="customer_phone" class="form-control mb-2" placeholder="Phone" readonly>
              <input type="email" name="email" id="customer_email" class="form-control mb-2" placeholder="Email" readonly>
            </div>
 </div>

 <div class="row mt-4">
    <div class="col-md-6 offset-md-6">
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

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Create Order</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </div>
    </form>
  </div>
</div>


<script>
document.getElementById('quote_number').addEventListener('change', function () {
    const quoteNumber = this.value;
    if (!quoteNumber) return;

    fetch(`/sales/quotes/fetch-info/${quoteNumber}`)
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const q = data.quote;
                document.getElementById('order_number').value = q.generated_order_number ?? '';
                document.getElementById('customer_number').value = q.customer.customer_number;
                document.getElementById('customer_name').value = q.customer.customer_name;
                document.getElementById('customer_phone').value = q.customer.phone;
                document.getElementById('customer_email').value = q.customer.email;
                document.getElementById('billing_address').value = q.customer.billing_address;
                document.getElementById('billing_city').value = q.customer.billing_city;
                document.getElementById('billing_state').value = q.customer.billing_state;
                document.getElementById('billing_zip').value = q.customer.billing_zip;
                document.getElementById('quote_notes').value = q.notes ?? '';
                document.getElementById('total_qty').value = q.total_qty ?? 0;
                document.getElementById('subtotal').value = `$${q.subtotal ?? 0}`;
                document.getElementById('total').value = `$${q.total ?? 0}`;
            } else {
                alert('Quote not found');
            }
        })
        .catch(err => {
            console.error(err);
            alert('Error fetching quote');
        });
});
</script>

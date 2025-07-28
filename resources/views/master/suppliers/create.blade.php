<!-- Create Supplier Modal -->
<div class="modal fade" id="addSupplierModal" tabindex="-1" aria-labelledby="addSupplierModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form method="POST" action="{{ route('master.suppliers.store') }}">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addSupplierModalLabel">Add Supplier</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body row g-3">
            <div class="col-md-12">
    <label class="form-label">Supplier Type</label><br>
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="supplier_type" id="individual" value="individual" checked>
        <label class="form-check-label" for="individual">Individual</label>
    </div>
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="supplier_type" id="organization" value="organization">
        <label class="form-check-label" for="organization">Organization</label>
    </div>
</div>

          <div class="col-md-6">
            <label>Supplier Number</label>
            <input type="text" name="supplier_number" class="form-control" required>
          </div>
          
          <div class="col-md-6">
            <label>Name</label>
            <input type="text" name="name" class="form-control" required>
          </div>
          <div class="col-md-6">
            <label>Street</label>
            <input type="text" name="street" class="form-control">
          </div>
          <div class="col-md-6">
            <label>City</label>
            <input type="text" name="city" class="form-control">
          </div>
          <div class="col-md-4">
            <label>ZIP</label>
            <input type="text" name="zip" class="form-control">
          </div>
          <div class="col-md-4">
            <label>Country</label>
            <input type="text" name="country" class="form-control">
          </div>
          <div class="col-md-4">
            <label>Status</label>
            <select name="status" class="form-control">
              <option value="active">Active</option>
              <option value="inactive">Inactive</option>
            </select>
          </div>

          <div class="col-md-6">
            <label>Phone</label>
            <input type="text" name="phone" class="form-control">
          </div>
          <div class="col-md-6">
            <label>Website</label>
            <input type="text" name="website" class="form-control">
          </div>
          <div class="col-md-6">
  <label>EIN Number</label>
  <input type="text" name="ein_number" class="form-control">
</div>
<div class="col-md-6">
  <label>License Number</label>
  <input type="text" name="license_number" class="form-control">
</div>
          <div class="col-md-4">
            <label>Supplier Group</label>
            <input type="text" name="supplier_group" class="form-control">
          </div>
          <div class="col-md-4">
            <label>Currency</label>
            <input type="text" name="currency" class="form-control">
          </div>
          <div class="col-md-4">
            <label>Currency Symbol</label>
            <input type="text" name="currency_symbol" class="form-control">
          </div>
          <div class="col-md-6">
            <label>Label</label>
            <input type="text" name="label" class="form-control">
          </div>
          <div class="col-md-6 d-flex align-items-center">
            <div class="form-check mt-4">
              <input class="form-check-input" type="checkbox" name="disable_payment" value="1" id="disable_payment">
              <label class="form-check-label" for="disable_payment">Disable Payment</label>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary" type="submit">Add Supplier</button>
        </div>
      </div>
    </form>
  </div>
</div>

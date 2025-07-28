<!-- Edit Supplier Modal -->
<div class="modal fade" id="editSupplierModal{{ $supplier->id }}" tabindex="-1" aria-labelledby="editSupplierModalLabel{{ $supplier->id }}" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form method="POST" action="{{ route('master.suppliers.update', $supplier->id) }}">
      @csrf
      @method('PUT')
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editSupplierModalLabel{{ $supplier->id }}">Edit Supplier</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body row g-3">
          <div class="col-md-6">
            <label>Supplier Number</label>
            <input type="text" name="supplier_number" value="{{ $supplier->supplier_number }}" class="form-control" required>
          </div>
          <div class="col-md-6">
            <label>Name</label>
            <input type="text" name="name" value="{{ $supplier->name }}" class="form-control" required>
          </div>

          <!-- Supplier Type Radios -->
          <div class="col-md-12">
            <label>Supplier Type</label><br>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="supplier_type" id="individual{{ $supplier->id }}" value="individual" {{ $supplier->supplier_type == 'individual' ? 'checked' : '' }}>
              <label class="form-check-label" for="individual{{ $supplier->id }}">Individual</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="supplier_type" id="organization{{ $supplier->id }}" value="organization" {{ $supplier->supplier_type == 'organization' ? 'checked' : '' }}>
              <label class="form-check-label" for="organization{{ $supplier->id }}">Organization</label>
            </div>
          </div>

          <div class="col-md-6">
            <label>Street</label>
            <input type="text" name="street" value="{{ $supplier->street }}" class="form-control">
          </div>
          <div class="col-md-6">
            <label>City</label>
            <input type="text" name="city" value="{{ $supplier->city }}" class="form-control">
          </div>
          <div class="col-md-4">
            <label>ZIP</label>
            <input type="text" name="zip" value="{{ $supplier->zip }}" class="form-control">
          </div>
          <div class="col-md-4">
            <label>Country</label>
            <input type="text" name="country" value="{{ $supplier->country }}" class="form-control">
          </div>
          <div class="col-md-4">
            <label>Status</label>
            <select name="status" class="form-control">
              <option value="active" {{ $supplier->status == 'active' ? 'selected' : '' }}>Active</option>
              <option value="inactive" {{ $supplier->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
          </div>

          <div class="col-md-6">
            <label>Phone</label>
            <input type="text" name="phone" value="{{ $supplier->phone }}" class="form-control">
          </div>
          <div class="col-md-6">
            <label>Website</label>
            <input type="text" name="website" value="{{ $supplier->website }}" class="form-control">
          </div>

          <div class="col-md-6">
            <label>Client Group</label>
            <input type="text" name="client_group" value="{{ $supplier->client_group }}" class="form-control">
          </div>

          <div class="col-md-3">
            <label>Currency</label>
            <input type="text" name="currency" value="{{ $supplier->currency }}" class="form-control">
          </div>
          <div class="col-md-3">
            <label>Currency Symbol</label>
            <input type="text" name="currency_symbol" value="{{ $supplier->currency_symbol }}" class="form-control">
          </div>

          <div class="col-md-6">
            <label>Label</label>
            <input type="text" name="label" value="{{ $supplier->label }}" class="form-control">
          </div>

          <div class="col-md-3">
            <label>EIN Number</label>
            <input type="text" name="ein_number" value="{{ $supplier->ein_number }}" class="form-control">
          </div>
          <div class="col-md-3">
            <label>License Number</label>
            <input type="text" name="license_number" value="{{ $supplier->license_number }}" class="form-control">
          </div>

          <div class="col-md-6 d-flex align-items-center">
            <div class="form-check mt-4">
              <input class="form-check-input" type="checkbox" name="disable_payment" value="1" id="disable_payment{{ $supplier->id }}" {{ $supplier->disable_payment ? 'checked' : '' }}>
              <label class="form-check-label" for="disable_payment{{ $supplier->id }}">Disable Payment</label>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary" type="submit">Update Supplier</button>
        </div>
      </div>
    </form>
  </div>
</div>

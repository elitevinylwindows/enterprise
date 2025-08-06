<div class="modal fade" id="createTaxCodeModal" tabindex="-1" aria-labelledby="createTaxCodeLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <form method="POST" action="{{ route('master.prices.tax_codes.store') }}" id="taxCodeCreateForm">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Create Tax Code</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <div class="row mb-3">
            <div class="col-md-6">
              <label>Tax Code <span class="text-danger">*</span></label>
              <input type="text" name="code" class="form-control" placeholder="Enter tax code" required>
            </div>
            <div class="col-md-6">
              <label>City</label>
              <input type="text" name="city" class="form-control" placeholder="City (optional)">
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-md-12">
              <label>Description</label>
              <input type="text" name="description" class="form-control" placeholder="Optional description">
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-md-6">
              <label>Rate (%) <span class="text-danger">*</span></label>
              <input type="number" name="rate" class="form-control" placeholder="e.g. 8.25" step="0.01" required>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Create Tax Code</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </div>
    </form>
  </div>
</div>

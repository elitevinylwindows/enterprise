<div class="modal fade" id="editTaxCodeModal{{ $taxCode->id }}" tabindex="-1" aria-labelledby="editTaxCodeLabel{{ $taxCode->id }}" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <form method="POST" action="{{ route('master.prices.tax_codes.update', $taxCode->id) }}" id="taxCodeEditForm{{ $taxCode->id }}">
      @csrf
      @method('PUT')
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Tax Code</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <div class="row mb-3">
            <div class="col-md-6">
              <label>Tax Code <span class="text-danger">*</span></label>
              <input type="text" name="code" class="form-control" value="{{ $taxCode->code }}" required>
            </div>
            <div class="col-md-6">
              <label>City</label>
              <input type="text" name="city" class="form-control" value="{{ $taxCode->city }}">
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-md-12">
              <label>Description</label>
              <input type="text" name="description" class="form-control" value="{{ $taxCode->description }}">
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-md-6">
              <label>Rate (%) <span class="text-danger">*</span></label>
              <input type="number" name="rate" class="form-control" step="0.01" value="{{ $taxCode->rate }}" required>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Update</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </div>
    </form>
  </div>
</div>

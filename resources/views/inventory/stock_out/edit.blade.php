<div class="modal fade" id="editStockOutModal" tabindex="-1" aria-labelledby="editStockOutLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <form method="POST" action="{{ route('inventory.stock-out.update', $stockOut->id) }}">
      @csrf
      @method('PUT')
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Stock Out</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <div class="row mb-3">
            <div class="col-md-4">
              <label>Date</label>
              <input type="date" name="issued_date" class="form-control" value="{{ $stockOut->issued_date }}">
            </div>
            <div class="col-md-4">
              <label>Issued To</label>
              <input type="text" name="issued_to" class="form-control" value="{{ $stockOut->issued_to }}">
            </div>
            <div class="col-md-4">
              <label>Reference</label>
              <input type="text" name="reference" class="form-control" value="{{ $stockOut->reference }}">
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-md-4">
              <label>Location</label>
              <select name="location_id" class="form-control select2">
                @foreach ($locations as $id => $name)
                  <option value="{{ $id }}" {{ $stockOut->location_id == $id ? 'selected' : '' }}>{{ $name }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-4">
              <label>Product</label>
              <select name="product_id" class="form-control select2">
                @foreach ($products as $id => $name)
                  <option value="{{ $id }}" {{ $stockOut->product_id == $id ? 'selected' : '' }}>{{ $name }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-4">
              <label>Quantity</label>
              <input type="number" name="quantity" class="form-control" value="{{ $stockOut->quantity }}" required>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-md-6">
              <label>Status</label>
              <select name="status" class="form-control">
                <option value="pending" {{ $stockOut->status == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="issued" {{ $stockOut->status == 'issued' ? 'selected' : '' }}>Issued</option>
              </select>
            </div>
            <div class="col-md-6">
              <label>Note</label>
              <textarea name="note" class="form-control" rows="2">{{ $stockOut->note }}</textarea>
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

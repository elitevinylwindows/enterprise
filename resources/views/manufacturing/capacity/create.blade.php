<!-- Capacity Create Modal -->
<div class="modal fade" id="createCapacityModal" tabindex="-1" aria-labelledby="createCapacityLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <form method="POST" action="{{ route('manufacturing.capacity.store') }}" id="capacityCreateForm">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Create Capacity Row</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          {{-- Row 1 --}}
          <div class="row mb-3">
            <div class="col-md-6">
              <label>Description</label>
              <input type="text" name="description" class="form-control" placeholder="e.g., IG Line per shift" required>
            </div>
            <div class="col-md-3">
              <label>Limit</label>
              <input type="number" name="limit" class="form-control" min="0" step="1" value="0" required>
            </div>
            <div class="col-md-3">
              <label>Actual</label>
              <input type="number" name="actual" class="form-control" min="0" step="1" value="0" required>
            </div>
          </div>

          {{-- Live % (optional) --}}
          <div class="row">
            <div class="col-md-12">
              <small class="text-muted">Percentage is calculated automatically in the list view.</small>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Create Capacity</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </div>
    </form>
  </div>
</div>


    <form method="POST" action="{{ route('manufacturing.stations.store') }}" id="stationCreateForm">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Create Station</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          {{-- Row 1 --}}
          <div class="row mb-3">
            <div class="col-md-4">
              <label>Station #</label>
              <input type="text" name="station_number" class="form-control" placeholder="e.g., ST-01" required>
            </div>
            <div class="col-md-4">
              <label>Status</label>
              <select name="status" class="form-control" required>
                <option value="active" selected>Active</option>
                <option value="inactive">Inactive</option>
              </select>
            </div>
            <div class="col-md-4 d-flex align-items-end">
              <small class="text-muted">Station numbers are unique.</small>
            </div>
          </div>

          {{-- Row 2 --}}
          <div class="row">
            <div class="col-md-12">
              <label>Description</label>
              <textarea name="description" rows="3" class="form-control" placeholder="Brief description (e.g., Cutting station with 3 saws)"></textarea>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Create Station</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </div>
    </form>
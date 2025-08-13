<form method="POST" action="{{ route('manufacturing.stations.store') }}" id="stationCreateForm">
  @csrf

  <div class="px-4 pt-3">  {{-- adds horizontal + top padding inside modal --}}
    <div class="row g-3 align-items-end">  {{-- g-3 = column gutters --}}
      <div class="col-md-6">
        <label class="form-label">Station #</label>
        <input type="text" name="station_number" class="form-control" placeholder="e.g., ST-01" required>
      </div>
      <div class="col-md-4">
        <label class="form-label">Status</label>
        <select name="status" class="form-select" required>
          <option value="active" selected>Active</option>
          <option value="inactive">Inactive</option>
        </select>
      </div>
      <div class="col-md-2 d-flex align-items-end">
        <small class="text-muted">Station numbers are unique.</small>
      </div>
    </div>

    <div class="row g-3 mt-2">
      <div class="col-12">
        <label class="form-label">Description</label>
        <textarea name="description" rows="3" class="form-control" placeholder="Brief description"></textarea>
      </div>
    </div>
  </div>

  <div class="modal-footer px-4">
    <button type="submit" class="btn btn-primary">Create Station</button>
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
  </div>
</form>

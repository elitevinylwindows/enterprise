<form method="POST" action="{{ route('manufacturing.stations.store') }}" id="stationCreateForm">
  @csrf
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

  <div class="row">
    <div class="col-md-12">
      <label>Description</label>
      <textarea name="description" rows="3" class="form-control" placeholder="Brief description"></textarea>
    </div>
  </div>

  <div class="modal-footer px-0">
    <button type="submit" class="btn btn-primary">Create Station</button>
  </div>
</form>

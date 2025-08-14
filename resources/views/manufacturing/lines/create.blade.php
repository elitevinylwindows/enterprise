{{-- resources/views/manufacturing/stations/create.blade.php --}}
<form method="POST" action="{{ route('manufacturing.stations.store') }}" id="stationCreateForm">
  @csrf

  <div class="px-4 pt-3"> {{-- adds horizontal + top padding inside modal --}}
    <div class="row g-3 align-items-end"> {{-- g-3 = column gutters --}}
      <div class="col-md-6">
        <label class="form-label">Station #</label>
        <input type="text"
               name="station_number"
               class="form-control @error('station_number') is-invalid @enderror"
               placeholder="e.g., ST-01"
               value="{{ old('station_number') }}"
               required>
        @error('station_number')
          <div class="invalid-feedback">{{ $message }}</div>
        @else
          <div class="form-text">Station numbers are unique.</div>
        @enderror
      </div>

      <div class="col-md-4">
        <label class="form-label">Status</label>
        <select name="status"
                class="form-select @error('status') is-invalid @enderror"
                required>
          <option value="active"   {{ old('status','active') === 'active' ? 'selected' : '' }}>Active</option>
          <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
        </select>
        @error('status')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="col-md-2 d-none d-md-flex align-items-end">
        <small class="text-muted"> </small>
      </div>
    </div>

    <div class="row g-3 mt-2">
      <div class="col-12">
        <label class="form-label">Description</label>
        <textarea name="description"
                  rows="3"
                  class="form-control @error('description') is-invalid @enderror"
                  placeholder="Brief description">{{ old('description') }}</textarea>
        @error('description')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>
    </div>
  </div>

  <div class="modal-footer px-4">
    <button type="submit" class="btn btn-primary">Create Station</button>
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
  </div>
</form>

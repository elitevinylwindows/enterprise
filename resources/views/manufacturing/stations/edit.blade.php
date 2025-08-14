{{-- resources/views/manufacturing/stations/edit.blade.php --}}
{{-- Modal PARTIAL: Edit Station --}}
<form method="POST" action="{{ route('manufacturing.stations.update', $station->id) }}" id="stationEditForm">
  @csrf
  @method('PUT')

  <div class="row gy-3 px-1 px-md-2">
    <div class="col-md-4">
      <label class="form-label">{{ __('Station #') }}</label>
      <input type="text"
             name="station"
             class="form-control"
             value="{{ old('station', $station->station) }}"
             required>
      @error('station') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-4">
      <label class="form-label">{{ __('Status') }}</label>
      <select name="status" class="form-control" required>
        <option value="active"   {{ old('status', $station->status) === 'active' ? 'selected' : '' }}>{{ __('Active') }}</option>
        <option value="inactive" {{ old('status', $station->status) === 'inactive' ? 'selected' : '' }}>{{ __('Inactive') }}</option>
      </select>
      @error('status') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-12">
      <label class="form-label">{{ __('Description') }}</label>
      <textarea name="description" rows="3" class="form-control">{{ old('description', $station->description) }}</textarea>
      @error('description') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>
  </div>

  <div class="mt-4 d-flex justify-content-end gap-2">
    <button type="submit" class="btn btn-primary">{{ __('Save Changes') }}</button>
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
  </div>
</form>

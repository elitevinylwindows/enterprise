<form action="{{ route('master.series-type.update', $seriesType->id) }}" method="POST">
  @csrf
  @method('PUT')

  <div class="modal-header">
    <h5 class="modal-title">{{ __('Edit Series Type') }}</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
  </div>

  <div class="modal-body">
    {{-- Series --}}
    <div class="mb-3">
      <label class="form-label" for="series_id">{{ __('Series') }}</label>
      <select name="series_id" id="series_id"
              class="form-control @error('series_id') is-invalid @enderror" required>
        @foreach($series as $s)
          <option value="{{ $s->id }}" @selected(old('series_id', $seriesType->series_id) == $s->id)>
            {{ $s->series }}
          </option>
        @endforeach
      </select>
      @error('series_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    {{-- Series Type --}}
    <div class="mb-3">
      <label class="form-label" for="series_type">{{ __('Series Type') }}</label>
      <input type="text" name="series_type" id="series_type"
             class="form-control @error('series_type') is-invalid @enderror"
             value="{{ old('series_type', $seriesType->series_type) }}" required>
      @error('series_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
  </div>

  <div class="modal-footer">
    <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
  </div>
</form>

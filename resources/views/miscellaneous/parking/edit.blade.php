<form method="POST" action="{{ route('misc.parking.update', $assignment->id) }}" id="parkingEditForm">
  @csrf
  @method('PUT')

  <div class="modal-body">
    <div class="mb-3">
      <label class="form-label">{{ __('User') }}</label>
      <select name="user_id" class="form-select @error('user_id') is-invalid @enderror">
        <option value="">{{ __('— Unassigned —') }}</option>
        @foreach($users as $u)
          <option value="{{ $u->id }}" {{ (old('user_id', $assignment->user_id) == $u->id) ? 'selected' : '' }}>
            {{ $u->name }} @if($u->email) — {{ $u->email }} @endif
          </option>
        @endforeach
      </select>
      @error('user_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
      <div class="form-text">{{ __('Pick who this spot is assigned to (or leave Unassigned).') }}</div>
    </div>

    <div class="mb-3">
      <label class="form-label">{{ __('Spot') }}</label>
      <input type="number" min="1" max="50" name="spot"
             class="form-control @error('spot') is-invalid @enderror"
             value="{{ old('spot', $assignment->spot) }}" required>
      @error('spot') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="mb-3 form-check">
      {{-- Ensure value always posts (0/1) --}}
      <input type="hidden" name="wheelchair" value="0">
      <input type="checkbox"
             class="form-check-input"
             id="wheelchair"
             name="wheelchair"
             value="1"
             {{ old('wheelchair', $assignment->wheelchair) ? 'checked' : '' }}>
      <label class="form-check-label" for="wheelchair">{{ __('Wheelchair / Accessible') }}</label>
    </div>

    <div class="mb-3">
      <label class="form-label">{{ __('Notes') }}</label>
      <textarea name="notes" rows="3" class="form-control @error('notes') is-invalid @enderror">{{ old('notes', $assignment->notes) }}</textarea>
      @error('notes') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
  </div>

  <div class="modal-footer">
    <button type="submit" class="btn btn-primary">{{ __('Save Changes') }}</button>
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
  </div>
</form>

<form method="POST" action="{{ route('misc.parking.update', $assignment->id) }}" id="parkingEditForm">
  @csrf
  @method('PUT')

  <div class="modal-header">
    <h5 class="modal-title">{{ __('Edit Parking') }}</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('Close') }}"></button>
  </div>

  <div class="modal-body">
    <div class="mb-3">
      <label class="form-label">{{ __('User') }}</label>
      <select name="user_id" class="form-select @error('user_id') is-invalid @enderror" required>
        @foreach($users as $u)
          <option value="{{ $u->id }}" {{ (old('user_id', $assignment->user_id) == $u->id) ? 'selected' : '' }}>
            {{ $u->name }} @if($u->email) — {{ $u->email }} @endif
          </option>
        @endforeach
      </select>
      @error('user_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
      <div class="form-text">{{ __('Change who this spot is assigned to, if needed.') }}</div>
    </div>

    <div class="mb-3">
      <label class="form-label">{{ __('Spot') }}</label>
      <input type="text" name="spot" class="form-control @error('spot') is-invalid @enderror"
             value="{{ old('spot', $assignment->spot) }}" required>
      @error('spot') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="mb-3">
      <label class="form-label">{{ __('Notes') }}</label>
      <textarea name="notes" rows="3" class="form-control @error('notes') is-invalid @enderror"
      >{{ old('notes', $assignment->notes) }}</textarea>
      @error('notes') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
  </div>

  <div class="modal-footer">
    <button type="submit" class="btn btn-primary">{{ __('Save Changes') }}</button>
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
  </div>
</form>

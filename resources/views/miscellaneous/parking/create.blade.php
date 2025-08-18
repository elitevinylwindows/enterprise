<form method="POST" action="{{ route('misc.parking.store') }}" id="parkingCreateForm">
  @csrf

  <div class="modal-header">
    <h5 class="modal-title">{{ __('Assign Parking') }}</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('Close') }}"></button>
  </div>

  <div class="modal-body">
    <div class="mb-3">
      <label class="form-label">{{ __('User') }}</label>
      <select name="user_id" class="form-select @error('user_id') is-invalid @enderror" required>
        <option value="" disabled selected>{{ __('Select a user…') }}</option>
        @foreach($users as $u)
          <option value="{{ $u->id }}">{{ $u->name }} @if($u->email) — {{ $u->email }} @endif</option>
        @endforeach
      </select>
      @error('user_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
      <div class="form-text">{{ __('Only users without a current spot are listed.') }}</div>
    </div>

    <div class="mb-3">
      <label class="form-label">{{ __('Spot') }}</label>
      <input type="text" name="spot" class="form-control @error('spot') is-invalid @enderror"
             placeholder="e.g., A-12" required>
      @error('spot') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="mb-3">
      <label class="form-label">{{ __('Notes') }} <span class="text-muted small">({{ __('optional') }})</span></label>
      <textarea name="notes" rows="3" class="form-control @error('notes') is-invalid @enderror"
                placeholder="{{ __('Any extra info') }}"></textarea>
      @error('notes') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
  </div>

  <div class="modal-footer">
    <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
  </div>
</form>

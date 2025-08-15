{{-- resources/views/manufacturing/machines/create.blade.php --}}
<form method="POST" action="{{ route('manufacturing.machines.store') }}" id="machineCreateForm">
  @csrf

  <div class="px-4 pt-3"> {{-- adds horizontal + top padding inside modal --}}
    <div class="row g-3 align-items-end"> {{-- g-3 = column gutters --}}
      <div class="col-md-6">
        <label class="form-label">{{ __('Machine') }}</label>
        <input type="text"
               name="machine"
               class="form-control @error('machine') is-invalid @enderror"
               placeholder="{{ __('e.g., Bottero 352 Glass Cutter') }}"
               value="{{ old('machine') }}"
               required>
        @error('machine')
          <div class="invalid-feedback">{{ $message }}</div>
        @else
          <div class="form-text">{{ __('Machine names are unique.') }}</div>
        @enderror
      </div>

      <div class="col-md-4">
        <label class="form-label">{{ __('File Type') }}</label>
        <select name="file_type"
                class="form-select @error('file_type') is-invalid @enderror"
                required>
          @php($types = ['csv' => 'CSV', 'xml' => 'XML', 'other' => 'Other'])
          @foreach ($types as $v => $l)
            <option value="{{ $v }}" {{ old('file_type') === $v ? 'selected' : '' }}>{{ $l }}</option>
          @endforeach
        </select>
        @error('file_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>

      <div class="col-md-2 d-none d-md-flex align-items-end">
        <small class="text-muted">&nbsp;</small>
      </div>
    </div>

    <div class="row g-3 mt-2">
      <div class="col-6">
        <label class="form-label">{{ __('Description') }} <span class="text-muted small">({{ __('optional') }})</span></label>
        <textarea name="description"
                  rows="3"
                  class="form-control @error('description') is-invalid @enderror"
                  placeholder="{{ __('Optional notes or capabilities') }}">{{ old('description') }}</textarea>
        @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
        <div class="form-text">{{ __('Attach configuration formats this machine accepts via “File Type”.') }}</div>
      </div>
    </div>
  </div>

  <div class="modal-footer px-4">
    <button type="submit" class="btn btn-primary">{{ __('Create Machine') }}</button>
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
  </div>
</form>

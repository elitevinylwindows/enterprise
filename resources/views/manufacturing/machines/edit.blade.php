{{-- resources/views/manufacturing/machines/edit.blade.php --}}
<form method="POST" action="{{ route('manufacturing.machines.update', $machine->id) }}" id="machineEditForm">
  @csrf
  @method('PUT')

  <div class="px-4 pt-3">
    {{-- Row 1: Machine + File Type (aligned) --}}
    <div class="row g-3">
      <div class="col-md-6">
        <label class="form-label">{{ __('Machine') }}</label>
        <input type="text"
               name="machine"
               class="form-control @error('machine') is-invalid @enderror"
               placeholder="{{ __('e.g., Bottero 352 Glass Cutter') }}"
               value="{{ old('machine', $machine->machine) }}"
               required>
        @error('machine')
          <div class="invalid-feedback">{{ $message }}</div>
        @else
          <div class="form-text help-spacer">{{ __('Machine names are unique.') }}</div>
        @enderror
      </div>

      <div class="col-md-6">
        <label class="form-label">{{ __('File Type') }}</label>
        <select name="file_type"
                class="form-select @error('file_type') is-invalid @enderror"
                required>
          @php($types = ['csv' => 'CSV', 'xml' => 'XML', 'other' => 'Other'])
          @foreach ($types as $v => $l)
            <option value="{{ $v }}" {{ old('file_type', $machine->file_type) === $v ? 'selected' : '' }}>
              {{ $l }}
            </option>
          @endforeach
        </select>
        @error('file_type')
          <div class="invalid-feedback">{{ $message }}</div>
        @else
          <div class="form-text help-spacer">&nbsp;</div>
        @enderror
      </div>
    </div>

    {{-- Row 2: File Path (left) + Description (right) --}}
    <div class="row g-3 mt-1">
      <div class="col-md-6">
        <label class="form-label">{{ __('File Path') }}</label>
        <input type="text"
               name="file_path"
               id="file_path"
               class="form-control @error('file_path') is-invalid @enderror"
               placeholder="{{ __('e.g., C:\\Machines\\Bottero or \\\\SERVER\\share\\machines\\bottero') }}"
               value="{{ old('file_path', $machine->file_path) }}">
        @error('file_path') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
        <div class="form-text">
          {{ __('Store a local or network path. No files are uploaded from this field.') }}
        </div>
      </div>

      <div class="col-md-6">
        <label class="form-label">
          {{ __('Description') }} <span class="text-muted small">({{ __('optional') }})</span>
        </label>
        <textarea name="description"
                  rows="3"
                  class="form-control @error('description') is-invalid @enderror"
                  placeholder="{{ __('Optional notes or capabilities') }}">{{ old('description', $machine->description) }}</textarea>
        @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>
    </div>
  </div>

  <div class="modal-footer px-4">
    <button type="submit" class="btn btn-primary">{{ __('Save Changes') }}</button>
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
  </div>
</form>

<style>
  /* keeps the helper rows same height so row 2 doesn’t shift */
  .help-spacer{ min-height: 22px; }
</style>

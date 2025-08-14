<form method="POST" action="{{ route('color-options.status-colors.update', $status_color->id) }}" id="statusColorEditForm">
  @csrf
  @method('PUT')

  <div class="px-4 pt-3">
    <div class="row g-3">
      <div class="col-md-4">
        <label class="form-label">{{ __('Color') }}</label>
        <input type="color"
               id="color_picker_edit"
               class="form-control form-control-color @error('color_code') is-invalid @enderror"
               value="{{ old('color_code', $status_color->color_code ?: '#C71F1F') }}"
               title="{{ __('Choose color') }}">
        @error('color_code') <div class="invalid-feedback">{{ $message }}</div> @enderror
        <div class="form-text">{{ __('Use the wheel, or type HEX below.') }}</div>
      </div>

      <div class="col-md-4">
        <label class="form-label">{{ __('HEX') }}</label>
        <input type="text"
               name="color_code"
               id="color_hex_edit"
               class="form-control @error('color_code') is-invalid @enderror"
               value="{{ old('color_code', $status_color->color_code) }}"
               placeholder="#RRGGBB"
               pattern="^#?[0-9A-Fa-f]{6}$"
               required>
        @error('color_code') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>

      <div class="col-md-4">
        <label class="form-label">{{ __('Department') }}</label>
        <input type="text"
               name="department"
               class="form-control @error('department') is-invalid @enderror"
               value="{{ old('department', $status_color->department) }}"
               required>
        @error('department') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>

      <div class="col-12">
        <label class="form-label">{{ __('Status (free text)') }}</label>
        <input type="text"
               name="status"
               class="form-control @error('status') is-invalid @enderror"
               value="{{ old('status', $status_color->status) }}"
               required>
        @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>
    </div>
  </div>

  <div class="modal-footer px-4">
    <button type="submit" class="btn btn-primary">{{ __('Save Changes') }}</button>
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
  </div>
</form>

<script>
(() => {
  const pick = document.getElementById('color_picker_edit');
  const hex  = document.getElementById('color_hex_edit');
  if (!pick || !hex) return;
  const toHex = v => (v.startsWith('#') ? v : '#'+v).toUpperCase();
  pick.addEventListener('input', () => { hex.value = pick.value.toUpperCase(); });
  hex.addEventListener('input', () => { const v = hex.value.trim(); if (/^#?[0-9A-Fa-f]{6}$/.test(v)) pick.value = toHex(v); });
})();
</script>

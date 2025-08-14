{{-- Modal PARTIAL: Create Capacity --}}
<form method="POST" action="{{ route('manufacturing.capacity.store') }}" id="capacityCreateForm">
  @csrf

  <div class="px-4 pt-3">
    <div class="row g-3">
      <div class="col-md-6">
        <label class="form-label">{{ __('Description') }}</label>
        <input type="text"
               name="description"
               class="form-control @error('description') is-invalid @enderror"
               placeholder="{{ __('e.g., Daily Glass Cutting') }}"
               value="{{ old('description') }}"
               required>
        @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>

      <div class="col-md-3">
        <label class="form-label">{{ __('Limit') }}</label>
        <input type="number"
               step="0.01"
               min="0"
               name="limit"
               id="cap_limit"
               class="form-control @error('limit') is-invalid @enderror"
               value="{{ old('limit') }}"
               required>
        @error('limit') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>

      <div class="col-md-3">
        <label class="form-label">{{ __('Actual') }}</label>
        <input type="number"
               step="0.01"
               min="0"
               name="actual"
               id="cap_actual"
               class="form-control @error('actual') is-invalid @enderror"
               value="{{ old('actual') }}"
               required>
        @error('actual') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>

      <div class="col-md-3">
        <label class="form-label">{{ __('Percentage') }}</label>
        <div class="input-group">
          <input type="number"
                 step="0.01"
                 min="0"
                 name="percentage"
                 id="cap_percentage"
                 class="form-control @error('percentage') is-invalid @enderror"
                 value="{{ old('percentage') }}"
                 placeholder="0.00">
          <span class="input-group-text">%</span>
        </div>
        <div class="form-text">{{ __('Auto-calculated from Actual / Limit (editable)') }}</div>
        @error('percentage') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
      </div>
    </div>
  </div>

  <div class="modal-footer px-4">
    <button type="submit" class="btn btn-primary">{{ __('Create') }}</button>
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
  </div>
</form>

{{-- Local auto-calc (safe inside AJAX modal) --}}
<script>
(function(){
  const limitEl = document.getElementById('cap_limit');
  const actualEl = document.getElementById('cap_actual');
  const pctEl   = document.getElementById('cap_percentage');

  function recalc() {
    const lim = parseFloat(limitEl.value);
    const act = parseFloat(actualEl.value);
    if (!isFinite(lim) || lim <= 0 || !isFinite(act)) return;
    const pct = (act / lim) * 100;
    if (!pctEl.matches(':focus')) pctEl.value = pct.toFixed(2);
  }
  ['input','change'].forEach(evt => {
    limitEl.addEventListener(evt, recalc);
    actualEl.addEventListener(evt, recalc);
  });
})();
</script>

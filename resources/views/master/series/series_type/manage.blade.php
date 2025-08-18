{{-- resources/views/master/series/series_type/manage.blade.php --}}
<form method="POST" action="{{ route('master.series-type.manage.update', $series->id) }}">
  @csrf
  @method('PUT')

  <div class="modal-body">
    {{-- Search + Select All row --}}
    <div class="d-flex flex-column flex-sm-row gap-2 align-items-sm-center mb-2">
      <input type="text" class="form-control form-control-sm" id="cfgSearchManage"
             placeholder="{{ __('Search configurations…') }}">
      <div class="ms-sm-auto d-flex gap-2">
        <button type="button" class="btn btn-sm btn-outline-secondary" id="btnSelectAll">
          {{ __('Select All') }}
        </button>
        <button type="button" class="btn btn-sm btn-outline-secondary" id="btnClearAll">
          {{ __('Clear All') }}
        </button>
      </div>
    </div>

    {{-- Checkboxes --}}
    <div id="cfgListManage" class="border rounded p-2" style="max-height: 360px; overflow: auto;">
      @forelse($configs as $cfg)
        @php
          $label = trim($cfg->series_type);
          $checked = in_array($label, $chosenLabels, true);
        @endphp
        <label class="d-flex align-items-center gap-2 py-1 cfg-item">
          <input type="checkbox" name="config_ids[]" value="{{ $cfg->id }}" {{ $checked ? 'checked' : '' }}>
          <span class="small"><strong>{{ $label }}</strong></span>
        </label>
      @empty
        <div class="text-muted small py-2">{{ __('No configurations available for this series.') }}</div>
      @endforelse
    </div>

    @error('config_ids')   <div class="text-danger small mt-2">{{ $message }}</div> @enderror
    @error('config_ids.*') <div class="text-danger small">{{ $message }}</div> @enderror
    <div class="form-text mt-1">{{ __('Tick configurations to keep. Unticked ones (from this list) will be removed for this series.') }}</div>
  </div>

  <div class="modal-footer">
    <button type="submit" class="btn btn-primary">{{ __('Save Changes') }}</button>
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
  </div>
</form>

<script>
(() => {
  const search = document.getElementById('cfgSearchManage');
  const list   = document.getElementById('cfgListManage');
  const selectAllBtn = document.getElementById('btnSelectAll');
  const clearAllBtn  = document.getElementById('btnClearAll');

  if (search && list) {
    search.addEventListener('input', () => {
      const term = search.value.trim().toLowerCase();
      list.querySelectorAll('.cfg-item').forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(term) ? '' : 'none';
      });
    });
  }

  selectAllBtn?.addEventListener('click', () => {
    list.querySelectorAll('input[type="checkbox"]').forEach(chk => { chk.checked = true; });
  });
  clearAllBtn?.addEventListener('click', () => {
    list.querySelectorAll('input[type="checkbox"]').forEach(chk => { chk.checked = false; });
  });
})();
</script>

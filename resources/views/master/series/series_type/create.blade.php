<form action="{{ route('master.series-type.store') }}" method="POST">
  @csrf

  <div class="modal-header">
    <h5 class="modal-title">{{ __('Add Series Types') }}</h5>
  </div>

  <div class="modal-body">

    {{-- Series --}}
    <div class="mb-3">
      <label class="form-label" for="series_id">{{ __('Series') }}</label>
      <select name="series_id" id="series_id"
              class="form-control @error('series_id') is-invalid @enderror"
              data-configs-url="{{ route('master.series-type.configs', ['series' => '__ID__']) }}"
              required>
        <option value="" disabled selected>{{ __('Select series…') }}</option>
        @foreach($series as $s)
          <option value="{{ $s->id }}">{{ $s->series }}</option>
        @endforeach
      </select>
      @error('series_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
      <div class="form-text">{{ __('Choose a series to load its configurations.') }}</div>
    </div>

    {{-- Configurations (multi) --}}
    <div class="mb-2">
      <div class="d-flex align-items-center justify-content-between">
        <label class="form-label mb-0">{{ __('Available Configurations') }}</label>
        <div class="d-flex gap-2">
          <button type="button" class="btn btn-sm btn-outline-secondary" id="cfgSelectAll">{{ __('Select all') }}</button>
          <button type="button" class="btn btn-sm btn-outline-secondary" id="cfgClearAll">{{ __('Clear') }}</button>
        </div>
      </div>

      <input type="text" class="form-control form-control-sm my-2" id="cfgSearchCreate"
             placeholder="{{ __('Search configurations…') }}" disabled>

      <div id="cfgListCreate" class="border rounded p-2 bg-light"
           style="max-height: 260px; overflow: auto;">
        <div class="text-muted small py-2">{{ __('Select a series to load configurations…') }}</div>
      </div>
      @error('config_ids') <div class="text-danger small">{{ $message }}</div> @enderror
      @error('config_ids.*') <div class="text-danger small">{{ $message }}</div> @enderror
      <div class="form-text">{{ __('Tick one or more configurations.') }}</div>
    </div>

    {{-- Selected preview (read-only) --}}
    <div class="mb-3">
      <label class="form-label mb-1">{{ __('Selected Series Types') }}</label>
      <div id="selectedChips" class="d-flex flex-wrap gap-1"></div>
    </div>

    {{-- Optional custom series type --}}
    <div class="mb-1">
      <label class="form-label" for="series_type_custom">{{ __('Custom Series Type (optional)') }}</label>
      <input type="text" name="series_type_custom" id="series_type_custom"
             class="form-control @error('series_type_custom') is-invalid @enderror"
             placeholder="e.g., XO, PW6-32">
      @error('series_type_custom') <div class="invalid-feedback">{{ $message }}</div> @enderror
      <div class="form-text">{{ __('If entered, this will also be created for the selected series.') }}</div>
    </div>

  </div>

  <div class="modal-footer">
    <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
  </div>
</form>

<script>
(() => {
  const seriesSel   = document.getElementById('series_id');
  const listBox     = document.getElementById('cfgListCreate');
  const searchInput = document.getElementById('cfgSearchCreate');
  const btnAll      = document.getElementById('cfgSelectAll');
  const btnClear    = document.getElementById('cfgClearAll');
  const chips       = document.getElementById('selectedChips');

  function rebuildChips(){
    const rows = listBox.querySelectorAll('.config-row .cfg-check:checked');
    const names = Array.from(rows).map(chk => chk.getAttribute('data-label'));
    chips.innerHTML = names.length
      ? names.map(n => `<span class="badge bg-primary-subtle text-primary border">${n}</span>`).join(' ')
      : `<span class="text-muted small">{{ __('None selected') }}</span>`;
  }

  function render(items){
    if(!items || !items.length){
      listBox.innerHTML = '<div class="text-muted small py-2">{{ __('No configurations found for this series.') }}</div>';
      rebuildChips();
      return;
    }
    const html = items.map(it => `
      <label class="d-flex align-items-center gap-2 py-1 px-1 bg-white rounded mb-1 config-row"
             style="cursor:pointer;border:1px solid rgba(0,0,0,.06)">
        <input type="checkbox" class="cfg-check" name="config_ids[]" value="${it.id}" data-label="${it.label}">
        <span class="small"><strong>${it.label}</strong></span>
      </label>
    `).join('');
    listBox.innerHTML = html;

    listBox.querySelectorAll('.cfg-check').forEach(chk => {
      chk.addEventListener('change', rebuildChips);
    });
    rebuildChips();
  }

  function enableSearch(){
    searchInput.disabled = false;
    searchInput.value = '';
    searchInput.oninput = () => {
      const term = searchInput.value.trim().toLowerCase();
      listBox.querySelectorAll('.config-row').forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(term) ? '' : 'none';
      });
    };
  }

  btnAll.addEventListener('click', () => {
    listBox.querySelectorAll('.config-row .cfg-check').forEach(chk => {
      if (chk.closest('.config-row').style.display !== 'none') chk.checked = true;
    });
    rebuildChips();
  });

  btnClear.addEventListener('click', () => {
    listBox.querySelectorAll('.cfg-check').forEach(chk => chk.checked = false);
    rebuildChips();
  });

  seriesSel?.addEventListener('change', () => {
    const tmpl = seriesSel.getAttribute('data-configs-url');
    const url  = tmpl.replace('__ID__', encodeURIComponent(seriesSel.value));

    listBox.innerHTML = '<div class="text-muted small py-2">{{ __('Loading…') }}</div>';
    searchInput.disabled = true;

    fetch(url, { headers: { 'Accept': 'application/json' } })
      .then(r => r.json())
      .then(j => { render(j?.data || []); enableSearch(); })
      .catch(() => { listBox.innerHTML = '<div class="text-danger small py-2">{{ __('Error loading configurations.') }}</div>'; });
  });
})();
</script>

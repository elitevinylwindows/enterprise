{{-- resources/views/master/series/series_type/edit.blade.php --}}
<form method="POST" action="{{ route('master.series-type.update', $seriesType->id) }}">
  @csrf
  @method('PUT')

  <div class="modal-body">
    {{-- Series --}}
    <div class="mb-3">
      <label class="form-label" for="series_id">{{ __('Series') }}</label>
      <select name="series_id" id="series_id"
              class="form-control @error('series_id') is-invalid @enderror"
              data-configs-url="{{ route('master.series-type.configs', ':id') }}"
              required>
        @foreach($series as $s)
          <option value="{{ $s->id }}" @selected(old('series_id', $seriesType->series_id) == $s->id)>
            {{ $s->series }}
          </option>
        @endforeach
      </select>
      @error('series_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
      <div class="form-text">{{ __('Choose a series to load its available configurations below.') }}</div>
    </div>

    {{-- Configuration (Series Type) --}}
    <div class="mb-3">
      <label class="form-label" for="series_type">{{ __('Configuration') }}</label>
      <div class="input-group">
        <input
          type="text"
          name="series_type"
          id="series_type"
          class="form-control @error('series_type') is-invalid @enderror"
          value="{{ old('series_type', $seriesType->series_type) }}"
          placeholder="{{ __('e.g., XO, PW6-32') }}"
          required
        >
        <button type="button" class="btn btn-outline-secondary" id="btnClearCfg">
          {{ __('Clear') }}
        </button>
        @error('series_type') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
      </div>
      <div class="form-text">{{ __('Click a configuration from the list to fill this field, or type your own.') }}</div>
    </div>

    {{-- Configurations list (filtered by selected series) --}}
    <div class="mb-2">
      <label class="form-label">{{ __('Available Configurations for this Series') }}</label>
      <input type="text" class="form-control form-control-sm mb-2" id="cfgSearchEdit"
             placeholder="{{ __('Search configurations…') }}" disabled>
      <div id="cfgListEdit" class="border rounded p-2 bg-light"
           style="max-height: 260px; overflow: auto;">
        <div class="text-muted small py-2">{{ __('Select a series to load configurations…') }}</div>
      </div>
      <div class="form-text">{{ __('Click a row to use that configuration.') }}</div>
    </div>
  </div>

  <div class="modal-footer">
    <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
  </div>
</form>

<script>
(() => {
  const seriesSel   = document.getElementById('series_id');
  const listBox     = document.getElementById('cfgListEdit');
  const searchInput = document.getElementById('cfgSearchEdit');
  const stInput     = document.getElementById('series_type');
  const btnClear    = document.getElementById('btnClearCfg');

  function renderConfigs(items){
    if(!items || !items.length){
      listBox.innerHTML = '<div class="text-muted small py-2">{{ __('No configurations found for this series.') }}</div>';
      return;
    }

    const current = (stInput.value || '').trim().toLowerCase();

    const html = items.map(it => {
      const label = (it.label || '').trim();
      const isCurrent = label.toLowerCase() === current;
      return `
        <label class="d-flex align-items-center justify-content-between gap-2 py-2 px-2 bg-white rounded mb-1 cfg-row"
               style="cursor:pointer;border:1px solid rgba(0,0,0,.06)">
          <div class="small">
            <strong>${label}</strong>
          </div>
          <span class="badge ${isCurrent ? 'bg-primary' : 'bg-secondary'}">
            ${isCurrent ? '{{ __('Selected') }}' : '{{ __('Use') }}'}
          </span>
        </label>
      `;
    }).join('');
    listBox.innerHTML = html;

    listBox.querySelectorAll('.cfg-row').forEach(el => {
      el.addEventListener('click', () => {
        const label = el.querySelector('strong')?.textContent || '';
        stInput.value = label;
        // re-render to reflect "Selected"
        renderConfigs(items);
      });
    });
  }

  function enableSearch(){
    searchInput.disabled = false;
    searchInput.value = '';
    searchInput.oninput = () => {
      const term = searchInput.value.trim().toLowerCase();
      listBox.querySelectorAll('.cfg-row').forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(term) ? '' : 'none';
      });
    };
  }

  function loadConfigs(){
    const id   = seriesSel.value;
    const tmpl = seriesSel.getAttribute('data-configs-url');
    const url  = tmpl.replace(':id', encodeURIComponent(id));

    listBox.innerHTML = '<div class="text-muted small py-2">{{ __('Loading…') }}</div>';
    searchInput.disabled = true;

    fetch(url, { headers: { 'Accept': 'application/json' } })
      .then(r => r.json())
      .then(j => {
        const items = (j && j.data) ? j.data : [];
        renderConfigs(items);
        enableSearch();
      })
      .catch(() => {
        listBox.innerHTML = '<div class="text-danger small py-2">{{ __('Error loading configurations.') }}</div>';
      });
  }

  // events
  seriesSel?.addEventListener('change', loadConfigs);
  btnClear?.addEventListener('click', () => { stInput.value = ''; stInput.focus(); });

  // preload based on current series selection
  if (seriesSel?.value) loadConfigs();
})();
</script>

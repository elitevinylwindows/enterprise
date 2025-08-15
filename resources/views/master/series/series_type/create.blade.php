{{-- resources/views/master/series/series_type/create.blade.php --}}
<form action="{{ route('master.series-type.store') }}" method="POST">
  @csrf
  <div class="modal-header"><h5 class="modal-title">{{ __('Add Series Type') }}</h5></div>

  <div class="modal-body">
    {{-- Series --}}
    <div class="mb-3">
      <label class="form-label" for="series_id">{{ __('Series') }}</label>
      <select
        name="series_id" id="series_id"
        class="form-control @error('series_id') is-invalid @enderror"
        data-configs-url="{{ route('master.series-type.configs', ['series' => '__ID__']) }}"
        required
      >
        <option value="" disabled {{ old('series_id') ? '' : 'selected' }}>{{ __('Select series…') }}</option>
        @foreach($series as $s)
          <option value="{{ $s->id }}" @selected(old('series_id') == $s->id)>{{ $s->series }}</option>
        @endforeach
      </select>
      @error('series_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
      <div class="form-text">{{ __('Choose a series to see its available configurations below.') }}</div>
    </div>

    {{-- Series Type (filled by clicking a config, or typed manually) --}}
    <div class="mb-3">
      <label class="form-label" for="series_type">{{ __('Series Type') }}</label>
      <input type="text"
             name="series_type" id="series_type"
             class="form-control @error('series_type') is-invalid @enderror"
             value="{{ old('series_type') }}" placeholder="e.g., XO, PW6-32" required>
      @error('series_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
      <div class="form-text">{{ __('Pick from the list or type your own.') }}</div>
    </div>

    {{-- Configs (loaded by Series) --}}
    <div class="mb-2">
      <label class="form-label">{{ __('Available Configurations For This Series') }}</label>
      <input type="text" class="form-control form-control-sm mb-2" id="cfgSearchCreate"
             placeholder="{{ __('Search configurations…') }}" disabled>
      <div id="cfgListCreate" class="border rounded p-2 bg-light" style="max-height:240px;overflow:auto;">
        <div class="text-muted small py-2">{{ __('Select a series to load configurations…') }}</div>
      </div>
      <div class="form-text">{{ __('Click a configuration to fill the Series Type field.') }}</div>
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
  const box         = document.getElementById('cfgListCreate');
  const searchInput = document.getElementById('cfgSearchCreate');
  const stInput     = document.getElementById('series_type');

  function render(items){
    if(!items?.length){
      box.innerHTML = '<div class="text-muted small py-2">{{ __('No configurations found for this series.') }}</div>';
      return;
    }
    box.innerHTML = items.map(it => `
      <label class="d-flex align-items-center justify-content-between gap-2 py-2 px-2 bg-white rounded mb-1 cfg-row"
             style="cursor:pointer;border:1px solid rgba(0,0,0,.06)">
        <div class="small"><strong>${it.label}</strong></div>
        <span class="badge bg-secondary">{{ __('Use') }}</span>
      </label>
    `).join('');

    box.querySelectorAll('.cfg-row').forEach(el => {
      el.addEventListener('click', () => {
        const label = el.querySelector('strong')?.textContent || '';
        stInput.value = label;
      });
    });
  }

  function enableSearch(){
    searchInput.disabled = false;
    searchInput.value = '';
    searchInput.oninput = () => {
      const term = searchInput.value.trim().toLowerCase();
      box.querySelectorAll('.cfg-row').forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(term) ? '' : 'none';
      });
    };
  }

  seriesSel?.addEventListener('change', () => {
    const id  = seriesSel.value;
    const tpl = seriesSel.dataset.configsUrl;         // e.g. /master/series-type/configs-by-series/__ID__
    const url = tpl.replace('__ID__', encodeURIComponent(id));

    box.innerHTML = '<div class="text-muted small py-2">{{ __('Loading…') }}</div>';
    searchInput.disabled = true;

    fetch(url, { headers: { 'Accept': 'application/json' } })
      .then(r => r.json())
      .then(j => { render(j?.data || []); enableSearch(); })
      .catch(() => { box.innerHTML = '<div class="text-danger small py-2">{{ __('Error loading configurations.') }}</div>'; });
  });
})();
</script>

<form action="{{ route('master.series-type.update', $seriesType->id) }}" method="POST">
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
          <option value="{{ $s->id }}" @selected(old('series_id', $seriesType->series_id)==$s->id)>{{ $s->series }}</option>
        @endforeach
      </select>
      @error('series_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    {{-- Series Type text --}}
    <div class="mb-3">
      <label class="form-label" for="series_type">{{ __('Series Type') }}</label>
      <input type="text" name="series_type" id="series_type"
             class="form-control @error('series_type') is-invalid @enderror"
             value="{{ old('series_type', $seriesType->series_type) }}" required>
      @error('series_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    {{-- Configs list (filtered) --}}
    <div class="mb-2">
      <label class="form-label">{{ __('Available Configurations for this Series') }}</label>
      <input type="text" class="form-control form-control-sm mb-2" id="cfgSearchEdit{{ $seriesType->id }}"
             placeholder="{{ __('Search configurations…') }}" disabled>
      <div id="cfgListEdit{{ $seriesType->id }}" class="border rounded p-2 bg-light"
           style="max-height: 240px; overflow: auto;">
        <div class="text-muted small py-2">{{ __('Select a series to load configurations…') }}</div>
      </div>
    </div>
  </div>

  <div class="modal-footer">
    <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
  </div>
</form>

<script>
(() => {
  const wrapId    = '{{ $seriesType->id }}';
  const seriesSel = document.querySelector(`#editModal{{ $seriesType->id }} #series_id`);
  const listBox   = document.getElementById(`cfgListEdit{{ $seriesType->id }}`);
  const searchInp = document.getElementById(`cfgSearchEdit{{ $seriesType->id }}`);
  const stInput   = document.querySelector(`#editModal{{ $seriesType->id }} #series_type`);

  function render(items){
    if(!items || !items.length){
      listBox.innerHTML = '<div class="text-muted small py-2">{{ __('No configurations found for this series.') }}</div>';
      return;
    }
    const html = items.map(it => `
      <label class="d-flex align-items-center justify-content-between gap-2 py-2 px-2 bg-white rounded mb-1 cfg-row"
             style="cursor:pointer;border:1px solid rgba(0,0,0,.06)">
        <div class="small"><strong>${it.label}</strong></div>
        <span class="badge bg-secondary">{{ __('Use') }}</span>
      </label>
    `).join('');
    listBox.innerHTML = html;

    listBox.querySelectorAll('.cfg-row').forEach(el => {
      el.addEventListener('click', () => {
        const label = el.querySelector('strong')?.textContent || '';
        stInput.value = label;
      });
    });
  }

  function enableSearch(){
    searchInp.disabled = false;
    searchInp.value = '';
    searchInp.oninput = () => {
      const term = searchInp.value.trim().toLowerCase();
      listBox.querySelectorAll('.cfg-row').forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(term) ? '' : 'none';
      });
    };
  }

  function load(){
    const id   = seriesSel.value;
    const tmpl = seriesSel.getAttribute('data-configs-url');
    const url  = tmpl.replace(':id', encodeURIComponent(id));
    listBox.innerHTML = '<div class="text-muted small py-2">{{ __('Loading…') }}</div>';
    searchInp.disabled = true;
    fetch(url, { headers: { 'Accept': 'application/json' } })
      .then(r => r.json())
      .then(j => { render(j?.data || []); enableSearch(); })
      .catch(() => { listBox.innerHTML = '<div class="text-danger small py-2">{{ __('Error loading configurations.') }}</div>'; });
  }

  // Load immediately with current series
  if (seriesSel?.value) load();
  seriesSel?.addEventListener('change', load);
})();
</script>

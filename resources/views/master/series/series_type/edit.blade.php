@php
  $selectedPT = old('product_type_ids');
  if (is_null($selectedPT)) {
    $selectedPT = $seriesType->productTypes->pluck('id')->map('strval')->all();
  } else {
    $selectedPT = collect($selectedPT)->map('strval')->all();
  }
@endphp

<form action="{{ route('master.series-type.update', $seriesType->id) }}" method="POST">
  @csrf @method('PUT')

  <div class="modal-body">
    {{-- Series (single) --}}
    <div class="mb-3">
      <label class="form-label" for="series_id">{{ __('Series') }}</label>
      <select name="series_id" id="series_id"
              class="form-control @error('series_id') is-invalid @enderror" required>
        @foreach($series as $s)
          <option value="{{ $s->id }}" @selected((string)old('series_id', $seriesType->series_id) === (string)$s->id)>
            {{ $s->series }}
          </option>
        @endforeach
      </select>
      @error('series_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    {{-- Series Type (single) --}}
    <div class="mb-3">
      <label class="form-label" for="series_type">{{ __('Series Type') }}</label>
      <input type="text" name="series_type" id="series_type"
             class="form-control @error('series_type') is-invalid @enderror"
             value="{{ old('series_type', $seriesType->series_type) }}" required>
      @error('series_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    {{-- Product Types (searchable multi-checkbox list) --}}
    <div class="mb-2">
      <label class="form-label">{{ __('Product Types') }}</label>
      <input type="text" class="form-control form-control-sm mb-2" id="ptSearchEdit{{ $seriesType->id }}"
             placeholder="{{ __('Search product types…') }}">
      <div id="ptListEdit{{ $seriesType->id }}" class="border rounded p-2" style="max-height: 220px; overflow: auto;">
        @foreach($productTypes as $pt)
          @php($id = (string)$pt->id)
          <label class="d-flex align-items-center gap-2 py-1 product-type-item">
            <input type="checkbox" name="product_type_ids[]" value="{{ $pt->id }}"
                   {{ in_array($id, $selectedPT) ? 'checked' : '' }}>
            <span class="small">
              <strong>{{ $pt->product_type }}</strong>
              @if(!empty($pt->description)) – <span class="text-muted">{{ $pt->description }}</span>@endif
            </span>
          </label>
        @endforeach
      </div>
      @error('product_type_ids') <div class="text-danger small">{{ $message }}</div> @enderror
      @error('product_type_ids.*') <div class="text-danger small">{{ $message }}</div> @enderror
      <div class="form-text">{{ __('Use the search box to filter; select one or more.') }}</div>
    </div>
  </div>

  <div class="modal-footer">
    <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
  </div>
</form>

<script>
(() => {
  const q = document.getElementById('ptSearchEdit{{ $seriesType->id }}');
  const box = document.getElementById('ptListEdit{{ $seriesType->id }}');
  if (!q || !box) return;
  q.addEventListener('input', () => {
    const term = q.value.trim().toLowerCase();
    box.querySelectorAll('.product-type-item').forEach(row => {
      row.style.display = row.textContent.toLowerCase().includes(term) ? '' : 'none';
    });
  });
})();
</script>

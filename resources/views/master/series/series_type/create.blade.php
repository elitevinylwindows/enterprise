<form action="{{ route('master.series-type.store') }}" method="POST">
  @csrf

  <div class="modal-body">
    {{-- Series (single) --}}
    <div class="mb-3">
      <label class="form-label" for="series_id">{{ __('Series') }}</label>
      <select name="series_id" id="series_id"
              class="form-control @error('series_id') is-invalid @enderror" required>
        <option value="" disabled {{ old('series_id') ? '' : 'selected' }}>{{ __('Select series…') }}</option>
        @foreach($series as $s)
          <option value="{{ $s->id }}" @selected(old('series_id') == $s->id)>{{ $s->series }}</option>
        @endforeach
      </select>
      @error('series_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    {{-- Series Type (single) --}}
    <div class="mb-3">
      <label class="form-label" for="series_type">{{ __('Series Type') }}</label>
      <input type="text" name="series_type" id="series_type"
             class="form-control @error('series_type') is-invalid @enderror"
             value="{{ old('series_type') }}" placeholder="e.g., XO, PW6-32" required>
      @error('series_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    {{-- Product Types (searchable multi-checkbox list) --}}
    <div class="mb-2">
      <label class="form-label">{{ __('Product Types') }}</label>
      <input type="text" class="form-control form-control-sm mb-2" id="ptSearchCreate"
             placeholder="{{ __('Search product types…') }}">
      <div id="ptListCreate" class="border rounded p-2" style="max-height: 220px; overflow: auto;">
        @php($oldPT = collect(old('product_type_ids', []))->map('strval')->all())
        @foreach($productTypes as $pt)
          @php($id = (string)$pt->id)
          <label class="d-flex align-items-center gap-2 py-1 product-type-item">
            <input type="checkbox" name="product_type_ids[]" value="{{ $pt->id }}"
                   {{ in_array($id, $oldPT) ? 'checked' : '' }}>
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
    <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
  </div>
</form>

<script>
(() => {
  const q = document.getElementById('ptSearchCreate');
  const box = document.getElementById('ptListCreate');
  if (!q || !box) return;
  q.addEventListener('input', () => {
    const term = q.value.trim().toLowerCase();
    box.querySelectorAll('.product-type-item').forEach(row => {
      row.style.display = row.textContent.toLowerCase().includes(term) ? '' : 'none';
    });
  });
})();
</script>

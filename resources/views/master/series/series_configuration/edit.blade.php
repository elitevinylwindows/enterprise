<form action="{{ route('master.series-configuration.update', $seriesType->id) }}" method="POST">
  @csrf
  @method('PUT')


  <div class="modal-body">
    <div class="mb-3">
      <label class="form-label">{{ __('Series Type') }}</label>
      <input type="text" name="series_type" class="form-control @error('series_type') is-invalid @enderror"
             value="{{ old('series_type', $seriesType->series_type) }}" required>
      @error('series_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="mb-2">
      <label class="form-label">{{ __('Product Types') }}</label>
      <input type="text" class="form-control form-control-sm mb-2" id="ptSearchEdit{{ $seriesType->id }}"
             placeholder="{{ __('Search product types…') }}">
      <div id="ptListEdit{{ $seriesType->id }}" class="border rounded p-2" style="max-height:220px;overflow:auto;">
        @php
          $checked = $seriesType->productTypes->pluck('id')->map('strval')->all();
        @endphp
        @foreach($productTypes as $pt)
          @php($id = (string) $pt->id)
          <label class="d-flex align-items-center gap-2 py-1 product-type-item">
            <input type="checkbox" name="product_type_ids[]" value="{{ $pt->id }}"
                   {{ in_array($id, old('product_type_ids', $checked)) ? 'checked' : '' }}>
            <span class="small">
              <strong>{{ $pt->product_type }}</strong>
              @if(!empty($pt->description)) – <span class="text-muted">{{ $pt->description }}</span>@endif
            </span>
          </label>
        @endforeach
      </div>
      @error('product_type_ids') <div class="text-danger small">{{ $message }}</div> @enderror
      @error('product_type_ids.*') <div class="text-danger small">{{ $message }}</div> @enderror
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

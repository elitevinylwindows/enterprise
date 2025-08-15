<form action="{{ route('product_keys.producttypes.update', $productType->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="modal-header">
        <h5 class="modal-title">Edit Product Type</h5>
    </div>

    <div class="modal-body">
        <div class="form-group mb-3">
            <label>Product Type</label>
            <input type="text" name="product_type" class="form-control" value="{{ $productType->product_type }}" required>
        </div>
        <div class="form-group mb-3">
  <label for="series">Series</label>
  <select name="series" id="series" class="form-control" required>
    @php($current = old('series', $model->series ?? ''))
    <option value="" disabled {{ $current==='' ? 'selected' : '' }}>Select series…</option>
    <option value="DYNAMIC"  {{ $current==='DYNAMIC'  ? 'selected' : '' }}>DYNAMIC</option>
    <option value="PRESTIGE" {{ $current==='PRESTIGE' ? 'selected' : '' }}>PRESTIGE</option>
    <option value="VIP"      {{ $current==='VIP'      ? 'selected' : '' }}>VIP</option>
    <option value="OBSIDIAN" {{ $current==='OBSIDIAN' ? 'selected' : '' }}>OBSIDIAN</option>
  </select>
  @error('series') <div class="text-danger small">{{ $message }}</div> @enderror
</div>

        <div class="form-group mb-3">
            <label>Description</label>
            <input type="text" name="description" class="form-control" value="{{ $productType->description }}" required>
        </div>

        <div class="form-group mb-3">
            <label>Material Type</label>
            <input type="text" name="material_type" class="form-control" value="{{ $productType->material_type }}">
        </div>

        <div class="form-group mb-3">
            <label>Glazing Bead Position</label>
            <input type="text" name="glazing_bead_position" class="form-control" value="{{ $productType->glazing_bead_position }}">
        </div>
        <div class="form-group mb-3">
            <label>Price Schema Product ID</label>
            <input type="text" name="product_id" class="form-control" value="{{ $productType->product_id }}">
        </div>
    </div>

    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Update</button>
    </div>
</form>

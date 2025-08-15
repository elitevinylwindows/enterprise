<form action="{{ route('product_keys.producttypes.store') }}" method="POST">
    @csrf
    <div class="modal-header">
        <h5 class="modal-title">Add Product Type</h5>
    </div>
    <div class="modal-body">
        <div class="form-group mb-3">
            <label for="product_type">Product Type</label>
            <input type="text" name="product_type" class="form-control" required>
        </div>
        <div class="form-group mb-3">
  <label for="series">Series</label>
  <select name="series" id="series" class="form-control" required>
    <option value="" disabled {{ old('series', $row->series ?? '')==='' ? 'selected' : '' }}>Select series…</option>
    <option value="DYNAMIC"  {{ old('series', $row->series ?? '')==='DYNAMIC'  ? 'selected' : '' }}>DYNAMIC</option>
    <option value="PRESTIGE" {{ old('series', $row->series ?? '')==='PRESTIGE' ? 'selected' : '' }}>PRESTIGE</option>
    <option value="VIP"      {{ old('series', $row->series ?? '')==='VIP'      ? 'selected' : '' }}>VIP</option>
    <option value="OBSIDIAN" {{ old('series', $row->series ?? '')==='OBSIDIAN' ? 'selected' : '' }}>OBSIDIAN</option>
  </select>
  @error('series') <div class="text-danger small">{{ $message }}</div> @enderror
</div>

        <div class="form-group mb-3">
            <label for="description">Description</label>
            <input type="text" name="description" class="form-control" required>
        </div>

        <div class="form-group mb-3">
            <label for="material_type">Material Type</label>
            <input type="text" name="material_type" class="form-control">
        </div>

        <div class="form-group mb-3">
            <label for="glazing_bead_position">Glazing Bead Position</label>
            <input type="text" name="glazing_bead_position" class="form-control">
        </div>

        <div class="form-group mb-3">
            <label for="product_id">Price Schema Product ID</label>
            <input type="text" name="product_id" class="form-control">
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
</form>

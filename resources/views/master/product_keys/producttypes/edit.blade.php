<form action="{{ route('product_keys.producttypes.update', $productType->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="modal-body">
        <div class="form-group mb-3">
            <label for="product_type">Product Type</label>
            <input type="text"
                   name="product_type"
                   id="product_type"
                   class="form-control @error('product_type') is-invalid @enderror"
                   value="{{ old('product_type', $productType->product_type) }}"
                   required>
            @error('product_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-group mb-3">
            <label for="series">Series</label>
            <select name="series"
                    id="series"
                    class="form-control @error('series') is-invalid @enderror"
                    required>
                <option value="" disabled>Select series…</option>
                @foreach($series as $s)
                    <option value="{{ $s->series }}"
                      {{ old('series', $productType->series) === $s->series ? 'selected' : '' }}>
                      {{ $s->series }}
                    </option>
                @endforeach
            </select>
            @error('series') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-group mb-3">
            <label for="description">Description</label>
            <input type="text"
                   name="description"
                   id="description"
                   class="form-control @error('description') is-invalid @enderror"
                   value="{{ old('description', $productType->description) }}"
                   required>
            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-group mb-3">
            <label for="material_type">Material Type</label>
            <input type="text"
                   name="material_type"
                   id="material_type"
                   class="form-control @error('material_type') is-invalid @enderror"
                   value="{{ old('material_type', $productType->material_type) }}">
            @error('material_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-group mb-3">
            <label for="glazing_bead_position">Glazing Bead Position</label>
            <input type="text"
                   name="glazing_bead_position"
                   id="glazing_bead_position"
                   class="form-control @error('glazing_bead_position') is-invalid @enderror"
                   value="{{ old('glazing_bead_position', $productType->glazing_bead_position) }}">
            @error('glazing_bead_position') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-group mb-3">
            <label for="product_id">Price Schema Product ID</label>
            <input type="text"
                   name="product_id"
                   id="product_id"
                   class="form-control @error('product_id') is-invalid @enderror"
                   value="{{ old('product_id', $productType->product_id) }}"
                   required>
            @error('product_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
    </div>

    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Update</button>
    </div>
</form>

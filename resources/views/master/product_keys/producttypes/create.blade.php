<form action="{{ route('product_keys.producttypes.store') }}" method="POST">
    @csrf
    

    <div class="modal-body">
        <div class="form-group mb-3">
            <label for="product_type">Product Type</label>
            <input type="text"
                   name="product_type"
                   id="product_type"
                   class="form-control @error('product_type') is-invalid @enderror"
                   value="{{ old('product_type') }}"
                   required>
            @error('product_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-group mb-3">
            <label for="series">Series</label>
            <select name="series"
                    id="series"
                    class="form-control @error('series') is-invalid @enderror"
                    required>
                <option value="" disabled {{ old('series') ? '' : 'selected' }}>Select series…</option>
                @foreach($series as $s)
                    <option value="{{ $s->series }}"
                        {{ old('series') === $s->series ? 'selected' : '' }}>
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
                   value="{{ old('description') }}"
                   required>
            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

   <div class="form-group mb-3">
    <label for="type" class="form-label">Type</label>
    <select
        name="type"
        id="type"
        class="form-select @error('type') is-invalid @enderror"
    >
        <option value="" disabled @selected(! old('type', $productType->type ?? ''))>Select type</option>
        <option value="Door" @selected(old('type', $productType->type ?? '') === 'Door')>Door</option>
        <option value="Window" @selected(old('type', $productType->type ?? '') === 'Window')>Window</option>
    </select>
    @error('type') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="form-group mb-3">
    <label for="line_id" class="form-label">Line</label>
    <select
        name="line_id"
        id="line_id"
        class="form-select @error('line_id') is-invalid @enderror"
        required
    >
        <option value="" disabled @selected(! old('line_id', $productType->line_id ?? ''))>
            Select line
        </option>

        @foreach($lines as $line)
            <option value="{{ $line->id }}"
                @selected(old('line_id', $productType->line_id ?? '') == $line->id)>
                {{ $line->name }}
            </option>
        @endforeach
    </select>
    @error('line_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>


        <div class="form-group mb-3">
            <label for="material_type">Material Type</label>
            <input type="text"
                   name="material_type"
                   id="material_type"
                   class="form-control @error('material_type') is-invalid @enderror"
                   value="{{ old('material_type') }}">
            @error('material_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-group mb-3">
            <label for="glazing_bead_position">Glazing Bead Position</label>
            <input type="text"
                   name="glazing_bead_position"
                   id="glazing_bead_position"
                   class="form-control @error('glazing_bead_position') is-invalid @enderror"
                   value="{{ old('glazing_bead_position') }}">
            @error('glazing_bead_position') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-group mb-3">
            <label for="product_id">Price Schema Product ID</label>
            <input type="text"
                   name="product_id"
                   id="product_id"
                   class="form-control @error('product_id') is-invalid @enderror"
                   value="{{ old('product_id') }}"
                   required>
            @error('product_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
    </div>

    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
</form>

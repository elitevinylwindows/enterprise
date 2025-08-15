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
            <label for="description">Series</label>
            <input type="text" name="description" class="form-control" required>
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

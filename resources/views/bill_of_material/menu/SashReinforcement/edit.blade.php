<form action="{{ route('sashreinforcement.update', $item->id) }}" method="POST">
    @csrf @method('PUT')
    <div class="modal-header"><h5 class="modal-title">Edit SashReinforcement</h5></div>
    <div class="modal-body">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" class="form-control" value="{{ $item->name }}" required>
        </div>
        <div class="mb-3">
            <label for="size" class="form-label">Size</label>
            <input type="text" name="size" class="form-control" value="{{ $item->size }}" required>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Update</button>
    </div>
</form>
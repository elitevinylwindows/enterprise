<form action="{{ route('color-options.color-configurations.update', $colorConfiguration->id) }}" method="POST">
    @csrf @method('PUT')
    <div class="modal-header">
        <h5 class="modal-title">Edit Color Configuration</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>

    <div class="modal-body">
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input name="name" type="text" class="form-control" value="{{ $colorConfiguration->name }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Code</label>
            <input name="code" type="text" class="form-control" value="{{ $colorConfiguration->code }}" required>
        </div>
    </div>

    <div class="modal-footer">
        <button type="submit" class="btn btn-warning">Update</button>
    </div>
</form>

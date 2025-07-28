<form action="{{ route('color-options.laminate-colors.update', $laminateColor->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="modal-header">
        <h5 class="modal-title">Edit Laminate Color</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>
    <div class="modal-body">
        <div class="mb-3">
            <label for="name" class="form-label">Color Name</label>
            <input type="text" name="name" class="form-control" value="{{ $laminateColor->name }}" required>
        </div>
        <div class="mb-3">
            <label for="code" class="form-label">Color Code</label>
            <input type="text" name="code" class="form-control" value="{{ $laminateColor->code }}" required>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Update</button>
    </div>
</form>

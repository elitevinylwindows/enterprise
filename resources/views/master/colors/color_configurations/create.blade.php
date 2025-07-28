<form action="{{ route('color-options.color-configurations.store') }}" method="POST">
    @csrf
    <div class="modal-header">
        <h5 class="modal-title">Add Color Configuration</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>

    <div class="modal-body">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input name="name" type="text" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="code" class="form-label">Code</label>
            <input name="code" type="text" class="form-control" required>
        </div>
    </div>

    <div class="modal-footer">
        <button type="submit" class="btn btn-success">Save</button>
    </div>
</form>

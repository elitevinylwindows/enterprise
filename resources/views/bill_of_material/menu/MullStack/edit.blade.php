<form action="{{ route('mullstack.update', $item->id) }}" method="POST">
    @csrf @method('PUT')
    <div class="modal-header">
        <h5 class="modal-title">Edit MullStack</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" name="name" value="{{ $item->name }}" required>
        </div>
        <div class="mb-3">
            <label for="color" class="form-label">Color</label>
            <input type="text" class="form-control" name="color" value="{{ $item->color }}" required>
        </div>
    
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Update</button>
    </div>
</form>

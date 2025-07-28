<form action="{{ route('master.series.update', $series->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="modal-header">
        <h5 class="modal-title">Edit Series</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>

    <div class="modal-body">
        <div class="form-group">
            <label>Series</label>
            <input type="text" name="series" class="form-control" value="{{ $series->series }}" required>
        </div>
    </div>

    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Update</button>
    </div>
</form>

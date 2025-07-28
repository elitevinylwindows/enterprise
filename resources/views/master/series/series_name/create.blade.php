<form action="{{ route('master.series-name.store') }}" method="POST">
    @csrf
    <div class="modal-header"><h5 class="modal-title">Add Series Name</h5></div>
    <div class="modal-body">
        <div class="form-group mb-3">
            <label for="series_id">Series</label>
            <select name="series_id" class="form-control" required>
                @foreach($series as $s)
                    <option value="{{ $s->id }}">{{ $s->series }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group mb-3">
            <label for="series_name">Series Name</label>
            <input type="text" name="series_name" class="form-control" required>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
</form>

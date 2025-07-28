<form action="{{ route('master.prices.markup.store') }}" method="POST">
    @csrf
    <div class="modal-header">
        <h5 class="modal-title">Add Markup</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>
    
    <div class="modal-body">
        <div class="mb-3">
            <label for="series_id" class="form-label">Series</label>
            <select name="series_id" class="form-select" required>
                <option value="">Select Series</option>
                @foreach($series as $s)
                    <option value="{{ $s->id }}">{{ $s->series }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="percentage" class="form-label">Markup (%)</label>
            <input type="number" step="0.01" name="percentage" class="form-control" required>
        </div>
    </div>

    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
</form>

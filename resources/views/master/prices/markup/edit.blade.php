<form action="{{ route('master.prices.markup.update', $markup->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="modal-header">
        <h5 class="modal-title">Edit Markup</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>

    <div class="modal-body">
        <div class="mb-3">
            <label for="series_id" class="form-label">Series</label>
            <select name="series_id" class="form-select" required>
                @foreach($series as $s)
                    <option value="{{ $s->id }}" {{ $markup->series_id == $s->id ? 'selected' : '' }}>
                        {{ $s->series }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="percentage" class="form-label">Markup (%)</label>
            <input type="number" step="0.01" name="percentage" class="form-control" value="{{ $markup->percentage }}" required>
        </div>
    </div>

    <div class="modal-footer">
        <button type="submit" class="btn btn-success">Update</button>
    </div>
</form>

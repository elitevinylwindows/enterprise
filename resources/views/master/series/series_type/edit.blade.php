<form action="{{ route('master.series-type.update', $seriesType->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="modal-header">
        <h5 class="modal-title">Edit Series Type</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>

    <div class="modal-body">
        <div class="form-group mb-3">
            <label for="series_id">Series</label>
            <select name="series_id" class="form-control" required>
                @foreach($series as $s)
                    <option value="{{ $s->id }}" {{ $seriesType->series_id == $s->id ? 'selected' : '' }}>
                        {{ $s->series }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="product_type_id">Product Type</label>
            <select name="product_type_id" class="form-control" required>
                @foreach($productTypes as $pt)
                    <option value="{{ $pt->id }}" {{ $seriesType->product_type_id == $pt->id ? 'selected' : '' }}>
                        {{ $pt->product_type }} - {{ $pt->description }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="series_type">Series Type</label>
            <input type="text" name="series_type" class="form-control" value="{{ $seriesType->series_type }}" required>
        </div>
    </div>

    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Update</button>
    </div>
</form>

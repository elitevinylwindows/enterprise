<form action="{{ route('master.series-type.store') }}" method="POST">
    @csrf
    <div class="modal-header">
        <h5 class="modal-title">Add Series Type</h5>
    </div>
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
            <label for="product_type_id">Product Type</label>
            <select name="product_type_id" class="form-control" required>
                @foreach($productTypes as $pt)
                    <option value="{{ $pt->id }}">{{ $pt->product_type }} - {{ $pt->description }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="series_type">Series Type</label>
            <input type="text" name="series_type" class="form-control" placeholder="e.g. XO, PW6-32" required>
        </div>
    </div>

    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
</form>

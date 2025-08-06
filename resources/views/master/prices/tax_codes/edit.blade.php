<div class="modal-header">
    <h5 class="modal-title">Edit Tax Code</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<form action="{{ route('master.prices.tax_codes.update', $taxCode->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="modal-body">
        <div class="mb-3">
            <label for="code" class="form-label">Code</label>
            <input type="text" class="form-control" name="code" value="{{ $taxCode->code }}" required>
        </div>
        <div class="mb-3">
            <label for="city" class="form-label">City</label>
            <input type="text" class="form-control" name="city" value="{{ $taxCode->city }}" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" name="description">{{ $taxCode->description }}</textarea>
        </div>
        <div class="mb-3">
            <label for="rate" class="form-label">Rate (%)</label>
            <input type="number" class="form-control" name="rate" value="{{ $taxCode->rate }}" step="0.01" required>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Save Changes</button>
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
    </div>
</form>

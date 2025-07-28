<form action="{{ route('executives.customers.store') }}" method="POST">
    @csrf

    <div class="modal-header">
        <h5 class="modal-title">Add Customer</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>

    <div class="modal-body">
        <div class="mb-3">
            <label class="form-label">Customer Number</label>
            <input type="text" name="customer_number" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Tier</label>
            <select name="tier" class="form-control">
                @foreach($tiers as $tier)
                    <option value="{{ $tier->name }}">{{ $tier->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Street</label>
            <input type="text" name="street" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">City</label>
            <input type="text" name="city" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">ZIP</label>
            <input type="text" name="zip" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-control">
                <option value="active" selected>Active</option>
                <option value="inactive">Inactive</option>
            </select>
        </div>
    </div>

    <div class="modal-footer">
        <button class="btn btn-primary">Save Customer</button>
    </div>
</form>

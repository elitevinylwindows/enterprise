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
            <label class="form-label">Email</label>
            <input type="text" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Tier</label>
            <select name="tier" class="form-control">
                @foreach($tiers as $tier)
                <option value="{{ $tier->id }}">{{ $tier->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Billing Address</label>
            <input type="text" name="billing_address" class="form-control" maxlength="255">
        </div>
        <div class="mb-3">
            <label class="form-label">Billing City</label>
            <input type="text" name="billing_city" class="form-control" maxlength="255">
        </div>
        <div class="mb-3">
            <label class="form-label">Billing State</label>
            <input type="text" name="billing_state" class="form-control" maxlength="255">
        </div>
        <div class="mb-3">
            <label class="form-label">Billing Zip</label>
            <input type="text" name="billing_zip" class="form-control" maxlength="20">
        </div>
        <div class="mb-3">
            <label class="form-label">Billing Country</label>
            <input type="text" name="billing_country" class="form-control" maxlength="255">
        </div>
        <div class="mb-3">
            <label class="form-label">Billing Phone</label>
            <input type="text" name="billing_phone" class="form-control" maxlength="20">
        </div>
        <div class="mb-3">
            <label class="form-label">Billing Fax</label>
            <input type="text" name="billing_fax" class="form-control" maxlength="20">
        </div>
        <hr>
        <div class="mb-3">
            <label class="form-label">Delivery Address</label>
            <input type="text" name="delivery_address" class="form-control" maxlength="255">
        </div>
        <div class="mb-3">
            <label class="form-label">Delivery City</label>
            <input type="text" name="delivery_city" class="form-control" maxlength="255">
        </div>
        <div class="mb-3">
            <label class="form-label">Delivery State</label>
            <input type="text" name="delivery_state" class="form-control" maxlength="255">
        </div>
        <div class="mb-3">
            <label class="form-label">Delivery Zip</label>
            <input type="text" name="delivery_zip" class="form-control" maxlength="20">
        </div>
        <div class="mb-3">
            <label class="form-label">Delivery Country</label>
            <input type="text" name="delivery_country" class="form-control" maxlength="255">
        </div>
        <div class="mb-3">
            <label class="form-label">Delivery Phone</label>
            <input type="text" name="delivery_phone" class="form-control" maxlength="20">
        </div>
        <div class="mb-3">
            <label class="form-label">Delivery Fax</label>
            <input type="text" name="delivery_fax" class="form-control" maxlength="20">
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

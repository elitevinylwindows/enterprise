<form action="{{ route('master.customers.store') }}" method="POST">
    @csrf

    <div class="modal-header">
        <h5 class="modal-title">Add Customer</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>

    <div class="modal-body">
        <!-- Basic Information -->
        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <label class="form-label">Customer Number</label>
                <input type="text" name="customer_number" class="form-control" required>
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Email</label>
                <input type="text" name="email" class="form-control" required>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-6 mb-3">
                <label class="form-label">Tier</label>
                <select name="tier" class="form-control">
                    @foreach($tiers as $tier)
                    <option value="{{ $tier->name }}">{{ $tier->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-control">
                    <option value="active" selected>Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
        </div>

        <!-- Billing and Delivery Information -->
        <div class="row">
            <!-- Billing Information Column -->
            <div class="col-md-6">
                <h6 class="mb-3 border-bottom pb-2">Billing Information</h6>
                
                <div class="mb-3">
                    <label class="form-label">Address</label>
                    <input type="text" name="billing_address" class="form-control" maxlength="255">
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">City</label>
                        <input type="text" name="billing_city" class="form-control" maxlength="255">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">State</label>
                        <input type="text" name="billing_state" class="form-control" maxlength="255">
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">ZIP Code</label>
                        <input type="text" name="billing_zip" class="form-control" maxlength="20">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Country</label>
                        <input type="text" name="billing_country" class="form-control" maxlength="255">
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" name="billing_phone" class="form-control" maxlength="20">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Fax</label>
                        <input type="text" name="billing_fax" class="form-control" maxlength="20">
                    </div>
                </div>
            </div>

            <!-- Delivery Information Column -->
            <div class="col-md-6">
                <h6 class="mb-3 border-bottom pb-2">Delivery Information</h6>
                
                <div class="mb-3">
                    <label class="form-label">Address</label>
                    <input type="text" name="delivery_address" class="form-control" maxlength="255">
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">City</label>
                        <input type="text" name="delivery_city" class="form-control" maxlength="255">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">State</label>
                        <input type="text" name="delivery_state" class="form-control" maxlength="255">
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">ZIP Code</label>
                        <input type="text" name="delivery_zip" class="form-control" maxlength="20">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Country</label>
                        <input type="text" name="delivery_country" class="form-control" maxlength="255">
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" name="delivery_phone" class="form-control" maxlength="20">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Fax</label>
                        <input type="text" name="delivery_fax" class="form-control" maxlength="20">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Save Customer</button>
    </div>
</form>
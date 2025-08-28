<form action="{{ route('master.customers.update', $customer->id) }}" method="POST">
    @csrf
    @method('PUT')


    <div class="modal-body">
        <!-- Basic Information -->
        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <label class="form-label">Customer Number</label>
                <input type="text" name="customer_number" class="form-control" value="{{ $customer->customer_number }}" required>
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="customer_name" class="form-control" value="{{ $customer->customer_name }}" required>
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Email</label>
                <input type="text" name="email" class="form-control" value="{{ $customer->email }}" required>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-12">
            <label class="form-label d-block mb-2">Receive Quote Via</label>
            @php
                $receiveQuoteVia = is_array($customer->receive_quote_via)
                ? $customer->receive_quote_via
                : (json_decode($customer->receive_quote_via, true) ?? []);
            @endphp
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="receive_quote_via[]" id="receive_quote_email" value="email" {{ in_array('email', $receiveQuoteVia) ? 'checked' : '' }}>
                <label class="form-check-label" for="receive_quote_email">Email</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="receive_quote_via[]" id="receive_quote_sms" value="sms" {{ in_array('sms', $receiveQuoteVia) ? 'checked' : '' }}>
                <label class="form-check-label" for="receive_quote_sms">Text (SMS)</label>
            </div>
            <div class="form-text">Tick either or both. If SMS is ticked, quotes will be sent via text.</div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-6 mb-3">
                <label class="form-label">Tier</label>
                <select name="tier_id" class="form-control">
                    @foreach($tiers as $tier)
                    <option value="{{ $tier->id }}" {{ $customer->tier_id == $tier->id ? 'selected' : '' }}>{{ $tier->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-control">
                    <option value="active" {{ $customer->status == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ $customer->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
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
                    <input type="text" name="billing_address" class="form-control" value="{{ $customer->billing_address }}" maxlength="255">
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">City</label>
                        <input type="text" name="billing_city" class="form-control" value="{{ $customer->billing_city }}" maxlength="255">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">State</label>
                        <input type="text" name="billing_state" class="form-control" value="{{ $customer->billing_state }}" maxlength="255">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">ZIP Code</label>
                        <input type="text" name="billing_zip" class="form-control" value="{{ $customer->billing_zip }}" maxlength="20">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Country</label>
                        <input type="text" name="billing_country" class="form-control" value="{{ $customer->billing_country }}" maxlength="255">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" name="billing_phone" class="form-control" value="{{ $customer->billing_phone }}" maxlength="20">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Fax</label>
                        <input type="text" name="billing_fax" class="form-control" value="{{ $customer->billing_fax }}" maxlength="20">
                    </div>
                </div>
            </div>

            <!-- Delivery Information Column -->
            <div class="col-md-6">
                <h6 class="mb-3 border-bottom pb-2">Delivery Information</h6>

                <div class="mb-3">
                    <label class="form-label">Address</label>
                    <input type="text" name="delivery_address" class="form-control" value="{{ $customer->delivery_address }}" maxlength="255">
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">City</label>
                        <input type="text" name="delivery_city" class="form-control" value="{{ $customer->delivery_city }}" maxlength="255">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">State</label>
                        <input type="text" name="delivery_state" class="form-control" value="{{ $customer->delivery_state }}" maxlength="255">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">ZIP Code</label>
                        <input type="text" name="delivery_zip" class="form-control" value="{{ $customer->delivery_zip }}" maxlength="20">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Country</label>
                        <input type="text" name="delivery_country" class="form-control" value="{{ $customer->delivery_country }}" maxlength="255">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" name="delivery_phone" class="form-control" value="{{ $customer->delivery_phone }}" maxlength="20">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Fax</label>
                        <input type="text" name="delivery_fax" class="form-control" value="{{ $customer->delivery_fax }}" maxlength="20">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Update Customer</button>
    </div>
</form>

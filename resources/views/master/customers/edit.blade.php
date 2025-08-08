
            <form method="POST" action="{{ route('master.customers.update', $customer->id) }}">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editCustomerLabel">Edit Customer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Customer Number</label>
                        <input type="text" name="customer_number" class="form-control" value="{{ $customer->customer_number }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" value="{{ $customer->name }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="text" name="email" class="form-control" value="{{ $customer->email }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tier</label>
                        <select name="tier" class="form-control">
                            @foreach($tiers as $tier)
                            <option value="{{ $tier->name }}" @if($tier->name == $customer->tier) selected @endif>{{ $tier->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Billing Address</label>
                        <input type="text" name="billing_address" class="form-control" maxlength="255" value="{{ $customer->billing_address }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Billing City</label>
                        <input type="text" name="billing_city" class="form-control" maxlength="255" value="{{ $customer->billing_city }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Billing State</label>
                        <input type="text" name="billing_state" class="form-control" maxlength="255" value="{{ $customer->billing_state }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Billing Zip</label>
                        <input type="text" name="billing_zip" class="form-control" maxlength="20" value="{{ $customer->billing_zip }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Billing Country</label>
                        <input type="text" name="billing_country" class="form-control" maxlength="255" value="{{ $customer->billing_country }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Billing Phone</label>
                        <input type="text" name="billing_phone" class="form-control" maxlength="20" value="{{ $customer->billing_phone }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Billing Fax</label>
                        <input type="text" name="billing_fax" class="form-control" maxlength="20" value="{{ $customer->billing_fax }}">
                    </div>
                    <hr>
                    <div class="mb-3">
                        <label class="form-label">Delivery Address</label>
                        <input type="text" name="delivery_address" class="form-control" maxlength="255" value="{{ $customer->delivery_address }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Delivery City</label>
                        <input type="text" name="delivery_city" class="form-control" maxlength="255" value="{{ $customer->delivery_city }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Delivery State</label>
                        <input type="text" name="delivery_state" class="form-control" maxlength="255" value="{{ $customer->delivery_state }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Delivery Zip</label>
                        <input type="text" name="delivery_zip" class="form-control" maxlength="20" value="{{ $customer->delivery_zip }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Delivery Country</label>
                        <input type="text" name="delivery_country" class="form-control" maxlength="255" value="{{ $customer->delivery_country }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Delivery Phone</label>
                        <input type="text" name="delivery_phone" class="form-control" maxlength="20" value="{{ $customer->delivery_phone }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Delivery Fax</label>
                        <input type="text" name="delivery_fax" class="form-control" maxlength="20" value="{{ $customer->delivery_fax }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-control">
                            <option value="active" @if($customer->status == 'active') selected @endif>Active</option>
                            <option value="inactive" @if($customer->status == 'inactive') selected @endif>Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Update Customer</button>
                </div>
            </form>
   
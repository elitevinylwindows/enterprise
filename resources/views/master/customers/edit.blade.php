<div class="modal fade" id="editCustomerModal" tabindex="-1" aria-labelledby="editCustomerLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form method="POST" action="{{ route('executives.customers.update', $customer->id) }}">
        @csrf
        @method('PUT')
        <div class="modal-header">
          <h5 class="modal-title" id="editCustomerLabel">Edit Customer</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">Customer Number</label>
              <input type="text" name="customer_number" class="form-control" value="{{ $customer->customer_number }}" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Customer Name</label>
              <input type="text" name="name" class="form-control" value="{{ $customer->customer_name }}" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Customer Email</label>
              <input type="text" name="email" class="form-control" value="{{ $customer->email }}" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Street</label>
              <input type="text" name="street" class="form-control" value="{{ $customer->street }}">
            </div>
            <div class="col-md-3">
              <label class="form-label">City</label>
              <input type="text" name="city" class="form-control" value="{{ $customer->city }}">
            </div>
            <div class="col-md-3">
              <label class="form-label">ZIP Code</label>
              <input type="text" name="zip" class="form-control" value="{{ $customer->zip }}">
            </div>
            <div class="col-md-6">
              <label class="form-label">Tier</label>
              <select name="tier_id" class="form-control">
                @foreach ($tiers as $tier)
                  <option value="{{ $tier->id }}" @if($tier->id == $customer->tier_id) selected @endif>
                    {{ $tier->name }}
                  </option>
                @endforeach
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label">Status</label>
              <select name="status" class="form-control">
                <option value="active" @if($customer->status === 'active') selected @endif>Active</option>
                <option value="inactive" @if($customer->status === 'inactive') selected @endif>Inactive</option>
              </select>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Update Customer</button>
        </div>
      </form>
    </div>
  </div>
</div>

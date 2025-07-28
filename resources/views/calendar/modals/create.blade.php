<form action="{{ route('calendar.store') }}" method="POST">
    @csrf
    <div class="modal-body">
        
     
    
        <div class="mb-3">
            <label for="order_number" class="form-label">Order Number</label>
            <input type="text" name="order_number" class="form-control" required>
        </div>

<div class="mb-3">
            <label for="customer_name" class="form-label">Customer Name</label>
            <input type="text" name="customer_name" class="form-control" required>
        </div>
        
        <div class="mb-3">
            <label for="customer" class="form-label">Customer Number</label>
            <input type="text" name="customer" class="form-control" required>
        </div>
        
       <div class="form-group col-md-12">
    <div class="d-flex gap-4">
        <div class="form-check">
            <input class="form-check-input location-toggle" type="checkbox" id="use_shop">
            <label class="form-check-label" for="use_shop">
                {{ __('Use Shop Info') }}
            </label>
        </div>

        <div class="form-check">
            <input class="form-check-input location-toggle" type="checkbox" id="use_whittier">
            <label class="form-check-label" for="use_whittier">
                {{ __('Whittier Warehouse') }}
            </label>
        </div>

        <div class="form-check">
            <input class="form-check-input location-toggle" type="checkbox" id="use_other_location">
            <label class="form-check-label" for="use_other_location">
                {{ __('Other Location') }}
            </label>
        </div>
    </div>
</div>



 <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="text" class="form-control" id="email" name="email">
    </div>

 <div class="mb-3">
        <label for="contact_phone" class="form-label">Phone</label>
        <input type="text" class="form-control" id="contact_phone" name="contact_phone">
    </div>

    
          <div class="mb-3">
        <label for="address" class="form-label">Address</label>
        <input type="text" class="form-control" id="address" name="address">
    </div>

    <div class="mb-3">
        <label for="city" class="form-label">City</label>
        <input type="text" class="form-control" id="city" name="city">
    </div>

    <div class="mb-3">
        <label for="zip" class="form-label">Zip</label>
        <input type="text" class="form-control" id="zip" name="zip">
    </div>

        
        <div class="mb-3">
            <label for="delivery_date" class="form-label">Delivery Date</label>
            <input type="date" name="delivery_date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="timeframe" class="form-label">Time Frame</label>
            <input type="text" name="timeframe" class="form-control">
        </div>

        <div class="mb-3">
            <label for="comment" class="form-label">Description / Comment</label>
            <textarea name="comment" class="form-control" rows="3"></textarea>
        </div>
    </div>

    <div class="modal-footer">
        <button type="submit" class="btn btn-success">Save Event</button>
    </div>
</form>


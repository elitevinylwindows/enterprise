<form id="bulkCreateForm" action="{{ route('calendar.bulkCreate') }}" method="POST">
    @csrf
    
    {{-- Hidden inputs for all selected orders --}}
    @foreach ($orders as $order)
        <input type="hidden" name="order_numbers[]" value="{{ $order->order_number }}">
    @endforeach

    <div class="modal-body">
        <div class="alert alert-info">
            <strong>Selected Orders:</strong> {{ $orders->pluck('order_number')->join(', ') }}
        </div>

        <div class="mb-3">
            <label class="form-label">Customer Name</label>
            <input type="text" name="customer_name" class="form-control"
                   value="{{ $orders->first()->short_name ?? '' }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Customer Number</label>
            <input type="text" name="customer" class="form-control"
                   value="{{ $orders->first()->customer ?? '' }}" required>
        </div>

        <div class="form-group col-md-12 mb-3">
            <div class="d-flex gap-4">
                <div class="form-check">
                    <input class="form-check-input location-toggle" type="checkbox" id="use_shop">
                    <label class="form-check-label" for="use_shop">Use Shop Info</label>
                </div>

                <div class="form-check">
                    <input class="form-check-input location-toggle" type="checkbox" id="use_whittier">
                    <label class="form-check-label" for="use_whittier">Whittier Warehouse</label>
                </div>

                <div class="form-check">
                    <input class="form-check-input location-toggle" type="checkbox" id="use_other_location">
                    <label class="form-check-label" for="use_other_location">Other Location</label>
                </div>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="text" class="form-control" id="email" name="email" value="{{ $shop->email ?? '' }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Phone</label>
            <input type="text" class="form-control" id="contact_phone" name="contact_phone" value="{{ $shop->contact_phone ?? '' }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Address</label>
            <input type="text" class="form-control" id="address" name="address" value="{{ $shop->address ?? '' }}">
        </div>

        <div class="mb-3">
            <label class="form-label">City</label>
            <input type="text" class="form-control" id="city" name="city" value="{{ $shop->city ?? '' }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Zip</label>
            <input type="text" class="form-control" id="zip" name="zip" value="{{ $shop->zip ?? '' }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Delivery Date</label>
            <input type="date" name="delivery_date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Time Frame</label>
            <input type="text" name="timeframe" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Description / Comment</label>
            <textarea name="comment" class="form-control" rows="3"></textarea>
        </div>
    </div>

    <div class="modal-footer">
        <button type="submit" class="btn btn-success">Save Bulk Event</button>
    </div>
</form>
<script>
    $(document).on('submit', 'form[action="{{ route("calendar.bulkCreate") }}"]', function (e) {
        e.preventDefault();

        const $form = $(this);
        const url = $form.attr('action');
        const data = $form.serialize();

        $.post(url, data)
            .done(function () {
                $('#customModal').modal('hide');
                // Optional: redirect to calendar page manually
                window.location.href = '{{ route("calendar.index") }}';
            })
            .fail(function (xhr) {
                console.error(xhr.responseText);
                alert('Failed to save. Please check inputs.');
            });
    });
</script>

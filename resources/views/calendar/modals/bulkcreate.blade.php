@extends('layouts.app')

@section('page-title', 'Bulk Event')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Bulk Event</li>
@endsection

@section('content')
<form action="{{ route('calendar.bulkCreate') }}" method="POST">
    @csrf

    <input type="hidden" name="delivery_ids" value="{{ json_encode($delivery_ids) }}">

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>Customer Number</label>
                <input type="text" name="customer" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Customer Name</label>
                <input type="text" name="customer_name" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Delivery Date</label>
                <input type="date" name="delivery_date" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Timeframe</label>
                <input type="text" name="timeframe" class="form-control">
            </div>

            <div class="form-group">
                <label>Comment</label>
                <textarea name="comment" class="form-control" rows="3"></textarea>
            </div>
        </div>

        <div class="col-md-6">
            {{-- Location Toggles --}}
            <div class="form-group mb-3">
                <label>Delivery Location</label>
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
                        <label class="form-check-label" for="use_other_location">Other</label>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="text" name="email" id="email" class="form-control">
            </div>

            <div class="form-group">
                <label>Phone</label>
                <input type="text" name="contact_phone" id="contact_phone" class="form-control">
            </div>

            <div class="form-group">
                <label>Address</label>
                <input type="text" name="address" id="address" class="form-control">
            </div>

            <div class="form-group">
                <label>City</label>
                <input type="text" name="city" id="city" class="form-control">
            </div>

            <div class="form-group">
                <label>Zip</label>
                <input type="text" name="zip" id="zip" class="form-control">
            </div>
        </div>
    </div>

    <div class="mt-4 text-end">
        <button type="submit" class="btn btn-success">Create Bulk Events</button>
    </div>
</form>
@endsection

@push('scripts')
<script>
$(document).ready(function () {
    function clearFields() {
        $('#address, #city, #zip, #email, #contact_phone').val('').prop('readonly', false);
    }

    function fetchShopContact(customer, fillAll = true) {
        if (!customer) return;

        $.ajax({
            url: '{{ route("calendar.getShop") }}',
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            contentType: 'application/json',
            data: JSON.stringify({ customer }),
            success: function (data) {
                if (data.error) return;

                $('#email').val(data.email).prop('readonly', true);
                $('#contact_phone').val(data.contact_phone).prop('readonly', true);

                if (fillAll) {
                    $('#address').val(data.address).prop('readonly', true);
                    $('#city').val(data.city).prop('readonly', true);
                    $('#zip').val(data.zip).prop('readonly', true);
                }
            }
        });
    }

    $('.location-toggle').on('change', function () {
        $('.location-toggle').not(this).prop('checked', false);
        clearFields();

        const customer = $('input[name="customer"]').val();

        if (this.id === 'use_shop' && customer) fetchShopContact(customer, true);
        if (this.id === 'use_whittier') {
            $('#address').val('11648 Washington Blvd').prop('readonly', true);
            $('#city').val('Whittier').prop('readonly', true);
            $('#zip').val('90606').prop('readonly', true);
            if (customer) fetchShopContact(customer, false);
        }
        if (this.id === 'use_other_location') {
            $('#address, #city, #zip').prop('readonly', false);
            if (customer) fetchShopContact(customer, false);
        }
    });
});
</script>
@endpush

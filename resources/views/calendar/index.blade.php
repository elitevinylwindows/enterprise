@extends('layouts.app')

@section('page-title')
    {{ __('Delivery Calendar') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item" aria-current="page">{{ __('Calendar') }}</li>
    
@endsection




@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                        
                            <div class="col-auto">
                                <a href="#" class="btn btn-secondary customModal" data-size="md"
                                   data-url="{{ route('calendar.create') }}" data-title="{{ __('Create Event') }}">
                                    <i class="ti ti-circle-plus align-text-bottom"></i> {{ __('Create Event') }}
                                </a>
                            </div>
                        
  <div class="card-header border-bottom mb-3">
    <ul class="nav nav-pills gap-1" id="calendar-tabs">
        <li class="nav-item">
            <a class="nav-link active" href="#" data-filter="all">
                Deliveries <span class="badge bg-primary">{{ $totalDeliveries ?? 0 }}</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#" data-filter="pickup">
                Pickups <span class="badge bg-success">{{ $totalPickups ?? 0 }}</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#" data-filter="pending">
                Pending <span class="badge bg-warning text-dark">{{ $pendingCount ?? 0 }}</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#" data-filter="completed">
                Completed <span class="badge bg-success">{{ $completedCount ?? 0 }}</span>
            </a>
        </li>
    </ul>
</div>


                <div id="calendar" style="min-height: 400px;"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.8/index.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.8/index.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/timegrid@6.1.8/index.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/interaction@6.1.8/index.global.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('calendar');
    const allEvents = @json($allEvents);
    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        editable: true,
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        events: allEvents,

        eventClick: function(info) {
            const date = info.event.startStr;
            window.location.href = `/calendar/deliveries/${date}`;
        },

        eventDrop: function (info) {
            $.ajax({
                url: '{{ route("calendar.updateDate") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    order_number: info.event.title,
                    delivery_date: info.event.startStr
                },
                success: function () {
                    toastr.success('Delivery date updated');
                },
                error: function () {
                    toastr.error('Failed to update delivery date');
                    info.revert();
                }
            });
        }
    });

    // ✅ Modal logic
    $(document).on('shown.bs.modal', function () {
        const emailField = $('#email');
        const phoneField = $('#contact_phone');
        const addressField = $('#address');
        const cityField = $('#city');
        const zipField = $('#zip');

        function clearFields() {
            emailField.val('').prop('readonly', false);
            phoneField.val('').prop('readonly', false);
            addressField.val('').prop('readonly', false);
            cityField.val('').prop('readonly', false);
            zipField.val('').prop('readonly', false);
        }

        function fetchShopContact(callback = () => {}) {
            const customer = $('input[name="customer"]').val();
            if (!customer) return;

            $.ajax({
                url: '{{ route("calendar.getShop") }}',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                data: JSON.stringify({ customer }),
                success: function (data) {
                    if (!data.error) {
                        emailField.val(data.email).prop('readonly', true);
                        phoneField.val(data.contact_phone).prop('readonly', true);
                        callback(data);
                    } else {
                        toastr.error(data.error);
                    }
                },
                error: function () {
                    toastr.error('Failed to fetch shop info.');
                }
            });
        }

        // Exclusive checkbox toggle
        $('.location-toggle').off('change').on('change', function () {
            $('.location-toggle').not(this).prop('checked', false);
            clearFields();

            const customer = $('input[name="customer"]').val();

            if (this.id === 'use_shop' && this.checked && customer) {
                fetchShopContact(function (data) {
                    addressField.val(data.address).prop('readonly', true);
                    cityField.val(data.city).prop('readonly', true);
                    zipField.val(data.zip).prop('readonly', true);
                });
            }

            if (this.id === 'use_whittier' && this.checked) {
                addressField.val('11648 Washington Blvd').prop('readonly', true);
                cityField.val('Whittier').prop('readonly', true);
                zipField.val('90606').prop('readonly', true);
                if (customer) fetchShopContact(); // fill only contact
            }

            if (this.id === 'use_other_location' && this.checked) {
                addressField.prop('readonly', false);
                cityField.prop('readonly', false);
                zipField.prop('readonly', false);
                if (customer) fetchShopContact(); // fill only contact
            }
        });

        // ✅ Autofill order number
        $('input[name="order_number"]').off('blur').on('blur', function () {
            const orderNumber = $(this).val();
            if (!orderNumber) return;

            $.get('/calendar/order-details/' + orderNumber, function (data) {
                if (!data.error) {
                    $('input[name="customer_name"]').val(data.customer_name || '');
                    $('input[name="customer"]').val(data.customer || '');
                    $('textarea[name="comment"]').val(data.comment || '');
                    $('input[name="city"]').val(data.city || '');
                } else {
                    toastr.error(data.error);
                }
            }).fail(function () {
                toastr.error('Order not found.');
            });
        });
    });

    calendar.render();

    // Filters
    document.querySelectorAll('#calendar-tabs .nav-link').forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            document.querySelectorAll('#calendar-tabs .nav-link').forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');

            const filter = this.dataset.filter;
            let filteredEvents = allEvents;

            if (filter === 'pickup') {
                filteredEvents = allEvents.filter(e => e.type === 'pickup');
            } else if (filter === 'pending') {
                filteredEvents = allEvents.filter(e => e.status === 'pending');
            } else if (filter === 'completed') {
                filteredEvents = allEvents.filter(e => e.status === 'completed');
            }

            calendar.removeAllEvents();
            calendar.addEventSource(filteredEvents);
        });
    });
});
</script>
@endpush

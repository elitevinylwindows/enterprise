@extends('layouts.app')

@section('page-title')
    {{ __('Route Map') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item" aria-current="page">{{ __('Route Map') }}</li>
    
@endsection


@section('content')
<div class="row">
    <div class="col-sm-12">
<div class="card mb-4">
    <div class="card-body" style="height: 500px;">
        <div id="map" style="width: 100%; height: 100%;"></div>
    </div>
</div>

<div class="row">
    @foreach ($routes as $route)
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-header bg-primary text-white">
                    <strong>Truck: {{ $route['truck_id'] }}</strong> <br>
                    Driver: {{ $route['driver'] }}
                </div>
                <div class="card-body overflow-auto" style="max-height: 300px;">
                    <ol class="list-group list-group-numbered">
                        <li class="list-group-item">Base: {{ $warehouseAddress }}</li>
                      @foreach ($route['stops'] as $stop)
<li class="list-group-item d-flex justify-content-between align-items-start" data-stop-id="{{ $stop['id'] }}">
    <div class="me-2">
        <strong>{{ $stop['customer'] }}</strong><br>
        {{ $stop['address'] }}, 
        {{ $stop['city'] }}<br>
        {{ $stop['contact'] }}<br>
        Order #: {{ $stop['order'] }}<br>
        <span class="badge bg-info stop-status">{{ ucfirst($stop['status']) }}</span>
    </div>

    <div class="text-end">
        <a href="https://www.google.com/maps/dir/?api=1&origin={{ urlencode($warehouseAddress) }}&destination={{ urlencode($stop['address']) }}"
           target="_blank" class="btn btn-sm btn-outline-primary go-btn">Go</a>

        <div class="status-options d-none mt-1">
            <button class="btn btn-sm btn-success delivered-btn">Delivered</button>
            <button class="btn btn-sm btn-danger cancelled-btn">Cancelled</button>
        </div>
    </div>
</li>
@endforeach

                        <li class="list-group-item">Return: {{ $warehouseAddress }}</li>
                    </ol>
                </div>
            </div>
        </div>
    @endforeach
</div>
</div>
</div>
@endsection



@push('scripts')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCPhMXb_6VAGwwSMYj9S1udEO027E3BZT0"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const warehouse = "{{ $warehouseAddress }}";
    const map = new google.maps.Map(document.getElementById('map'), {
        zoom: 10,
        center: { lat: 33.950, lng: -118.200 },
        styles: {!! json_encode($mapStyle) !!}
    });

    const colors = ['#FF0000', '#0000FF', '#008000', '#FFA500', '#800080', '#00CED1', '#DC143C']; // red, blue, green, etc.
    let colorIndex = 0;

    const geocoder = new google.maps.Geocoder();

    @foreach ($routes as $route)
        (function(route, color) {
            const stops = [
                { address: warehouse, label: "Base" },
                @foreach ($route['stops'] as $stop)
                    { address: "{{ $stop['address'] }}, {{ $stop['city'] }}", label: "Truck {{ $route['truck_name'] }}" },
                @endforeach
                { address: warehouse, label: "Return Base" }
            ];

            const routeCoords = [];

            function geocodeStop(index) {
                if (index >= stops.length) {
                    const polyline = new google.maps.Polyline({
                        path: routeCoords,
                        geodesic: true,
                        strokeColor: color,
                        strokeOpacity: 1.0,
                        strokeWeight: 2
                    });
                    polyline.setMap(map);
                    return;
                }

                const stop = stops[index];
                geocoder.geocode({ address: stop.address }, function(results, status) {
                    if (status === 'OK') {
                        const location = results[0].geometry.location;
                        routeCoords.push(location);

                        new google.maps.Marker({
                            map: map,
                            position: location,
                            label: `${index}`,
                            title: stop.label
                        });

                        geocodeStop(index + 1);
                    } else {
                        console.error('Geocode failed for:', stop.address, status);
                        geocodeStop(index + 1); // continue to next stop even if one fails
                    }
                });
            }

            geocodeStop(0);
        })(@json($route), colors[colorIndex++ % colors.length]);
    @endforeach
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Existing map logic ...

    // Button interactivity logic
    $('.go-btn').on('click', function () {
        const parent = $(this).closest('li');
        $(this).hide(); // hide the "Go" button
        parent.find('.status-options').removeClass('d-none');
    });

    $('.delivered-btn, .cancelled-btn').on('click', function () {
        const parent = $(this).closest('li');
        const stopId = parent.data('stop-id');
        const status = $(this).hasClass('delivered-btn') ? 'delivered' : 'cancelled';

        $.ajax({
            url: '{{ route("route.updateStatus") }}',
            method: 'POST',
            data: {
                stop_id: stopId,
                status: status,
                _token: '{{ csrf_token() }}'
            },
            success: function () {
                parent.find('.stop-status').text(status.charAt(0).toUpperCase() + status.slice(1));
                parent.find('.status-options').hide();
            },
            error: function () {
                alert('Failed to update status.');
            }
        });
    });
});
</script>
<script>
    $(document).on('click', '.mark-delivered-btn', function () {
        const deliveryId = $(this).data('id');
        const status = $(this).data('status');
        const buttonGroup = $(this).closest('.btn-group');

        $.ajax({
            url: '{{ route("route.updateStatus") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                id: deliveryId,
                status: status
            },
            success: function (response) {
                alert('Status updated to ' + status);
                buttonGroup.find('.mark-delivered-btn').remove(); // Only hide extra buttons
            },
            error: function () {
                alert('Failed to update status.');
            }
        });
    });
</script>

@endpush

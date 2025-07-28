@extends('layouts.app')

@section('page-title', 'Plan Route')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
<li class="breadcrumb-item active">Plan Route</li>
@endsection

@section('content')
<div class="row mb-3">
    <div class="col d-flex justify-content-between align-items-center">
        <h5 class="mb-2">Planned Route Optimiser</h5>
        <button class="btn btn-primary" onclick="$('#createPlannedRouteModal').modal('show')">Create Planned Route</button>
    </div>
</div>




<div id="map" class="mb-4 rounded shadow-sm" style="height: 400px;"></div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@forelse ($groupedRoutes as $date => $routes)
    <div class="card my-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0 fw-bold">Routes for {{ \Carbon\Carbon::parse($date)->format('F j, Y') }}</h4>
            <div class="d-flex gap-2">
                <form action="{{ route('routes.plan.reset', ['date' => $date]) }}" method="POST">@csrf
                    <button type="submit" class="btn btn-sm btn-secondary">Reset</button>
                </form>
                <form action="{{ route('routes.plan.generate', ['date' => $date]) }}" method="POST">@csrf
                    <button type="submit" class="btn btn-sm btn-primary">Generate</button>
                </form>
                
               <a href="javascript:void(0);" class="btn btn-sm btn-dark load-map-btn"
   data-date="{{ $date }}"
   data-routes='@json($routes)'>
   See on Map
</a>


                
                
                <form action="{{ route('routes.plan.moveToAuto', ['date' => $date]) }}" method="POST" onsubmit="return confirm('Move these routes to Auto Route for tomorrow?')">@csrf
                    <button type="submit" class="btn btn-sm btn-warning">Move to Auto</button>
                </form>
            </div>
        </div>
        <div class="card-body">
            <div class="row" id="truck-routes-{{ $date }}">
                @foreach ($routes as $route)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <div class="card-header text-white" style="background-color: #A80000;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>Truck: {{ $route['truck_id'] }}</strong><br>
                                        Driver: {{ $route['driver'] ?? 'N/A' }}
                                    </div>
                                    <a href="{{ route('routes.pdf', ['truck' => $route['truck_id'], 'date' => $date]) }}"
                                           class="btn btn-sm btn-white text-white"
                                           target="_blank" title="Show Route PDF">
                                            <i data-feather="eye"></i>
                                        </a>
                                    <a href="#" class="btn btn-sm btn-outline-light text-white"
                                       onclick='openGoogleRoute("{{ addslashes($warehouseAddress) }}", {!! json_encode(array_map(fn($s) => $s["address"] . ", " . $s["city"], $route["stops"])) !!})'>
                                        Start Route
                                    </a>
                                </div>
                            </div>

                           <div class="card-body overflow-auto" style="max-height: 350px;">
    <ol class="sortable list-group list-group-numbered"
        data-truck="{{ $route['truck_id'] }}"
        data-driver="{{ $route['driver_id'] }}">
        <li class="list-group-item static-stop">Base: {{ $warehouseAddress }}</li>

        @foreach ($route['stops'] as $stop)
    <li class="list-group-item sortable-stop d-flex flex-column gap-2"
        data-ids='@json($stop["ids"])'
        style="word-wrap: break-word; max-width: 100%;">
        
        <div class="fw-bold">
    {{ $stop['label'] ?? '—' }} - {{ $stop['customer_name'] ?? 'Unknown' }}
</div>


        <div style="font-size: 0.85rem;">
            <div><strong>Address:</strong> {{ $stop['address'] }}, {{ $stop['city'] }}</div>
            <div><strong>Contact:</strong> {{ $stop['contact'] ?? 'N/A' }}</div>
            <div><strong>Orders:</strong> {{ implode(', ', $stop['order_numbers']) }}</div>
            <div>
                <span class="badge bg-info stop-status">{{ ucfirst($stop['status']) }}</span>
            </div>
        </div>

        <div class="d-flex mt-2 align-items-center gap-2">
            <a href="https://www.google.com/maps/dir/?api=1&origin={{ urlencode($warehouseAddress) }}&destination={{ urlencode($stop['address']) }}&travelmode=driving"
               target="_blank" class="btn btn-sm text-white" style="background-color:#A80000;">Go</a>
            @if($stop['contact'])
                <a href="tel:{{ $stop['contact'] }}" class="btn btn-sm text-white" style="background-color:#A80000;" title="Call">
                    <i class="ti ti-phone"></i>
                </a>
            @endif
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
@empty
    <p class="text-muted">No deliveries found.</p>
@endforelse

@include('routes.modals.create-planned-route')
@endsection

@push('scripts')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

<script>
function openGoogleRoute(origin, stops) {
    if (!origin || stops.length === 0) return;
    const base = 'https://www.google.com/maps/dir/?api=1';
    const destination = encodeURIComponent(stops[stops.length - 1]);
    const waypoints = stops.slice(0, -1).map(encodeURIComponent).join('|');
    const url = `${base}&origin=${encodeURIComponent(origin)}&destination=${destination}&travelmode=driving&waypoints=${waypoints}`;
    window.open(url, '_blank');
}

$(function () {
    $('.sortable').sortable({
        connectWith: '.sortable',
        placeholder: 'ui-state-highlight',
        items: 'li.sortable-stop',
        receive: handleSort,
        update: handleSort
    }).disableSelection();
});

function handleSort(event, ui) {
    if (this !== ui.item.parent()[0]) return;

    const $list = $(this);
    const truckId = $list.data('truck');
    const driverId = $list.data('driver');

    const order = $list.children('li.sortable-stop').map(function () {
        const raw = $(this).data('ids');
        return raw ? raw.toString().split(',') : [];
    }).get();

    $.ajax({
        url: '{{ route("routes.reorder") }}',
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        data: {
            truck_number: truckId,
            driver_id: driverId,
            order: order
        },
        success: function (res) {
            toastr.success(res.message || 'Route updated');
        },
        error: function () {
            toastr.error('Failed to update route');
        }
    });
}
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCPhMXb_6VAGwwSMYj9S1udEO027E3BZT0&libraries=places"></script>

<script>
let map, geocoder, colorIndex = 0;

function initMap() {
    map = new google.maps.Map(document.getElementById('map'), {
        zoom: 10,
        center: { lat: 34.0522, lng: -118.2437 }
    });
    geocoder = new google.maps.Geocoder();
}

function renderRoutes(routes, warehouseAddress) {
    map = new google.maps.Map(document.getElementById('map'), {
        zoom: 10,
        center: { lat: 34.0522, lng: -118.2437 }
    });

    const colors = ['#FF0000', '#0000FF', '#008000', '#FFA500', '#800080', '#00CED1', '#DC143C'];
    colorIndex = 0;

    routes.forEach(route => {
        const stops = [
            { address: warehouseAddress, label: "Base" },
            ...route.stops.map(stop => ({
                address: stop.address + ', ' + stop.city,
                label: stop.label || '',
                title: 'Stop: ' + stop.customer_name
            })),
            { address: warehouseAddress, label: "Return Base" }
        ];

        const routeCoords = [];

        function geocodeStop(index) {
            if (index >= stops.length) {
                const polyline = new google.maps.Polyline({
                    path: routeCoords,
                    geodesic: true,
                    strokeColor: colors[colorIndex % colors.length],
                    strokeOpacity: 1.0,
                    strokeWeight: 3
                });
                polyline.setMap(map);
                colorIndex++;
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
                        label: stop.label || `${index}`,
                        title: stop.title || stop.label || ''
                    });
                    geocodeStop(index + 1);
                } else {
                    geocodeStop(index + 1); // Skip failed stop
                }
            });
        }

        geocodeStop(0);
    });
}

$(document).ready(function () {
    initMap();

    $('.load-map-btn').on('click', function () {
        const routes = $(this).data('routes');
        const warehouse = @json($warehouseAddress);
        renderRoutes(routes, warehouse);
    });
});
</script>

@endpush

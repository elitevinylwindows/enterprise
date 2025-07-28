@extends('layouts.app')

@section('page-title', 'Route Map')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
<li class="breadcrumb-item"><a href="{{ route('routes.plan') }}">Planned Routes</a></li>
<li class="breadcrumb-item active">Map View</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <h5 class="mb-3">Route Map for {{ \Carbon\Carbon::parse($date)->format('F j, Y') }}</h5>
        <div id="map" style="height: 600px;" class="rounded shadow-sm"></div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCPhMXb_6VAGwwSMYj9S1udEO027E3BZT0&libraries=places"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const map = new google.maps.Map(document.getElementById('map'), {
        zoom: 10,
        center: { lat: 34.0522, lng: -118.2437 }, // Fallback center: Los Angeles
    });

    const warehouse = "{{ $warehouseAddress }}";
    const geocoder = new google.maps.Geocoder();
    const colors = ['#FF0000', '#0000FF', '#008000', '#FFA500', '#800080', '#00CED1', '#DC143C'];
    let colorIndex = 0;

    @foreach ($groupedRoutes as $routes)
        @foreach ($routes as $route)
            (function(route, color) {
                const stops = [
                    { address: warehouse, label: "Base" },
                    @foreach ($route['stops'] as $stop)
                        {
                            address: "{{ $stop['address'] }}, {{ $stop['city'] }}",
                            label: "{{ $stop['label'] ?? '' }}",
                            title: "Stop: {{ $stop['customer'] }}"
                        },
                    @endforeach
                    { address: warehouse, label: "Return Base" }
                ];

                const path = [];

                function geocodeStop(index) {
                    if (index >= stops.length) {
                        const polyline = new google.maps.Polyline({
                            path: path,
                            geodesic: true,
                            strokeColor: color,
                            strokeOpacity: 1.0,
                            strokeWeight: 3
                        });
                        polyline.setMap(map);
                        return;
                    }

                    const stop = stops[index];
                    geocoder.geocode({ address: stop.address }, function(results, status) {
                        if (status === 'OK') {
                            const loc = results[0].geometry.location;
                            path.push(loc);
                            new google.maps.Marker({
                                map: map,
                                position: loc,
                                label: stop.label || `${index}`,
                                title: stop.title || stop.address
                            });
                            if (index === 0) map.setCenter(loc);
                            geocodeStop(index + 1);
                        } else {
                            geocodeStop(index + 1); // continue even if one fails
                        }
                    });
                }

                geocodeStop(0);
            })(@json($route), colors[colorIndex++ % colors.length]);
        @endforeach
    @endforeach
});
</script>
@endpush

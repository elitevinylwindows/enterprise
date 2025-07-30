

<?php $__env->startSection('page-title', 'Plan Route'); ?>

<?php $__env->startSection('breadcrumb'); ?>
<li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>">Dashboard</a></li>
<li class="breadcrumb-item active">Plan Route</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row mb-3">
    <div class="col d-flex justify-content-between align-items-center">
        <h5 class="mb-2">Planned Route Optimiser</h5>
        <button class="btn btn-primary" onclick="$('#createPlannedRouteModal').modal('show')">Create Planned Route</button>
    </div>
</div>




<div id="map" class="mb-4 rounded shadow-sm" style="height: 400px;"></div>

<?php if(session('success')): ?>
    <div class="alert alert-success"><?php echo e(session('success')); ?></div>
<?php endif; ?>

<?php $__empty_1 = true; $__currentLoopData = $groupedRoutes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date => $routes): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <div class="card my-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0 fw-bold">Routes for <?php echo e(\Carbon\Carbon::parse($date)->format('F j, Y')); ?></h4>
            <div class="d-flex gap-2">
                <form action="<?php echo e(route('routes.plan.reset', ['date' => $date])); ?>" method="POST"><?php echo csrf_field(); ?>
                    <button type="submit" class="btn btn-sm btn-secondary">Reset</button>
                </form>
                <form action="<?php echo e(route('routes.plan.generate', ['date' => $date])); ?>" method="POST"><?php echo csrf_field(); ?>
                    <button type="submit" class="btn btn-sm btn-primary">Generate</button>
                </form>
                
               <a href="javascript:void(0);" class="btn btn-sm btn-dark load-map-btn"
   data-date="<?php echo e($date); ?>"
   data-routes='<?php echo json_encode($routes, 15, 512) ?>'>
   See on Map
</a>


                
                
                <form action="<?php echo e(route('routes.plan.moveToAuto', ['date' => $date])); ?>" method="POST" onsubmit="return confirm('Move these routes to Auto Route for tomorrow?')"><?php echo csrf_field(); ?>
                    <button type="submit" class="btn btn-sm btn-warning">Move to Auto</button>
                </form>
            </div>
        </div>
        <div class="card-body">
            <div class="row" id="truck-routes-<?php echo e($date); ?>">
                <?php $__currentLoopData = $routes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $route): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <div class="card-header text-white" style="background-color: #A80000;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>Truck: <?php echo e($route['truck_id']); ?></strong><br>
                                        Driver: <?php echo e($route['driver'] ?? 'N/A'); ?>

                                    </div>
                                    <a href="<?php echo e(route('routes.pdf', ['truck' => $route['truck_id'], 'date' => $date])); ?>"
                                           class="btn btn-sm btn-white text-white"
                                           target="_blank" title="Show Route PDF">
                                            <i data-feather="eye"></i>
                                        </a>
                                    <a href="#" class="btn btn-sm btn-outline-light text-white"
                                       onclick='openGoogleRoute("<?php echo e(addslashes($warehouseAddress)); ?>", <?php echo json_encode(array_map(fn($s) => $s["address"] . ", " . $s["city"], $route["stops"])); ?>)'>
                                        Start Route
                                    </a>
                                </div>
                            </div>

                           <div class="card-body overflow-auto" style="max-height: 350px;">
    <ol class="sortable list-group list-group-numbered"
        data-truck="<?php echo e($route['truck_id']); ?>"
        data-driver="<?php echo e($route['driver_id']); ?>">
        <li class="list-group-item static-stop">Base: <?php echo e($warehouseAddress); ?></li>

        <?php $__currentLoopData = $route['stops']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stop): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <li class="list-group-item sortable-stop d-flex flex-column gap-2"
        data-ids='<?php echo json_encode($stop["ids"], 15, 512) ?>'
        style="word-wrap: break-word; max-width: 100%;">
        
        <div class="fw-bold">
    <?php echo e($stop['label'] ?? '—'); ?> - <?php echo e($stop['customer_name'] ?? 'Unknown'); ?>

</div>


        <div style="font-size: 0.85rem;">
            <div><strong>Address:</strong> <?php echo e($stop['address']); ?>, <?php echo e($stop['city']); ?></div>
            <div><strong>Contact:</strong> <?php echo e($stop['contact'] ?? 'N/A'); ?></div>
            <div><strong>Orders:</strong> <?php echo e(implode(', ', $stop['order_numbers'])); ?></div>
            <div>
                <span class="badge bg-info stop-status"><?php echo e(ucfirst($stop['status'])); ?></span>
            </div>
        </div>

        <div class="d-flex mt-2 align-items-center gap-2">
            <a href="https://www.google.com/maps/dir/?api=1&origin=<?php echo e(urlencode($warehouseAddress)); ?>&destination=<?php echo e(urlencode($stop['address'])); ?>&travelmode=driving"
               target="_blank" class="btn btn-sm text-white" style="background-color:#A80000;">Go</a>
            <?php if($stop['contact']): ?>
                <a href="tel:<?php echo e($stop['contact']); ?>" class="btn btn-sm text-white" style="background-color:#A80000;" title="Call">
                    <i class="ti ti-phone"></i>
                </a>
            <?php endif; ?>
        </div>
    </li>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


        <li class="list-group-item">Return: <?php echo e($warehouseAddress); ?></li>
    </ol>
</div>


                                 
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <p class="text-muted">No deliveries found.</p>
<?php endif; ?>

<?php echo $__env->make('routes.modals.create-planned-route', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
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
        url: '<?php echo e(route("routes.reorder")); ?>',
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>' },
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
        const warehouse = <?php echo json_encode($warehouseAddress, 15, 512) ?>;
        renderRoutes(routes, warehouse);
    });
});
</script>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home4/aizwmjte/sr.elitevinylwindows.com/resources/views/routes/plan.blade.php ENDPATH**/ ?>
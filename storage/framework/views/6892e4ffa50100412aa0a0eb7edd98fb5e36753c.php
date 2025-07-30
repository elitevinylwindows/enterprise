

<?php $__env->startSection('page-title', 'Auto Route'); ?>

<?php $__env->startSection('breadcrumb'); ?>
<li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>">Dashboard</a></li>
<li class="breadcrumb-item active">Auto Route</li>
<?php $__env->stopSection(); ?>




















<?php $__env->startSection('content'); ?>
<div class="row mb-3">
    <div class="col">
        <h5 class="mb-2">Auto Route Optimiser</h5>
    </div>
    <div class="col-auto">
        <a href="<?php echo e(route('routes.generate')); ?>" class="btn text-white" style="background-color: #A80000;">
            <i class="ti ti-map-pin"></i> Generate Routes
        </a>
        <form action="<?php echo e(route('routes.reset')); ?>" method="POST" class="d-inline">
            <?php echo csrf_field(); ?>
            <button type="submit" class="btn text-white" style="background-color: #A80000;">
                Reset Assignments
            </button>
        </form>
    </div>
</div>

<div id="map" class="mb-4 rounded shadow-sm" style="height: 400px;"></div>

<?php if(session('success')): ?>
    <div class="alert alert-success"><?php echo e(session('success')); ?></div>
<?php endif; ?>

<div class="row mt-4" id="truck-routes">
<?php $__currentLoopData = $groupedRoutes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date => $routes): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="card my-4">
        <div class="card-header">
            Routes for <?php echo e(\Carbon\Carbon::parse($date)->format('F j, Y')); ?>

        </div>
        <div class="card-body">
            <div class="row" id="truck-routes-<?php echo e($date); ?>">
                <?php $__currentLoopData = $routes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $route): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-6 mb-4">
                        <div class="card h-100">
                            
                            <div class="card-header text-white" style="background-color: #A80000;">
                                <div class="d-flex justify-content-between align-items-center w-100">
                                    <div>
                                        <strong>Truck: <?php echo e($route['truck_number']); ?></strong><br>
                                        Driver: <?php echo e($route['driver'] ?? 'N/A'); ?>

                                    </div>
                                    <div class="d-flex gap-1">
                                        <a href="<?php echo e(route('routes.pdf', ['truck' => $route['truck_number'], 'date' => $date])); ?>"
                                           class="btn btn-sm btn-white text-white"
                                           target="_blank" title="Show Route PDF">
                                            <i data-feather="eye"></i>
                                        </a>
                                        <a href="#"
                                           class="btn btn-sm btn-outline-light text-white"
                                           onclick='openGoogleRoute("<?php echo e(addslashes($warehouseAddress)); ?>", <?php echo json_encode(array_map(fn($s) => $s["address"] . ", " . $s["city"], $route["stops"])); ?>)'>
                                            Start Route
                                        </a>
                                    </div>
                                </div>
                            </div>

                            
                            <div class="card-body bg-white text-dark overflow-auto" style="max-height: 350px;">
                                <ol class="sortable list-group list-group-numbered"
                                    data-truck="<?php echo e($route['truck_number']); ?>"
                                    data-driver="<?php echo e($route['driver_id']); ?>">
                                    <li class="list-group-item static-stop">Base: <?php echo e($warehouseAddress); ?></li>

                                    <?php $__currentLoopData = $route['stops']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stop): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li class="list-group-item sortable-stop d-flex justify-content-between align-items-start flex-column"
                                            data-ids='<?php echo json_encode($stop["ids"], 15, 512) ?>'>
                                            <div class="fw-bold">
                                                <?php echo e($stop['label'] ?? $loop->iteration); ?> - <?php echo e($stop['customer']); ?>

                                            </div>
                                            <div class="me-2">
                                                <?php echo e($stop['address']); ?>, <?php echo e($stop['city']); ?><br>
                                                <?php echo e($stop['contact'] ?? ''); ?><br>
                                                Orders: <?php echo e(implode(', ', $stop['order_numbers'])); ?><br>
                                                <span class="badge bg-info stop-status"><?php echo e(ucfirst($stop['status'])); ?></span>
                                            </div>
                                            <div class="d-flex mt-2 align-items-center gap-2">
                                                <a href="https://www.google.com/maps/dir/?api=1&origin=<?php echo e(urlencode($warehouseAddress)); ?>&destination=<?php echo e(urlencode($stop['address'])); ?>"
                                                   target="_blank" class="btn btn-sm text-white" style="background-color:#A80000;">Go</a>
                                                <?php if($stop['contact']): ?>
                                                    <a href="tel:<?php echo e($stop['contact']); ?>" class="btn btn-sm text-white" style="background-color:#A80000;" title="Call">
                                                        <i class="ti ti-phone"></i>
                                                    </a>
                                                <?php endif; ?>
                                                <div class="status-options d-none mt-2">
                                                    <button class="btn btn-sm btn-success delivered-btn">Delivered</button>
                                                    <button class="btn btn-sm btn-danger cancelled-btn">Cancelled</button>
                                                </div>
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
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php $__env->stopSection(); ?>
























<?php $__env->startPush('scripts'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

<script>
function openGoogleRoute(origin, stops) {
    if (!Array.isArray(stops) || stops.length === 0) return;

    let baseUrl = "https://www.google.com/maps/dir/?api=1";
    let destination = encodeURIComponent(origin); // ensure route returns
    let waypoints = stops.map(encodeURIComponent).join('|');

    let url = `${baseUrl}&origin=${encodeURIComponent(origin)}&destination=${destination}&travelmode=driving`;

    if (waypoints) {
        url += `&waypoints=${waypoints}`;
    }

    window.open(url, '_blank');
}


$(function () {
    $('.sortable').sortable({
        connectWith: '.sortable',
        placeholder: 'ui-state-highlight',
        items: 'li.sortable-stop',
        receive: function (event, ui) {
            // Moved from another truck
            const $list = $(this);
            const truckId = $list.data('truck');
            const driverId = $list.data('driver');

            if (!truckId) {
                toastr.error('Missing truck ID.');
                return;
            }

            const order = $list.children('li.sortable-stop').map(function () {
                const raw = $(this).data('ids');
                return raw ? raw.toString().split(',') : [];
            }).get();

            if (!order.length) {
                toastr.error('No valid delivery IDs found.');
                return;
            }

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
        },
        update: function (event, ui) {
            // Only reorder within same truck — don't double fire
            if (this !== ui.item.parent()[0]) return;

            const $list = $(this);
            const truckId = $list.data('truck');
            const driverId = $list.data('driver');

            if (!truckId) {
                toastr.error('Missing truck ID.');
                return;
            }

            const order = $list.children('li.sortable-stop').map(function () {
                const raw = $(this).data('ids');
                return raw ? raw.toString().split(',') : [];
            }).get();

            if (!order.length) {
                toastr.error('No valid delivery IDs found.');
                return;
            }

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
                    toastr.success(res.message || 'Route reordered');
                },
                error: function () {
                    toastr.error('Failed to reorder route');
                }
            });
        }
    }).disableSelection();
});




$(document).on('click', '.go-btn', function (e) {
    e.preventDefault();
    $(this).closest('.list-group-item').find('.status-options').removeClass('d-none');
    window.open($(this).attr('href'), '_blank');
});

$(document).on('click', '.delivered-btn', function () {
    const li = $(this).closest('.list-group-item');
    const stopIds = li.data('ids');

    const payment = confirm('Was payment received?');
    if (payment) {
        const method = prompt('Payment method (cash/check)?', 'cash');
        const amount = prompt('Enter payment amount:', '');
        if (method && amount) {
            toastr.success('Marked Delivered. Paid: ' + method + ', $' + amount);
        }
    } else {
        toastr.success('Marked Delivered. No payment.');
    }

    li.addClass('bg-success-subtle');
});

$(document).on('click', '.cancelled-btn', function () {
    $(this).closest('.list-group-item').addClass('bg-danger-subtle');
    toastr.warning('Marked as Cancelled');
});
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCPhMXb_6VAGwwSMYj9S1udEO027E3BZT0&libraries=places"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const warehouse = "<?php echo e($warehouseAddress); ?>";
    const map = new google.maps.Map(document.getElementById('map'), {
        zoom: 10,
        center: { lat: 34.0522, lng: -118.2437 }
    });

    const colors = ['#FF0000', '#0000FF', '#008000', '#FFA500', '#800080', '#00CED1', '#DC143C'];
    let colorIndex = 0;
    const geocoder = new google.maps.Geocoder();

    <?php $__currentLoopData = $routes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $route): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        (function(route, color) {
            const stops = [
                { address: warehouse, label: "Base" },
                <?php $__currentLoopData = $route['stops']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stop): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    {
                        address: "<?php echo e($stop['address']); ?>, <?php echo e($stop['city']); ?>",
                        label: "<?php echo e($stop['label'] ?? ''); ?>",
                        title: "Stop: <?php echo e($stop['customer']); ?>"
                    },
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                {
  address: warehouse,
  label: "RB", // different from base "B" or A1/A2
  title: "Return to Warehouse"
}

            ];

            const routeCoords = [];

            function geocodeStop(index) {
                if (index >= stops.length) {
                    const polyline = new google.maps.Polyline({
                        path: routeCoords,
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
                        geocodeStop(index + 1);
                    }
                });
            }

            geocodeStop(0);
        })(<?php echo json_encode($route, 15, 512) ?>, colors[colorIndex++ % colors.length]);
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home4/aizwmjte/sr.elitevinylwindows.com/resources/views/routes/auto.blade.php ENDPATH**/ ?>
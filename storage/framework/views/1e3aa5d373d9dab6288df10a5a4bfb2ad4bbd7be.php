

<?php $__env->startSection('page-title', 'Route Map'); ?>

<?php $__env->startSection('breadcrumb'); ?>
<li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>">Dashboard</a></li>
<li class="breadcrumb-item"><a href="<?php echo e(route('routes.plan')); ?>">Planned Routes</a></li>
<li class="breadcrumb-item active">Map View</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-12">
        <h5 class="mb-3">Route Map for <?php echo e(\Carbon\Carbon::parse($date)->format('F j, Y')); ?></h5>
        <div id="map" style="height: 600px;" class="rounded shadow-sm"></div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCPhMXb_6VAGwwSMYj9S1udEO027E3BZT0&libraries=places"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const map = new google.maps.Map(document.getElementById('map'), {
        zoom: 10,
        center: { lat: 34.0522, lng: -118.2437 }, // Fallback center: Los Angeles
    });

    const warehouse = "<?php echo e($warehouseAddress); ?>";
    const geocoder = new google.maps.Geocoder();
    const colors = ['#FF0000', '#0000FF', '#008000', '#FFA500', '#800080', '#00CED1', '#DC143C'];
    let colorIndex = 0;

    <?php $__currentLoopData = $groupedRoutes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $routes): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
            })(<?php echo json_encode($route, 15, 512) ?>, colors[colorIndex++ % colors.length]);
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home4/aizwmjte/sr.elitevinylwindows.com/resources/views/routes/map.blade.php ENDPATH**/ ?>
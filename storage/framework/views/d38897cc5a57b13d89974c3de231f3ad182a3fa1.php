<!DOCTYPE html>
<html>
<head>
    <title>Route Sheet</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        h2 { margin-bottom: 5px; }
        .stop { margin-bottom: 30px; }
        .divider { border-top: 1px solid #ccc; margin: 20px 0; }
        .small { font-size: 14px; color: #666; }
    </style>
</head>
<body>
  <h2>Truck: <?php echo e($truck); ?> | Driver: <?php echo e($driver ?? 'N/A'); ?> | Date: <?php echo e(\Carbon\Carbon::parse($date)->format('l, F j, Y')); ?></h2>


    <?php if(empty($stops)): ?>
        <p>No deliveries found for this truck and date.</p>
    <?php else: ?>
        <?php $__currentLoopData = $stops; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stop): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="stop">
                <strong><?php echo e($stop['customer']); ?></strong><br>
                <?php echo e($stop['address']); ?>, <?php echo e($stop['city']); ?> <?php echo e($stop['zip']); ?><br><br>

                <strong>Orders:</strong>
               <ul>
<?php $__currentLoopData = $stop['order_numbers']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php
        $delivery = \App\Models\Delivery::where('order_number', $order)
                    ->where('truck_number', $truck)
                    ->whereDate('delivery_date', $date)
                    ->first();

        $commission = $delivery->commission ?? '—';
        $units = $delivery->units ?? '—';

        // Get carts if stored as comma string or list
        $carts = $delivery->carts ?? '—';
        if (is_string($carts)) {
            $carts = implode(', ', explode(',', $carts));
        } elseif (is_array($carts)) {
            $carts = implode(', ', $carts);
        }
    ?>

    <li>
        <?php echo e($order); ?> | P.O <?php echo e($commission); ?> | Unit: <?php echo e($units); ?> | Carts: <?php echo e($carts); ?>

    </li>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</ul>


                <div class="small">
                    <strong>Delivery Time:</strong> ___________ <br>
                    <strong>Payment Method:</strong> ___________
                </div>
            </div>
            <div class="divider"></div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>
<div class="small">
                    <strong>Start Time:</strong> ___________ <br>
                    <strong>Lunch Time:</strong> ___________ <br>
                    <strong>End Time:</strong> ___________
                </div>
    <p class="small">&copy; <?php echo e(now()->year); ?> Elite Vinyl Windows</p>
</body>
</html>
<?php /**PATH /home4/aizwmjte/sr.elitevinylwindows.com/resources/views/routes/pdf.blade.php ENDPATH**/ ?>
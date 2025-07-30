<?php $__env->startSection('page-title'); ?>
    Deliveries on <?php echo e(\Carbon\Carbon::parse($date)->format('F j, Y')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('calendar.index')); ?>">Calendar</a></li>
    <li class="breadcrumb-item active"><?php echo e(\Carbon\Carbon::parse($date)->format('F j, Y')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
 <div class="row">
        <div class="col-sm-12">
<div class="card">
    <div class="card-body">
        <h5><?php echo e(count($deliveries)); ?> Deliveries</h5>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Order #</th>
                    <th>Customer Name</th>
                    <th>Address</th>
                     <th>City</th>
                     <th>Time Frame</th>
                     <th>Delivery Date</th>
                    <th>Comment</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $deliveries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $delivery): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($delivery->order_number); ?></td>
                        <td><?php echo e($delivery->customer_name); ?></td>
                        <td><?php echo e($delivery->address); ?></td>
                        <td><?php echo e($delivery->city); ?></td>
                        <td><?php echo e($delivery->timeframe); ?></td>
                        <td><?php echo e($delivery->delivery_date); ?></td>
                        <td><?php echo e($delivery->comment); ?></td>
                        <td><?php echo e($delivery->status); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home4/aizwmjte/sr.elitevinylwindows.com/resources/views/calendar/deliveries_by_date.blade.php ENDPATH**/ ?>
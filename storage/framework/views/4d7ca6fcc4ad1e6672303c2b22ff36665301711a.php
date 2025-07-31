<?php $__env->startSection('page-title', __('Today\'s Deliveries')); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item active" aria-current="page"><?php echo e(__('Today\'s Deliveries')); ?></li>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('sr.deliveries.all', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home4/aizwmjte/sr.elitevinylwindows.com/resources/views/sr/deliveries/today.blade.php ENDPATH**/ ?>


<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Auto Route Generator')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item active" aria-current="page"><?php echo e(__('Auto Route')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0"><?php echo e(__('Generate Auto Routes')); ?></h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="<?php echo e(route('routes.optimize')); ?>">
                        <?php echo csrf_field(); ?>
                        <div class="form-group">
                            <label for="delivery_date"><?php echo e(__('Delivery Date')); ?></label>
                            <input type="date" id="delivery_date" name="delivery_date" class="form-control" required>
                        </div>
                        <div class="form-group mt-3">
                            <label for="max_stops"><?php echo e(__('Max Stops Per Truck')); ?></label>
                            <input type="number" id="max_stops" name="max_stops" class="form-control" value="10" min="1" required>
                        </div>
                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary"><?php echo e(__('Generate Routes')); ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home4/aizwmjte/sr.elitevinylwindows.com/resources/views/routes/generate.blade.php ENDPATH**/ ?>
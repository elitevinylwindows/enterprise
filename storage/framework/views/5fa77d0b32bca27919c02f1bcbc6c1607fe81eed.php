

<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Import Shops')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('shops.index')); ?>"><?php echo e(__('Shops')); ?></a></li>
    <li class="breadcrumb-item active"><?php echo e(__('Import')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-6 offset-md-3">
        <div class="card">
            <div class="card-header"><h5><?php echo e(__('Import Shops from Excel')); ?></h5></div>
            <div class="card-body">
                <form method="POST" action="<?php echo e(route('shops.import')); ?>" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="form-group">
                        <label for="file"><?php echo e(__('Choose Excel File')); ?></label>
                        <input type="file" name="file" class="form-control" required accept=".xlsx,.xls,.csv">
                    </div>
                    <div class="form-group mt-3">
                        <button type="submit" class="btn btn-primary"><?php echo e(__('Import')); ?></button>
                        <a href="<?php echo e(route('shops.index')); ?>" class="btn btn-secondary"><?php echo e(__('Cancel')); ?></a>
                    </div>
                </form>
                <hr>
                <p class="text-muted">
                    <?php echo e(__('Excel columns must include: customer, address, city, zip.')); ?>

                </p>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home4/aizwmjte/sr.elitevinylwindows.com/resources/views/shops/import.blade.php ENDPATH**/ ?>
<?php $__env->startSection('page-title', __('Create Purchase Request')); ?>

<?php $__env->startSection('breadcrumb'); ?>
<li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
<li class="breadcrumb-item"><a href="<?php echo e(route('inventory.purchase-requests.index')); ?>"><?php echo e(__('Purchase Requests')); ?></a></li>
<li class="breadcrumb-item active" aria-current="page"><?php echo e(__('Create')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header">
        <h5><?php echo e(__('Create Purchase Request')); ?></h5>
    </div>
    <div class="card-body">
        <form action="<?php echo e(route('inventory.purchase-requests.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="form-group">
                <label for="requested_by"><?php echo e(__('Requested By')); ?></label>
                <input type="text" class="form-control" name="requested_by" required>
            </div>
            <div class="form-group mt-3">
                <button type="submit" class="btn btn-primary"><?php echo e(__('Submit')); ?></button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home4/aizwmjte/sr.elitevinylwindows.com/resources/views/inventory/purchase_requests/create.blade.php ENDPATH**/ ?>
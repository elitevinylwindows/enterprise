<?php $__env->startSection('page-title', 'Confirm Import'); ?>

<?php $__env->startSection('content'); ?>
    <div class="card">
        <div class="card-body">
            <h5>The following production barcode already exist:</h5>
            <ul>
                <?php $__currentLoopData = $duplicates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $productionBarcode): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li>Production Barcode<?php echo e($productionBarcode); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>

            <form method="POST" action="<?php echo e(route('cims.import')); ?>">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="action_type" value="skip">
                <input type="hidden" name="import_file" value="<?php echo e($originalFile); ?>">
                <button type="submit" class="btn btn-warning">Skip Existing</button>
            </form>

            <form method="POST" action="<?php echo e(route('cims.import')); ?>" class="mt-2">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="action_type" value="overwrite">
                <input type="hidden" name="import_file" value="<?php echo e($originalFile); ?>">
                <button type="submit" class="btn btn-danger">Overwrite Existing</button>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home4/aizwmjte/sr.elitevinylwindows.com/resources/views/cims/confirm-import.blade.php ENDPATH**/ ?>
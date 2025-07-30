<div>
    <h5>Missing Barcodes for Order #<?php echo e($orderNumber); ?></h5>
    <?php if($missingBarcodes->count()): ?>
        <ul class="list-group">
            <?php $__currentLoopData = $missingBarcodes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $barcode): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li class="list-group-item"><?php echo e($barcode); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    <?php else: ?>
        <p>No missing barcodes found.</p>
    <?php endif; ?>
</div>
<?php /**PATH /home4/aizwmjte/sr.elitevinylwindows.com/resources/views/sr/deliveries/missing_barcodes_modal.blade.php ENDPATH**/ ?>
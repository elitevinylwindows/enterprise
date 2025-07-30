<form action="<?php echo e(route('master.series.store')); ?>" method="POST">
    <?php echo csrf_field(); ?>
    <div class="modal-header"><h5 class="modal-title">Add Series</h5></div>
    <div class="modal-body">
        <div class="form-group">
            <label>Series</label>
            <input type="text" name="series" class="form-control" required>
        </div>
    </div>
    <div class="modal-footer"><button type="submit" class="btn btn-primary">Save</button></div>
</form><?php /**PATH C:\laragon\www\elitevinyle\resources\views/master/series/create.blade.php ENDPATH**/ ?>
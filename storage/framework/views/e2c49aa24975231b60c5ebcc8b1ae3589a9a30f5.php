<form action="<?php echo e(route('master.series-name.update', $seriesName->id)); ?>" method="POST">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>
    <div class="modal-header"><h5 class="modal-title">Edit Series Name</h5></div>
    <div class="modal-body">
        <div class="form-group mb-3">
            <label>Series (Read-only)</label>
            <input type="text" class="form-control" value="<?php echo e($seriesName->series->series ?? '-'); ?>" readonly>
        </div>

        <div class="form-group mb-3">
            <label>Series Name</label>
            <input type="text" name="series_name" class="form-control" value="<?php echo e($seriesName->series_name); ?>" required>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Update</button>
    </div>
</form>
<?php /**PATH /home4/aizwmjte/sr.elitevinylwindows.com/resources/views/master/series/series_name/edit.blade.php ENDPATH**/ ?>
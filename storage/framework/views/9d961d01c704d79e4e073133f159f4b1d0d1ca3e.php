<form action="<?php echo e(route('master.series-name.store')); ?>" method="POST">
    <?php echo csrf_field(); ?>
    <div class="modal-header"><h5 class="modal-title">Add Series Name</h5></div>
    <div class="modal-body">
        <div class="form-group mb-3">
            <label for="series_id">Series</label>
            <select name="series_id" class="form-control" required>
                <?php $__currentLoopData = $series; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($s->id); ?>"><?php echo e($s->series); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="form-group mb-3">
            <label for="series_name">Series Name</label>
            <input type="text" name="series_name" class="form-control" required>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
</form>
<?php /**PATH /home4/aizwmjte/sr.elitevinylwindows.com/resources/views/master/series/series_name/create.blade.php ENDPATH**/ ?>
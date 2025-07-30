<form action="<?php echo e(route('master.prices.markup.update', $markup->id)); ?>" method="POST">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>

    <div class="modal-header">
        <h5 class="modal-title">Edit Markup</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>

    <div class="modal-body">
        <div class="mb-3">
            <label for="series_id" class="form-label">Series</label>
            <select name="series_id" class="form-select" required>
                <?php $__currentLoopData = $series; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($s->id); ?>" <?php echo e($markup->series_id == $s->id ? 'selected' : ''); ?>>
                        <?php echo e($s->series); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="percentage" class="form-label">Markup (%)</label>
            <input type="number" step="0.01" name="percentage" class="form-control" value="<?php echo e($markup->percentage); ?>" required>
        </div>
    </div>

    <div class="modal-footer">
        <button type="submit" class="btn btn-success">Update</button>
    </div>
</form>
<?php /**PATH /home4/aizwmjte/app.elitevinylwindows.com/resources/views/master/prices/markup/edit.blade.php ENDPATH**/ ?>
<form action="<?php echo e(route('color-options.color-configurations.update', $colorConfiguration->id)); ?>" method="POST">
    <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
    <div class="modal-header">
        <h5 class="modal-title">Edit Color Configuration</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>

    <div class="modal-body">
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input name="name" type="text" class="form-control" value="<?php echo e($colorConfiguration->name); ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Code</label>
            <input name="code" type="text" class="form-control" value="<?php echo e($colorConfiguration->code); ?>" required>
        </div>
    </div>

    <div class="modal-footer">
        <button type="submit" class="btn btn-warning">Update</button>
    </div>
</form>
<?php /**PATH /home4/aizwmjte/sr.elitevinylwindows.com/resources/views/master/colors/color_configurations/edit.blade.php ENDPATH**/ ?>
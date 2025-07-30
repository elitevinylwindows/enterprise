<form action="<?php echo e(route('color-options.interior-colors.update', $interiorColor->id)); ?>" method="POST">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>
    <div class="modal-header">
        <h5 class="modal-title">Edit Interior Color</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>
    <div class="modal-body">
        <div class="mb-3">
            <label for="name" class="form-label">Color Name</label>
            <input type="text" name="name" class="form-control" value="<?php echo e($interiorColor->name); ?>" required>
        </div>
        <div class="mb-3">
            <label for="code" class="form-label">Color Code</label>
            <input type="text" name="code" class="form-control" value="<?php echo e($interiorColor->code); ?>" required>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Update</button>
    </div>
</form>
<?php /**PATH /home4/aizwmjte/sr.elitevinylwindows.com/resources/views/master/colors/interior_colors/edit.blade.php ENDPATH**/ ?>
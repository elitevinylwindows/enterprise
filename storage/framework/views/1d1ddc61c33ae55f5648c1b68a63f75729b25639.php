<form action="<?php echo e(route('color-options.exterior-colors.store')); ?>" method="POST">
    <?php echo csrf_field(); ?>
    <div class="modal-header">
        <h5 class="modal-title">Add Exterior Color</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>
    <div class="modal-body">
        <div class="mb-3">
            <label for="name" class="form-label">Color Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="code" class="form-label">Color Code</label>
            <input type="text" name="code" class="form-control" required>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
</form>
<?php /**PATH /home4/aizwmjte/sr.elitevinylwindows.com/resources/views/master/colors/exterior_colors/create.blade.php ENDPATH**/ ?>
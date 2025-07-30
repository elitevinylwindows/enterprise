<form action="<?php echo e(route('snapping.update', $item->id)); ?>" method="POST">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>
    <div class="modal-header">
        <h5 class="modal-title">Edit Snapping</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label>Snapping</label>
            <input type="text" name="name" class="form-control" value="<?php echo e($item->name); ?>" required>
        </div>
        <div class="form-group mt-3">
            <label>Color</label>
            <select name="color" class="form-select" required>
                <option value="white" <?php echo e($item->color == 'white' ? 'selected' : ''); ?>>White</option>
                <option value="black" <?php echo e($item->color == 'black' ? 'selected' : ''); ?>>Black</option>
                <option value="almond" <?php echo e($item->color == 'almond' ? 'selected' : ''); ?>>Almond</option>
            </select>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Update</button>
    </div>
</form>
<?php /**PATH /home4/aizwmjte/sr.elitevinylwindows.com/resources/views/bill_of_material/menu/Snapping/edit.blade.php ENDPATH**/ ?>
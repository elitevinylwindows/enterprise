<form action="<?php echo e(route('lockscrew.update', $item->id)); ?>" method="POST">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>
    <div class="modal-header">
        <h5 class="modal-title">Edit Lock Screw</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label>Lock Screw</label>
            <input type="text" name="name" class="form-control" value="<?php echo e($item->name); ?>" required>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Update</button>
    </div>
</form>
<?php /**PATH /home4/aizwmjte/sr.elitevinylwindows.com/resources/views/bill_of_material/menu/LockScrew/edit.blade.php ENDPATH**/ ?>
<form action="<?php echo e(route('lockscrew.store')); ?>" method="POST">
    <?php echo csrf_field(); ?>
    <div class="modal-header">
        <h5 class="modal-title">Add Lock Screw</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label>Lock Screw</label>
            <input type="text" name="name" class="form-control" required>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
</form>
<?php /**PATH /home4/aizwmjte/sr.elitevinylwindows.com/resources/views/bill_of_material/menu/LockScrew/create.blade.php ENDPATH**/ ?>
<form action="<?php echo e(route('gridtype.store')); ?>" method="POST">
    <?php echo csrf_field(); ?>
    <div class="modal-header">
        <h5 class="modal-title">Add GridType</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" name="name" required>
        </div>
        <div class="mb-3">
            <label for="color" class="form-label">Color</label>
            <input type="text" class="form-control" name="color" required>
        </div>
    
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
</form>
<?php /**PATH /home4/aizwmjte/sr.elitevinylwindows.com/resources/views/bill_of_material/menu/GridType/create.blade.php ENDPATH**/ ?>
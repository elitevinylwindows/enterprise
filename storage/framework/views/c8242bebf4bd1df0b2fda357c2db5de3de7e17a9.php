<form action="<?php echo e(route('sashreinforcement.store')); ?>" method="POST">
    <?php echo csrf_field(); ?>
    <div class="modal-header"><h5 class="modal-title">Add SashReinforcement</h5></div>
    <div class="modal-body">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="size" class="form-label">Size</label>
            <input type="text" name="size" class="form-control" required>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
</form><?php /**PATH /home4/aizwmjte/sr.elitevinylwindows.com/resources/views/bill_of_material/menu/SashReinforcement/create.blade.php ENDPATH**/ ?>
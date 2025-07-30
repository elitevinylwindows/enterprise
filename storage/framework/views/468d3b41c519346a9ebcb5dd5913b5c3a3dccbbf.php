<form action="<?php echo e(route('sashreinforcement.update', $item->id)); ?>" method="POST">
    <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
    <div class="modal-header"><h5 class="modal-title">Edit SashReinforcement</h5></div>
    <div class="modal-body">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" class="form-control" value="<?php echo e($item->name); ?>" required>
        </div>
        <div class="mb-3">
            <label for="size" class="form-label">Size</label>
            <input type="text" name="size" class="form-control" value="<?php echo e($item->size); ?>" required>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Update</button>
    </div>
</form><?php /**PATH /home4/aizwmjte/sr.elitevinylwindows.com/resources/views/bill_of_material/menu/SashReinforcement/edit.blade.php ENDPATH**/ ?>
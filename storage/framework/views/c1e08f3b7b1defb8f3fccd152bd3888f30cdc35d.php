<form action="<?php echo e(route('waterflow.update', $item->id)); ?>" method="POST">
    <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
    <div class="modal-header">
        <h5 class="modal-title">Edit WaterFlow</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" name="name" value="<?php echo e($item->name); ?>" required>
        </div>
        <div class="mb-3">
            <label for="color" class="form-label">Color</label>
            <input type="text" class="form-control" name="color" value="<?php echo e($item->color); ?>" required>
        </div>
    
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Update</button>
    </div>
</form>
<?php /**PATH /home4/aizwmjte/sr.elitevinylwindows.com/resources/views/bill_of_material/menu/WaterFlow/edit.blade.php ENDPATH**/ ?>
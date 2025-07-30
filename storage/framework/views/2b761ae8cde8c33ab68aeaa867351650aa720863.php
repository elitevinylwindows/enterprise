<div class="modal-body">
    <?php echo Form::open(['route' => 'trucks.store', 'method' => 'POST', 'class' => 'ajaxForm']); ?>

    <div class="form-group">
        <label><?php echo e(__('Truck Number')); ?></label>
        <input type="text" name="truck_number" class="form-control" required>
    </div>
    <div class="form-group">
        <label><?php echo e(__('Model')); ?></label>
        <input type="text" name="model" class="form-control">
    </div>
    <div class="form-group">
        <label><?php echo e(__('Capacity')); ?></label>
        <input type="text" name="capacity" class="form-control">
    </div>
    <div class="form-group">
        <label><?php echo e(__('License Plate')); ?></label>
        <input type="text" name="license_plate" class="form-control" required>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary"><?php echo e(__('Save')); ?></button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo e(__('Cancel')); ?></button>
    </div>
</form>
    <?php echo Form::close(); ?>

</div>
<?php /**PATH /home4/aizwmjte/sr.elitevinylwindows.com/resources/views/trucks/modals/create.blade.php ENDPATH**/ ?>
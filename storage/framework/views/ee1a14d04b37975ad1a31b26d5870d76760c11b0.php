<div class="modal-body">
    <?php echo Form::model($truck, ['route' => ['trucks.update', $truck->id], 'method' => 'PUT', 'class' => 'ajaxForm']); ?>

    <div class="form-group">
        <label><?php echo e(__('Truck ID')); ?></label>
        <input type="text" name="truck_number" class="form-control" value="<?php echo e($truck->truck_number); ?>" required>
    </div>
    <div class="form-group">
        <label><?php echo e(__('Model')); ?></label>
        <input type="text" name="model" class="form-control" value="<?php echo e($truck->model); ?>">
    </div>
    <div class="form-group">
        <label><?php echo e(__('Capacity')); ?></label>
        <input type="text" name="capacity" class="form-control" value="<?php echo e($truck->capacity); ?>">
    </div>
    <div class="form-group">
        <label><?php echo e(__('License Plate')); ?></label>
        <input type="text" name="license_plate" class="form-control" value="<?php echo e($truck->license_plate); ?>" required>
    </div>
    <div class="text-end">
        <button type="submit" class="btn btn-primary"><?php echo e(__('Update')); ?></button>
    </div>
    <?php echo Form::close(); ?>

</div>
<?php /**PATH /home4/aizwmjte/sr.elitevinylwindows.com/resources/views/trucks/modals/edit.blade.php ENDPATH**/ ?>
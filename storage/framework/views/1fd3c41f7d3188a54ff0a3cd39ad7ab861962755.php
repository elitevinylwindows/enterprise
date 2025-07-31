<div class="modal-body">
    <?php echo Form::model($driver, ['route' => ['drivers.update', $driver->id], 'method' => 'PUT', 'class' => 'ajaxForm']); ?>

    <div class="form-group">
        <label><?php echo e(__('Name')); ?></label>
        <input type="text" name="name" class="form-control" value="<?php echo e($driver->name); ?>" required>
    </div>
    <div class="form-group">
        <label><?php echo e(__('Phone')); ?></label>
        <input type="text" name="phone" class="form-control" value="<?php echo e($driver->phone); ?>">
    </div>
    <div class="form-group">
        <label><?php echo e(__('Email')); ?></label>
        <input type="text" name="email" class="form-control" value="<?php echo e($driver->email); ?>">
    </div>
    <div class="form-group">
        <label><?php echo e(__('License Number')); ?></label>
        <input type="text" name="license_number" class="form-control" value="<?php echo e($driver->license_number); ?>" required>
    </div>
    <div class="text-end">
        <button type="submit" class="btn btn-primary"><?php echo e(__('Update')); ?></button>
    </div>
    <?php echo Form::close(); ?>

</div>
<?php /**PATH /home4/aizwmjte/sr.elitevinylwindows.com/resources/views/drivers/modals/edit.blade.php ENDPATH**/ ?>
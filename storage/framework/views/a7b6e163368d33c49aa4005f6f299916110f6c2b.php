<form method="POST" action="<?php echo e(route('drivers.store')); ?>" id="create-driver-form">
    <?php echo csrf_field(); ?>
    <div class="modal-body">
        <div class="form-group">
            <label for="name"><?php echo e(__('Name')); ?></label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="phone"><?php echo e(__('Phone')); ?></label>
            <input type="text" name="phone" id="phone" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="email"><?php echo e(__('Email')); ?></label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="license_number"><?php echo e(__('License Number')); ?></label>
            <input type="text" name="license_number" id="license_number" class="form-control" required>
        </div>
    </div>

    <div class="modal-footer">
        <button type="submit" class="btn btn-primary"><?php echo e(__('Save')); ?></button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo e(__('Cancel')); ?></button>
    </div>
</form>
<?php /**PATH /home4/aizwmjte/sr.elitevinylwindows.com/resources/views/drivers/modals/create.blade.php ENDPATH**/ ?>
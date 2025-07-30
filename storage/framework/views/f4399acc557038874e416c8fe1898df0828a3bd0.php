<div class="modal-body">
    <?php echo Form::model($pickup, [
        'url' => url('pickups/' . $pickup->id),
        'method' => 'PUT',
        'class' => 'ajaxForm'
    ]); ?>


    <div class="form-group">
        <?php echo Form::label('status', 'Status'); ?>

        <?php echo Form::select('status', [
            'pending' => 'Pending',
            'picked up' => 'Picked up',
            'complete' => 'Complete',
            'cancelled' => 'Cancelled'
        ], null, ['class' => 'form-control']); ?>

    </div>
<div class="form-group mb-3">
        <?php echo Form::label('date_picked_up', 'Date Picked Up'); ?>

        <?php echo Form::date('date_picked_up', $pickup->date_picked_up ?? null, ['class' => 'form-control']); ?>

    </div>
    
    <div class="text-end">
        <button type="submit" class="btn btn-primary"><?php echo e(__('Update')); ?></button>
    </div>

    <?php echo Form::close(); ?>

</div>



<?php /**PATH /home4/aizwmjte/sr.elitevinylwindows.com/resources/views/pickups/modals/edit.blade.php ENDPATH**/ ?>
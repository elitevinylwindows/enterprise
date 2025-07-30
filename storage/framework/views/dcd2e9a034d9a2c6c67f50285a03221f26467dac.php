<div class="modal-body">
    <?php echo Form::model($delivery, ['route' => ['deliveries.update', $delivery->id], 'method' => 'PUT']); ?>

        <div class="form-group">
            <?php echo Form::label('driver_id', 'Driver'); ?>

            <?php echo Form::select('driver_id', $drivers, null, ['class' => 'form-control']); ?>

        </div>
        <div class="form-group">
                        <?php echo Form::label('truck_id', 'Truck'); ?>

          <?php echo Form::select('truck_number', $trucks, $delivery->truck_number, ['class' => 'form-control']); ?>


        </div>
      <div class="form-group">
    <?php echo Form::label('status', 'Status'); ?>

    <?php echo Form::select('status', [
        'pending' => 'Pending',
        'customer_notified' => 'Customer Notified',
        'in_transit' => 'In Transit',
        'cancelled' => 'Cancelled',
        'delivered' => 'Delivered/Complete',
    ], $delivery->status ?? null, ['class' => 'form-control']); ?>

</div>


<div class="form-group">
    <?php echo Form::label('notes', 'Notes'); ?>

    <?php echo Form::textarea('notes', $delivery->notes ?? '', ['class' => 'form-control']); ?>

</div>

        <button type="submit" class="btn btn-primary">Save</button>
    <?php echo Form::close(); ?>

</div>
<?php /**PATH /home4/aizwmjte/sr.elitevinylwindows.com/resources/views/deliveries/modals/edit.blade.php ENDPATH**/ ?>
<div class="modal-body">
    <?php echo Form::model($delivery, [
        'url' => url('sr/deliveries/' . $delivery->id),
        'method' => 'PUT',
        'class' => 'ajaxForm'
    ]); ?>


    <div class="form-group">
        <?php echo Form::label('address', 'Address'); ?>

        <?php echo Form::text('address', $delivery->address ?? '', ['class' => 'form-control', 'required']); ?>

    </div>

    <div class="form-group">
        <?php echo Form::label('city', 'City'); ?>

        <?php echo Form::text('city', $delivery->city ?? '', ['class' => 'form-control']); ?>

    </div>

 <div class="form-group">
    <?php echo Form::label('contact_phone', 'Contact Phone'); ?>

    <?php echo Form::text('contact_phone', $delivery->shop->contact_phone ?? '', ['class' => 'form-control']); ?>

</div>

    <div class="form-group">
        <?php echo Form::label('customer_email', 'Email'); ?>

        <?php echo Form::text('customer_email', $delivery->customer_email ?? ($delivery->shop->email ?? ''), ['class' => 'form-control']); ?>

    </div>

    <div class="form-group mb-3">
        <?php echo Form::label('delivery_date', 'Delivery Date'); ?>

        <?php echo Form::date('delivery_date', $delivery->delivery_date ?? null, ['class' => 'form-control']); ?>

    </div>

    <div class="form-group">
        <?php echo Form::label('timeframe', 'Timeframe'); ?>

        <?php echo Form::text('timeframe', $delivery->timeframe ?? '', ['class' => 'form-control']); ?>

    </div>

    <div class="form-group">
        <?php echo Form::label('notes', 'Notes'); ?>

        <?php echo Form::textarea('notes', $delivery->notes ?? '', ['class' => 'form-control']); ?>

    </div>

    <div class="form-group">
        <?php echo Form::label('status', 'Status'); ?>

        <?php echo Form::select('status', \App\Models\Delivery::statusOptions(), $delivery->status ?? null, ['class' => 'form-control']); ?>

    </div>

    <div class="text-end">
        <button type="submit" class="btn btn-primary"><?php echo e(__('Update')); ?></button>
    </div>

    <?php echo Form::close(); ?>

</div>
<?php /**PATH /home4/aizwmjte/sr.elitevinylwindows.com/resources/views/sr/deliveries/modals/edit.blade.php ENDPATH**/ ?>
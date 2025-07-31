<?php echo e(Form::open(['route' => 'inventory.locations.store', 'method' => 'post'])); ?>

<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-6">
            <?php echo Form::label('name', __('Name'), ['class' => 'form-label']); ?>

            <?php echo Form::text('name', null, ['class' => 'form-control']); ?>

        </div>
        <div class="form-group col-md-6">
            <?php echo Form::label('description', __('Description'), ['class' => 'form-label']); ?>

            <?php echo Form::text('description', null, ['class' => 'form-control']); ?>

        </div>
        <div class="form-group col-md-6">
            <?php echo Form::label('status', __('Status'), ['class' => 'form-label']); ?>

            <?php echo Form::select('status', ['Active' => 'Active', 'Inactive' => 'Inactive'], null, ['class' => 'form-control']); ?>

        </div>
    </div>
</div>
<div class="modal-footer">
    <?php echo Form::submit(__('Create'), ['class' => 'btn btn-secondary']); ?>

</div>
<?php echo e(Form::close()); ?><?php /**PATH /home4/aizwmjte/app.elitevinylwindows.com/resources/views/inventory/locations/create.blade.php ENDPATH**/ ?>
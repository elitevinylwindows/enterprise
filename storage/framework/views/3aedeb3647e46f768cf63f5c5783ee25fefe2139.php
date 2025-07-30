<?php echo e(Form::open(['route' => 'stock-in.store', 'method' => 'post'])); ?>

<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-6">
            <?php echo Form::label('date', __('Date'), ['class' => 'form-label']); ?>

            <?php echo Form::date('date', null, ['class' => 'form-control']); ?>

        </div>
        <div class="form-group col-md-6">
            <?php echo Form::label('reference', __('Reference'), ['class' => 'form-label']); ?>

            <?php echo Form::text('reference', null, ['class' => 'form-control']); ?>

        </div>
        <div class="form-group col-md-6">
            <?php echo Form::label('warehouse', __('Warehouse'), ['class' => 'form-label']); ?>

            <?php echo Form::text('warehouse', null, ['class' => 'form-control']); ?>

        </div>
        <div class="form-group col-md-6">
            <?php echo Form::label('supplier', __('Supplier'), ['class' => 'form-label']); ?>

            <?php echo Form::text('supplier', null, ['class' => 'form-control']); ?>

        </div>
        <div class="form-group col-md-6">
            <?php echo Form::label('status', __('Status'), ['class' => 'form-label']); ?>

            <?php echo Form::select('status', ['pending' => 'Pending', 'received' => 'Received'], null, ['class' => 'form-control']); ?>

        </div>
    </div>
</div>
<div class="modal-footer">
    <?php echo Form::submit(__('Create'), ['class' => 'btn btn-secondary']); ?>

</div>
<?php echo e(Form::close()); ?>

<?php /**PATH /home4/aizwmjte/sr.elitevinylwindows.com/resources/views/inventory/stock_in/create.blade.php ENDPATH**/ ?>
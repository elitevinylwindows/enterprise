<?php echo e(Form::open(['route' => 'stock-out.store', 'method' => 'post'])); ?>

<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-6">
            <?php echo Form::label('date', __('Date'), ['class' => 'form-label']); ?>

            <?php echo Form::date('date', \Carbon\Carbon::now(), ['class' => 'form-control']); ?>

        </div>
        <div class="form-group col-md-6">
            <?php echo Form::label('product', __('Product'), ['class' => 'form-label']); ?>

            <?php echo Form::text('product', null, ['class' => 'form-control']); ?>

        </div>
        <div class="form-group col-md-6">
            <?php echo Form::label('quantity', __('Quantity'), ['class' => 'form-label']); ?>

            <?php echo Form::number('quantity', null, ['class' => 'form-control']); ?>

        </div>
        <div class="form-group col-md-6">
            <?php echo Form::label('location', __('Location'), ['class' => 'form-label']); ?>

            <?php echo Form::text('location', null, ['class' => 'form-control']); ?>

        </div>
        <div class="form-group col-md-6">
            <?php echo Form::label('reference', __('Reference'), ['class' => 'form-label']); ?>

            <?php echo Form::text('reference', null, ['class' => 'form-control']); ?>

        </div>
        <div class="form-group col-md-6">
            <?php echo Form::label('remarks', __('Remarks'), ['class' => 'form-label']); ?>

            <?php echo Form::text('remarks', null, ['class' => 'form-control']); ?>

        </div>
    </div>
</div>
<div class="modal-footer">
    <?php echo Form::submit(__('Create'), ['class' => 'btn btn-secondary']); ?>

</div>
<?php echo e(Form::close()); ?>

<?php /**PATH /home4/aizwmjte/app.elitevinylwindows.com/resources/views/inventory/stock_out/create.blade.php ENDPATH**/ ?>
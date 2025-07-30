<?php echo e(Form::open(['route' => 'inventory.stock-adjustments.store', 'method' => 'post'])); ?>

<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-6">
            <?php echo Form::label('date', __('Date'), ['class' => 'form-label']); ?>

            <?php echo Form::date('date', \Carbon\Carbon::now(), ['class' => 'form-control']); ?>

        </div>
        <div class="form-group col-md-6">
            <?php echo Form::label('reference_no', __('Reference No'), ['class' => 'form-label']); ?>

            <?php echo Form::text('reference_no', null, ['class' => 'form-control']); ?>

        </div>
        <div class="form-group col-md-6">
            <?php echo Form::label('product_id', __('Product'), ['class' => 'form-label']); ?>

            <?php echo Form::select('product_id', $products, null, ['class' => 'form-control']); ?>

        </div>
        <div class="form-group col-md-6">
            <?php echo Form::label('quantity', __('Quantity'), ['class' => 'form-label']); ?>

            <?php echo Form::number('quantity', null, ['class' => 'form-control']); ?>

        </div>
        <div class="form-group col-md-12">
            <?php echo Form::label('reason', __('Reason'), ['class' => 'form-label']); ?>

            <?php echo Form::textarea('reason', null, ['class' => 'form-control']); ?>

        </div>
    </div>
</div>
<div class="modal-footer">
    <?php echo Form::submit(__('Create'), ['class' => 'btn btn-secondary']); ?>

</div>
<?php echo e(Form::close()); ?>

<?php /**PATH /home4/aizwmjte/sr.elitevinylwindows.com/resources/views/inventory/stock_adjustments/create.blade.php ENDPATH**/ ?>
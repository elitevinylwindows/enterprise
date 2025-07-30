<?php echo e(Form::open(['route' => 'inventory.barcodes.store', 'method' => 'post'])); ?>

<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-6">
            <?php echo Form::label('product', __('Product'), ['class' => 'form-label']); ?>

            <?php echo Form::text('product', null, ['class' => 'form-control']); ?>

        </div>
        <div class="form-group col-md-6">
            <?php echo Form::label('sku', __('SKU'), ['class' => 'form-label']); ?>

            <?php echo Form::text('sku', null, ['class' => 'form-control']); ?>

        </div>
        <div class="form-group col-md-12">
            <?php echo Form::label('barcode', __('Barcode'), ['class' => 'form-label']); ?>

            <?php echo Form::text('barcode', null, ['class' => 'form-control']); ?>

        </div>
    </div>
</div>
<div class="modal-footer">
    <?php echo Form::submit(__('Create'), ['class' => 'btn btn-secondary']); ?>

</div>
<?php echo e(Form::close()); ?>

<?php /**PATH /home4/aizwmjte/sr.elitevinylwindows.com/resources/views/inventory/barcodes/create.blade.php ENDPATH**/ ?>
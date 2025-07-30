<?php echo Form::model($stockLevel, ['route' => ['inventory.stock-level.update', $stockLevel->id], 'method' => 'PUT']); ?>

<div class="modal-body">
    <div class="row">
        
        
        <div class="form-group col-md-6">
            <?php echo Form::label('product_id', 'Product'); ?>

            <?php echo Form::select('product_id', $products, null, ['class' => 'form-control']); ?>

        </div>

        <div class="form-group col-md-6">
            <?php echo Form::label('location_id', 'Location'); ?>

            <?php echo Form::select('location_id', $locations, null, ['class' => 'form-control']); ?>

        </div>

        <div class="form-group col-md-6">
            <?php echo Form::label('stock_on_hand', 'Stock On Hand'); ?>

            <?php echo Form::number('stock_on_hand', null, ['class' => 'form-control']); ?>

        </div>

        <div class="form-group col-md-6">
            <?php echo Form::label('stock_reserved', 'Stock Reserved'); ?>

            <?php echo Form::number('stock_reserved', null, ['class' => 'form-control']); ?>

        </div>

        <div class="form-group col-md-6">
            <?php echo Form::label('stock_available', 'Stock Available'); ?>

            <?php echo Form::number('stock_available', null, ['class' => 'form-control']); ?>

        </div>

        <div class="form-group col-md-6">
            <?php echo Form::label('minimum_level', 'Minimum Level'); ?>

            <?php echo Form::number('minimum_level', null, ['class' => 'form-control']); ?>

        </div>

        <div class="form-group col-md-6">
            <?php echo Form::label('maximum_level', 'Maximum Level'); ?>

            <?php echo Form::number('maximum_level', null, ['class' => 'form-control']); ?>

        </div>

        <div class="form-group col-md-6">
            <?php echo Form::label('reorder_level', 'Reorder Level'); ?>

            <?php echo Form::number('reorder_level', null, ['class' => 'form-control']); ?>

        </div>
    </div>
</div>
<div class="modal-footer">
    <?php echo Form::submit('Update', ['class' => 'btn btn-primary']); ?>

</div>
<?php echo Form::close(); ?>

<?php /**PATH /home4/aizwmjte/app.elitevinylwindows.com/resources/views/inventory/stock_levels/edit.blade.php ENDPATH**/ ?>
<?php echo Form::model($product, ['route' => ['inventory.products.update', $product->id], 'method' => 'PUT']); ?>

<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-6">
            <?php echo Form::label('name', 'Name', ['class' => 'form-label']); ?>

            <?php echo Form::text('name', null, ['class' => 'form-control']); ?>

        </div>

        <div class="form-group col-md-6">
            <?php echo Form::label('description', 'Description', ['class' => 'form-label']); ?>

            <?php echo Form::text('description', null, ['class' => 'form-control']); ?>

        </div>

        <div class="form-group col-md-6">
            <?php echo Form::label('category_id', 'Category', ['class' => 'form-label']); ?>

            <?php echo Form::select('category_id', $categories, $product->category_id, ['class' => 'form-control', 'placeholder' => 'Select Category']); ?>

        </div>

        <div class="form-group col-md-6">
            <?php echo Form::label('uom_id', 'UOM', ['class' => 'form-label']); ?>

            <?php echo Form::select('uom_id', $uoms, $product->uom_id, ['class' => 'form-control', 'placeholder' => 'Select UOM']); ?>

        </div>

        <div class="form-group col-md-6">
            <?php echo Form::label('supplier_id', 'Supplier', ['class' => 'form-label']); ?>

            <?php echo Form::select('supplier_id', $suppliers, $product->supplier_id, ['class' => 'form-control', 'placeholder' => 'Select Supplier']); ?>

        </div>

        <div class="form-group col-md-6">
            <?php echo Form::label('unit', 'Unit', ['class' => 'form-label']); ?>

            <?php echo Form::number('unit', $product->unit, ['class' => 'form-control', 'step' => '0.01']); ?>

        </div>

        <div class="form-group col-md-6">
            <?php echo Form::label('price', 'Price', ['class' => 'form-label']); ?>

            <?php echo Form::number('price', $product->price, ['class' => 'form-control', 'step' => '0.01']); ?>

        </div>

        <div class="form-group col-md-6">
            <?php echo Form::label('unit_price', 'Unit Price', ['class' => 'form-label']); ?>

            <?php echo Form::number('unit_price', $product->unit_price, ['class' => 'form-control', 'step' => '0.01']); ?>

        </div>

        <div class="form-group col-md-6">
            <?php echo Form::label('status', 'Status', ['class' => 'form-label']); ?>

            <?php echo Form::select('status', ['Active' => 'Active', 'Inactive' => 'Inactive'], $product->status, ['class' => 'form-control']); ?>

        </div>
    </div>
</div>
<div class="modal-footer">
    <?php echo Form::submit('Update', ['class' => 'btn btn-secondary']); ?>

</div>
<?php echo Form::close(); ?>

<?php /**PATH /home4/aizwmjte/app.elitevinylwindows.com/resources/views/inventory/products/edit.blade.php ENDPATH**/ ?>
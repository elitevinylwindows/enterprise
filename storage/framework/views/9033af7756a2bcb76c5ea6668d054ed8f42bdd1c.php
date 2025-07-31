<?php echo e(Form::model($bom, ['route' => ['inventory.bom.update', $bom->id], 'method' => 'PUT'])); ?>

<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-6">
            <?php echo e(Form::label('material_name', __('Material Name'), ['class' => 'form-label'])); ?>

            <?php echo e(Form::text('material_name', null, ['class' => 'form-control', 'required'])); ?>

        </div>

        <div class="form-group col-md-6">
            <?php echo e(Form::label('description', __('Description'), ['class' => 'form-label'])); ?>

            <?php echo e(Form::textarea('description', null, ['class' => 'form-control', 'required'])); ?>

        </div>

        <div class="form-group col-md-6">
            <?php echo e(Form::label('unit', __('Unit'), ['class' => 'form-label'])); ?>

            <?php echo e(Form::text('unit', null, ['class' => 'form-control'])); ?>

        </div>

        <div class="form-group col-md-6">
            <?php echo e(Form::label('vendor', __('Vendor'), ['class' => 'form-label'])); ?>

            <?php echo e(Form::text('vendor', null, ['class' => 'form-control'])); ?>

        </div>

        <div class="form-group col-md-6">
            <?php echo e(Form::label('price', __('Price'), ['class' => 'form-label'])); ?>

            <?php echo e(Form::number('price', null, ['class' => 'form-control', 'step' => '0.01'])); ?>

        </div>

        <div class="form-group col-md-6">
            <?php echo e(Form::label('sold_by', __('Sold By'), ['class' => 'form-label'])); ?>

            <?php echo e(Form::select('sold_by', [
                'By BOX' => 'By BOX',
                'By PCs' => 'By PCs',
                'By Roll' => 'By Roll'
            ], null, ['class' => 'form-control', 'placeholder' => 'Select'])); ?>

        </div>

        <div class="form-group col-md-6">
            <?php echo e(Form::label('lin_pcs', __('LIN PCS'), ['class' => 'form-label'])); ?>

            <?php echo e(Form::text('lin_pcs', null, ['class' => 'form-control'])); ?>

        </div>
    </div>
</div>
<div class="modal-footer">
    <?php echo e(Form::submit(__('Update'), ['class' => 'btn btn-secondary'])); ?>

</div>
<?php echo e(Form::close()); ?>

<?php /**PATH /home4/aizwmjte/sr.elitevinylwindows.com/resources/views/inventory/bom/edit.blade.php ENDPATH**/ ?>
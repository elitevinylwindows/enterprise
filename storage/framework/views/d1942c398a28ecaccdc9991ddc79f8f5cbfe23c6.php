<?php echo e(Form::open(['route' => 'dh-unit.store', 'method' => 'post'])); ?>

<div class="modal-body">

    <div class="row">
        <?php $__currentLoopData = [
            'schema_id' => 'Schema ID',
            'product_id' => 'Product ID',
            'retrofit' => 'Retrofit',
            'nailon' => 'Nailon',
            'block' => 'Block',
            'le3_clr' => 'LE3 CLR',
            'clr_clr' => 'CLR CLR',
            'le3_lam' => 'LE3 LAM',
            'clr_temp' => 'CLR TEMP',
            'le3_temp' => 'LE3 TEMP',
            'lam_temp' => 'LAM TEMP',
            'feat1' => 'FEAT1',
            'feat2' => 'FEAT2',
            'feat3' => 'FEAT3',
            'le3_clr_le3' => 'LE3 CLR LE3',
            'le3_combo' => 'LE3 COMBO',
            'sta_grid' => 'STA GRID',
            'tpi' => 'TPI',
            'tpo' => 'TPO',
            'acid_edge' => 'ACID EDGE',
            'solar_cool' => 'SOLAR COOL',
            'status' => 'Status'
        ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="form-group col-md-6">
            <?php echo e(Form::label($field, __($label), ['class' => 'form-label'])); ?>

            <?php echo e(Form::text($field, null, ['class' => 'form-control'])); ?>

        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

</div>
<div class="modal-footer">
    <?php echo e(Form::submit(__('Create'), ['class' => 'btn btn-secondary'])); ?>

</div>
<?php echo e(Form::close()); ?>

<?php /**PATH /home4/aizwmjte/sr.elitevinylwindows.com/resources/views/schemas/dhunit/create.blade.php ENDPATH**/ ?>
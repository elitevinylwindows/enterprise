<?php echo Form::open(['route' => 'xx-unit.store', 'method' => 'post']); ?>

<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-6">
            <?php echo e(Form::label('schema_id', __('Schema ID'), ['class' => 'form-label'])); ?>

            <?php echo e(Form::text('schema_id', null, ['class' => 'form-control', 'required'])); ?>

        </div>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('product_id', __('Product ID'), ['class' => 'form-label'])); ?>

            <?php echo e(Form::text('product_id', null, ['class' => 'form-control'])); ?>

        </div>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('retrofit', __('Retrofit'), ['class' => 'form-label'])); ?>

            <?php echo e(Form::text('retrofit', null, ['class' => 'form-control'])); ?>

        </div>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('nailon', __('Nailon'), ['class' => 'form-label'])); ?>

            <?php echo e(Form::text('nailon', null, ['class' => 'form-control'])); ?>

        </div>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('block', __('Block'), ['class' => 'form-label'])); ?>

            <?php echo e(Form::text('block', null, ['class' => 'form-control'])); ?>

        </div>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('le3_clr', __('LE3 CLR'), ['class' => 'form-label'])); ?>

            <?php echo e(Form::text('le3_clr', null, ['class' => 'form-control'])); ?>

        </div>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('clr_clr', __('CLR CLR'), ['class' => 'form-label'])); ?>

            <?php echo e(Form::text('clr_clr', null, ['class' => 'form-control'])); ?>

        </div>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('status', __('Status'), ['class' => 'form-label'])); ?>

            <?php echo e(Form::select('status', ['Active' => 'Active', 'Inactive' => 'Inactive'], null, ['class' => 'form-control'])); ?>

        </div>
    </div>
</div>
<div class="modal-footer">
    <?php echo e(Form::submit(__('Create'), ['class' => 'btn btn-secondary'])); ?>

</div>
<?php echo Form::close(); ?>

<?php /**PATH /home4/aizwmjte/sr.elitevinylwindows.com/resources/views/schemas/xxunit/create.blade.php ENDPATH**/ ?>
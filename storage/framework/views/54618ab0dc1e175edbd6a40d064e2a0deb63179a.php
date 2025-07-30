<?php echo e(Form::open(['route' => 'hs-unit.store', 'method' => 'post'])); ?>

<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-6">
    <?php echo Form::label('schema_id', __('Schema Id'), ['class' => 'form-label']); ?>

    <?php echo Form::text('schema_id', null, ['class' => 'form-control']); ?>

</div>
<div class="form-group col-md-6">
    <?php echo Form::label('product_id', __('Product Id'), ['class' => 'form-label']); ?>

    <?php echo Form::text('product_id', null, ['class' => 'form-control']); ?>

</div>
<div class="form-group col-md-6">
    <?php echo Form::label('retrofit', __('Retrofit'), ['class' => 'form-label']); ?>

    <?php echo Form::text('retrofit', null, ['class' => 'form-control']); ?>

</div>
<div class="form-group col-md-6">
    <?php echo Form::label('nailon', __('Nailon'), ['class' => 'form-label']); ?>

    <?php echo Form::text('nailon', null, ['class' => 'form-control']); ?>

</div>
<div class="form-group col-md-6">
    <?php echo Form::label('block', __('Block'), ['class' => 'form-label']); ?>

    <?php echo Form::text('block', null, ['class' => 'form-control']); ?>

</div>
<div class="form-group col-md-6">
    <?php echo Form::label('le3_clr', __('Le3 Clr'), ['class' => 'form-label']); ?>

    <?php echo Form::text('le3_clr', null, ['class' => 'form-control']); ?>

</div>
<div class="form-group col-md-6">
    <?php echo Form::label('clr_clr', __('Clr Clr'), ['class' => 'form-label']); ?>

    <?php echo Form::text('clr_clr', null, ['class' => 'form-control']); ?>

</div>
<div class="form-group col-md-6">
    <?php echo Form::label('le3_lam', __('Le3 Lam'), ['class' => 'form-label']); ?>

    <?php echo Form::text('le3_lam', null, ['class' => 'form-control']); ?>

</div>
<div class="form-group col-md-6">
    <?php echo Form::label('le3_clr_le3', __('Le3 Clr Le3'), ['class' => 'form-label']); ?>

    <?php echo Form::text('le3_clr_le3', null, ['class' => 'form-control']); ?>

</div>
<div class="form-group col-md-6">
    <?php echo Form::label('clr_temp', __('Clr Temp'), ['class' => 'form-label']); ?>

    <?php echo Form::text('clr_temp', null, ['class' => 'form-control']); ?>

</div>
<div class="form-group col-md-6">
    <?php echo Form::label('le3_temp', __('Le3 Temp'), ['class' => 'form-label']); ?>

    <?php echo Form::text('le3_temp', null, ['class' => 'form-control']); ?>

</div>
<div class="form-group col-md-6">
    <?php echo Form::label('le3_clr_le3_temp', __('Le3 Clr Le3 Temp'), ['class' => 'form-label']); ?>

    <?php echo Form::text('le3_clr_le3_temp', null, ['class' => 'form-control']); ?>

</div>
<div class="form-group col-md-6">
    <?php echo Form::label('lam_temp', __('Lam Temp'), ['class' => 'form-label']); ?>

    <?php echo Form::text('lam_temp', null, ['class' => 'form-control']); ?>

</div>
<div class="form-group col-md-6">
    <?php echo Form::label('obs', __('Obs'), ['class' => 'form-label']); ?>

    <?php echo Form::text('obs', null, ['class' => 'form-control']); ?>

</div>
<div class="form-group col-md-6">
    <?php echo Form::label('feat2', __('Feat2'), ['class' => 'form-label']); ?>

    <?php echo Form::text('feat2', null, ['class' => 'form-control']); ?>

</div>
<div class="form-group col-md-6">
    <?php echo Form::label('feat3', __('Feat3'), ['class' => 'form-label']); ?>

    <?php echo Form::text('feat3', null, ['class' => 'form-control']); ?>

</div>
<div class="form-group col-md-6">
    <?php echo Form::label('sta_grd', __('Sta Grd'), ['class' => 'form-label']); ?>

    <?php echo Form::text('sta_grd', null, ['class' => 'form-control']); ?>

</div>
<div class="form-group col-md-6">
    <?php echo Form::label('tpi', __('Tpi'), ['class' => 'form-label']); ?>

    <?php echo Form::text('tpi', null, ['class' => 'form-control']); ?>

</div>
<div class="form-group col-md-6">
    <?php echo Form::label('tpo', __('Tpo'), ['class' => 'form-label']); ?>

    <?php echo Form::text('tpo', null, ['class' => 'form-control']); ?>

</div>
<div class="form-group col-md-6">
    <?php echo Form::label('acid_etch', __('Acid Etch'), ['class' => 'form-label']); ?>

    <?php echo Form::text('acid_etch', null, ['class' => 'form-control']); ?>

</div>
<div class="form-group col-md-6">
    <?php echo Form::label('solar_cool', __('Solar Cool'), ['class' => 'form-label']); ?>

    <?php echo Form::text('solar_cool', null, ['class' => 'form-control']); ?>

</div>
<div class="form-group col-md-6">
    <?php echo Form::label('solar_cool_g', __('Solar Cool G'), ['class' => 'form-label']); ?>

    <?php echo Form::text('solar_cool_g', null, ['class' => 'form-control']); ?>

</div>
<div class="form-group col-md-6">
    <?php echo Form::label('status', __('Status'), ['class' => 'form-label']); ?>

    <?php echo Form::text('status', null, ['class' => 'form-control']); ?>

</div>
    </div>
</div>
<div class="modal-footer">
    <?php echo Form::submit(__('Create'), ['class' => 'btn btn-secondary']); ?>

</div>
<?php echo e(Form::close()); ?>

<?php /**PATH /home4/aizwmjte/sr.elitevinylwindows.com/resources/views/schemas/hsunit/create.blade.php ENDPATH**/ ?>
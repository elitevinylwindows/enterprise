{{ Form::model($hsunit, ['route' => ['hs-unit.update', $hsunit->id], 'method' => 'PUT']) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-6">
    {!! Form::label('schema_id', __('Schema Id'), ['class' => 'form-label']) !!}
    {!! Form::text('schema_id', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-md-6">
    {!! Form::label('product_id', __('Product Id'), ['class' => 'form-label']) !!}
    {!! Form::text('product_id', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-md-6">
    {!! Form::label('retrofit', __('Retrofit'), ['class' => 'form-label']) !!}
    {!! Form::text('retrofit', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-md-6">
    {!! Form::label('nailon', __('Nailon'), ['class' => 'form-label']) !!}
    {!! Form::text('nailon', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-md-6">
    {!! Form::label('block', __('Block'), ['class' => 'form-label']) !!}
    {!! Form::text('block', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-md-6">
    {!! Form::label('le3_clr', __('Le3 Clr'), ['class' => 'form-label']) !!}
    {!! Form::text('le3_clr', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-md-6">
    {!! Form::label('clr_clr', __('Clr Clr'), ['class' => 'form-label']) !!}
    {!! Form::text('clr_clr', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-md-6">
    {!! Form::label('le3_lam', __('Le3 Lam'), ['class' => 'form-label']) !!}
    {!! Form::text('le3_lam', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-md-6">
    {!! Form::label('le3_clr_le3', __('Le3 Clr Le3'), ['class' => 'form-label']) !!}
    {!! Form::text('le3_clr_le3', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-md-6">
    {!! Form::label('clr_temp', __('Clr Temp'), ['class' => 'form-label']) !!}
    {!! Form::text('clr_temp', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-md-6">
    {!! Form::label('le3_temp', __('Le3 Temp'), ['class' => 'form-label']) !!}
    {!! Form::text('le3_temp', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-md-6">
    {!! Form::label('le3_clr_le3_temp', __('Le3 Clr Le3 Temp'), ['class' => 'form-label']) !!}
    {!! Form::text('le3_clr_le3_temp', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-md-6">
    {!! Form::label('lam_temp', __('Lam Temp'), ['class' => 'form-label']) !!}
    {!! Form::text('lam_temp', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-md-6">
    {!! Form::label('obs', __('Obs'), ['class' => 'form-label']) !!}
    {!! Form::text('obs', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-md-6">
    {!! Form::label('feat2', __('Feat2'), ['class' => 'form-label']) !!}
    {!! Form::text('feat2', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-md-6">
    {!! Form::label('feat3', __('Feat3'), ['class' => 'form-label']) !!}
    {!! Form::text('feat3', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-md-6">
    {!! Form::label('sta_grid', __('Sta Grid'), ['class' => 'form-label']) !!}
    {!! Form::text('sta_grid', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-md-6">
    {!! Form::label('tpi', __('Tpi'), ['class' => 'form-label']) !!}
    {!! Form::text('tpi', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-md-6">
    {!! Form::label('tpo', __('Tpo'), ['class' => 'form-label']) !!}
    {!! Form::text('tpo', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-md-6">
    {!! Form::label('acid_etch', __('Acid Etch'), ['class' => 'form-label']) !!}
    {!! Form::text('acid_etch', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-md-6">
    {!! Form::label('solar_cool', __('Solar Cool'), ['class' => 'form-label']) !!}
    {!! Form::text('solar_cool', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-md-6">
    {!! Form::label('solar_cool_g', __('Solar Cool G'), ['class' => 'form-label']) !!}
    {!! Form::text('solar_cool_g', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-md-6">
    {!! Form::label('status', __('Status'), ['class' => 'form-label']) !!}
    {!! Form::text('status', null, ['class' => 'form-control']) !!}
</div>
    </div>
</div>
<div class="modal-footer">
    {!! Form::submit(__('Update'), ['class' => 'btn btn-secondary']) !!}
</div>
{{ Form::close() }}

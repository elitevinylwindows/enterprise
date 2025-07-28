{{ Form::open(['route' => 'inventory.bom.store', 'method' => 'post']) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-6">
            {{ Form::label('material_name', __('Material Name'), ['class' => 'form-label']) }}
            {{ Form::text('material_name', null, ['class' => 'form-control', 'required']) }}
        </div>

        <div class="form-group col-md-6">
            {{ Form::label('description', __('Description'), ['class' => 'form-label']) }}
            {{ Form::textarea('description', null, ['class' => 'form-control', 'required']) }}
        </div>

        <div class="form-group col-md-6">
            {{ Form::label('unit', __('Unit'), ['class' => 'form-label']) }}
            {{ Form::text('unit', null, ['class' => 'form-control']) }}
        </div>

        <div class="form-group col-md-6">
            {{ Form::label('vendor', __('Vendor'), ['class' => 'form-label']) }}
            {{ Form::text('vendor', null, ['class' => 'form-control']) }}
        </div>

        <div class="form-group col-md-6">
            {{ Form::label('price', __('Price'), ['class' => 'form-label']) }}
            {{ Form::number('price', null, ['class' => 'form-control', 'step' => '0.01']) }}
        </div>

        <div class="form-group col-md-6">
    {{ Form::label('sold_by', __('Sold By'), ['class' => 'form-label']) }}
    {{ Form::select('sold_by', [
        'By BOX' => 'By BOX',
        'By PCs' => 'By PCs',
        'By Roll' => 'By Roll'
    ], null, ['class' => 'form-control', 'placeholder' => 'Select']) }}
</div>


        <div class="form-group col-md-6">
            {{ Form::label('lin_pcs', __('LIN PCS'), ['class' => 'form-label']) }}
            {{ Form::text('lin_pcs', null, ['class' => 'form-control']) }}
        </div>
    </div>
</div>
<div class="modal-footer">
    {{ Form::submit(__('Create'), ['class' => 'btn btn-secondary']) }}
</div>
{{ Form::close() }}




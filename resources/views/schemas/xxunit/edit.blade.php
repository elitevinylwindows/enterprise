{!! Form::model($xxunit, ['route' => ['xx-unit.update', $xxunit->id], 'method' => 'PUT']) !!}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-6">
            {{ Form::label('schema_id', __('Schema ID'), ['class' => 'form-label']) }}
            {{ Form::text('schema_id', null, ['class' => 'form-control', 'required']) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('product_id', __('Product ID'), ['class' => 'form-label']) }}
            {{ Form::text('product_id', null, ['class' => 'form-control']) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('retrofit', __('Retrofit'), ['class' => 'form-label']) }}
            {{ Form::text('retrofit', null, ['class' => 'form-control']) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('nailon', __('Nailon'), ['class' => 'form-label']) }}
            {{ Form::text('nailon', null, ['class' => 'form-control']) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('block', __('Block'), ['class' => 'form-label']) }}
            {{ Form::text('block', null, ['class' => 'form-control']) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('le3_clr', __('LE3 CLR'), ['class' => 'form-label']) }}
            {{ Form::text('le3_clr', null, ['class' => 'form-control']) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('clr_clr', __('CLR CLR'), ['class' => 'form-label']) }}
            {{ Form::text('clr_clr', null, ['class' => 'form-control']) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('status', __('Status'), ['class' => 'form-label']) }}
            {{ Form::select('status', ['Active' => 'Active', 'Inactive' => 'Inactive'], $xxunit->status, ['class' => 'form-control']) }}
        </div>
    </div>
</div>
<div class="modal-footer">
    {{ Form::submit(__('Update'), ['class' => 'btn btn-secondary']) }}
</div>
{!! Form::close() !!}

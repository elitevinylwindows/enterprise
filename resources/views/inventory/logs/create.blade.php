{{ Form::open(['route' => 'logs.store', 'method' => 'post']) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-6">
            {!! Form::label('product_id', __('Product'), ['class' => 'form-label']) !!}
            {!! Form::select('product_id', $products, null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('change_type', __('Change Type'), ['class' => 'form-label']) !!}
            {!! Form::select('change_type', ['in' => 'In', 'out' => 'Out'], null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('quantity', __('Quantity'), ['class' => 'form-label']) !!}
            {!! Form::number('quantity', null, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>
<div class="modal-footer">
    {!! Form::submit(__('Create'), ['class' => 'btn btn-secondary']) !!}
</div>
{{ Form::close() }}
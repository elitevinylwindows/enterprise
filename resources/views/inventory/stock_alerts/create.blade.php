{{ Form::open(['route' => 'stock-alert.store', 'method' => 'post']) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-6">
            {!! Form::label('product_name', __('Product Name'), ['class' => 'form-label']) !!}
            {!! Form::text('product_name', null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('min_quantity', __('Minimum Quantity'), ['class' => 'form-label']) !!}
            {!! Form::number('min_quantity', null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('current_stock', __('Current Stock'), ['class' => 'form-label']) !!}
            {!! Form::number('current_stock', null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('status', __('Status'), ['class' => 'form-label']) !!}
            {!! Form::text('status', null, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>
<div class="modal-footer">
    {!! Form::submit(__('Create'), ['class' => 'btn btn-secondary']) !!}
</div>
{{ Form::close() }}

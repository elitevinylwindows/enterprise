{{ Form::model($adjustment, ['route' => ['inventory.stock-adjustments.update', $adjustment->id], 'method' => 'PUT']) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-6">
            {!! Form::label('date', __('Date'), ['class' => 'form-label']) !!}
            {!! Form::date('date', $adjustment->date, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('reference_no', __('Reference No'), ['class' => 'form-label']) !!}
            {!! Form::text('reference_no', null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('product_id', __('Product'), ['class' => 'form-label']) !!}
            {!! Form::select('product_id', $products, null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('quantity', __('Quantity'), ['class' => 'form-label']) !!}
            {!! Form::number('quantity', null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group col-md-12">
            {!! Form::label('reason', __('Reason'), ['class' => 'form-label']) !!}
            {!! Form::textarea('reason', null, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>
<div class="modal-footer">
    {!! Form::submit(__('Update'), ['class' => 'btn btn-secondary']) !!}
</div>
{{ Form::close() }}

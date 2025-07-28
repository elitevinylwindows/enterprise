{{ Form::model($stockOut, ['route' => ['stock-out.update', $stockOut->id], 'method' => 'PUT']) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-6">
            {!! Form::label('date', __('Date'), ['class' => 'form-label']) !!}
            {!! Form::date('date', $stockOut->date, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('product', __('Product'), ['class' => 'form-label']) !!}
            {!! Form::text('product', null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('quantity', __('Quantity'), ['class' => 'form-label']) !!}
            {!! Form::number('quantity', null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('location', __('Location'), ['class' => 'form-label']) !!}
            {!! Form::text('location', null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('reference', __('Reference'), ['class' => 'form-label']) !!}
            {!! Form::text('reference', null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('remarks', __('Remarks'), ['class' => 'form-label']) !!}
            {!! Form::text('remarks', null, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>
<div class="modal-footer">
    {!! Form::submit(__('Update'), ['class' => 'btn btn-secondary']) !!}
</div>
{{ Form::close() }}

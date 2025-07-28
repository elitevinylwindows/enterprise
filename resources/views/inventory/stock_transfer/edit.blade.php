{{ Form::model($transfer, ['route' => ['stock-transfer.update', $transfer->id], 'method' => 'PUT']) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-6">
            {!! Form::label('from_location', __('From Location'), ['class' => 'form-label']) !!}
            {!! Form::text('from_location', null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('to_location', __('To Location'), ['class' => 'form-label']) !!}
            {!! Form::text('to_location', null, ['class' => 'form-control']) !!}
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
            {!! Form::label('date', __('Date'), ['class' => 'form-label']) !!}
            {!! Form::date('date', null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('status', __('Status'), ['class' => 'form-label']) !!}
            {!! Form::select('status', ['Pending' => 'Pending', 'Completed' => 'Completed'], null, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>
<div class="modal-footer">
    {!! Form::submit(__('Update'), ['class' => 'btn btn-secondary']) !!}
</div>
{{ Form::close() }}

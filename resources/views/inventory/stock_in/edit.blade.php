{{ Form::model($stockIn, ['route' => ['stock-in.update', $stockIn->id], 'method' => 'PUT']) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-6">
            {!! Form::label('date', __('Date'), ['class' => 'form-label']) !!}
            {!! Form::date('date', null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('reference', __('Reference'), ['class' => 'form-label']) !!}
            {!! Form::text('reference', null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('warehouse', __('Warehouse'), ['class' => 'form-label']) !!}
            {!! Form::text('warehouse', null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('supplier', __('Supplier'), ['class' => 'form-label']) !!}
            {!! Form::text('supplier', null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('status', __('Status'), ['class' => 'form-label']) !!}
            {!! Form::select('status', ['pending' => 'Pending', 'received' => 'Received'], null, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>
<div class="modal-footer">
    {!! Form::submit(__('Update'), ['class' => 'btn btn-secondary']) !!}
</div>
{{ Form::close() }}

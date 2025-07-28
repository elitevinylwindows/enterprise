{{ Form::model($stock_alert, ['route' => ['inventory.stock-alerts.update', $stock_alert->id], 'method' => 'PUT']) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-6">
            {!! Form::label('product_id', __('Product'), ['class' => 'form-label']) !!}
            {!! Form::select('product_id', $products, null, ['class' => 'form-control', 'placeholder' => 'Select Product']) !!}
        </div>

        <div class="form-group col-md-6">
            {!! Form::label('reorder_level', __('Reorder Level'), ['class' => 'form-label']) !!}
            {!! Form::number('reorder_level', null, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group col-md-6">
            {!! Form::label('current_stock', __('Current Stock'), ['class' => 'form-label']) !!}
            {!! Form::number('current_stock', null, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group col-md-6">
            {!! Form::label('reorder_qty', __('Reorder Quantity'), ['class' => 'form-label']) !!}
            {!! Form::number('reorder_qty', null, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group col-md-6">
            {!! Form::label('status', __('Status'), ['class' => 'form-label']) !!}
            {!! Form::select('status', ['Low Stock' => 'Low Stock', 'Reordered' => 'Reordered'], null, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group col-md-6">
            {!! Form::label('alert_date', __('Alert Date'), ['class' => 'form-label']) !!}
            {!! Form::date('alert_date', \Carbon\Carbon::parse($stock_alert->alert_date), ['class' => 'form-control']) !!}
        </div>
    </div>
</div>

<div class="modal-footer">
    {!! Form::submit(__('Update'), ['class' => 'btn btn-secondary']) !!}
</div>
{{ Form::close() }}

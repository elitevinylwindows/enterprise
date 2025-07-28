{{ Form::open(['route' => 'purchasing.purchase-orders.store', 'method' => 'post']) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-6">
            {!! Form::label('order_number', __('Order Number'), ['class' => 'form-label']) !!}
            {!! Form::text('order_number', null, ['class' => 'form-control', 'required' => true]) !!}
        </div>

        <div class="form-group col-md-6">
            {!! Form::label('supplier_id', __('Supplier'), ['class' => 'form-label']) !!}
            {!! Form::select('supplier_id', $suppliers, null, ['class' => 'form-control', 'required' => true]) !!}
        </div>

        <div class="form-group col-md-6">
            {!! Form::label('order_date', __('Order Date'), ['class' => 'form-label']) !!}
            {!! Form::date('order_date', \Carbon\Carbon::now(), ['class' => 'form-control']) !!}
        </div>

        <div class="form-group col-md-6">
            {!! Form::label('expected_delivery', __('Expected Delivery Date'), ['class' => 'form-label']) !!}
            {!! Form::date('expected_delivery', null, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group col-md-6">
            {!! Form::label('tracking_number', __('Tracking Number'), ['class' => 'form-label']) !!}
            {!! Form::text('tracking_number', null, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group col-md-6">
            {!! Form::label('status', __('Status'), ['class' => 'form-label']) !!}
            {!! Form::select('status', ['Pending' => 'Pending', 'Confirmed' => 'Confirmed', 'Delivered' => 'Delivered'], 'Pending', ['class' => 'form-control']) !!}
        </div>

        <div class="form-group col-md-12">
            {!! Form::label('notes', __('Notes'), ['class' => 'form-label']) !!}
            {!! Form::textarea('notes', null, ['class' => 'form-control', 'rows' => 3]) !!}
        </div>
    </div>
</div>
<div class="modal-footer">
    {!! Form::submit(__('Create Order'), ['class' => 'btn btn-secondary']) !!}
</div>
{{ Form::close() }}

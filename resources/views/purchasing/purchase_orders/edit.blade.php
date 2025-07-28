{{ Form::model($order, ['route' => ['purchasing.purchase-orders.update', $order->id], 'method' => 'PUT']) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-6">
            {!! Form::label('order_number', __('Order Number'), ['class' => 'form-label']) !!}
            {!! Form::text('order_number', $order->order_number, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('supplier_id', __('Supplier'), ['class' => 'form-label']) !!}
            {!! Form::select('supplier_id', $suppliers, $order->supplier_id, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('order_date', __('Order Date'), ['class' => 'form-label']) !!}
            {!! Form::date('order_date', \Carbon\Carbon::parse($order->order_date), ['class' => 'form-control']) !!}
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('expected_delivery_date', __('Expected Delivery Date'), ['class' => 'form-label']) !!}
            {!! Form::date('expected_delivery_date', \Carbon\Carbon::parse($order->expected_delivery_date), ['class' => 'form-control']) !!}
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('status', __('Status'), ['class' => 'form-label']) !!}
            {!! Form::select('status', ['Pending' => 'Pending', 'Ordered' => 'Ordered', 'Delivered' => 'Delivered'], $order->status, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('tracking_number', __('Tracking Number'), ['class' => 'form-label']) !!}
            {!! Form::text('tracking_number', $order->tracking_number, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group col-md-12">
            {!! Form::label('notes', __('Notes'), ['class' => 'form-label']) !!}
            {!! Form::textarea('notes', $order->notes, ['class' => 'form-control', 'rows' => 3]) !!}
        </div>
    </div>
</div>
<div class="modal-footer">
    {!! Form::submit(__('Update'), ['class' => 'btn btn-primary']) !!}
</div>
{{ Form::close() }}

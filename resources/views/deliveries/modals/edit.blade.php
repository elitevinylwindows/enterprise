<div class="modal-body">
    {!! Form::model($delivery, ['route' => ['deliveries.update', $delivery->id], 'method' => 'PUT']) !!}
        <div class="form-group">
            {!! Form::label('driver_id', 'Driver') !!}
            {!! Form::select('driver_id', $drivers, null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
                        {!! Form::label('truck_id', 'Truck') !!}
          {!! Form::select('truck_number', $trucks, $delivery->truck_number, ['class' => 'form-control']) !!}

        </div>
      <div class="form-group">
    {!! Form::label('status', 'Status') !!}
    {!! Form::select('status', [
        'pending' => 'Pending',
        'customer_notified' => 'Customer Notified',
        'in_transit' => 'In Transit',
        'cancelled' => 'Cancelled',
        'delivered' => 'Delivered/Complete',
    ], $delivery->status ?? null, ['class' => 'form-control']) !!}
</div>


<div class="form-group">
    {!! Form::label('notes', 'Notes') !!}
    {!! Form::textarea('notes', $delivery->notes ?? '', ['class' => 'form-control']) !!}
</div>

        <button type="submit" class="btn btn-primary">Save</button>
    {!! Form::close() !!}
</div>

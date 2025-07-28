<div class="modal-body">
    {!! Form::model($pickup, [
        'url' => url('pickups/' . $pickup->id),
        'method' => 'PUT',
        'class' => 'ajaxForm'
    ]) !!}

    <div class="form-group">
        {!! Form::label('status', 'Status') !!}
        {!! Form::select('status', [
            'pending' => 'Pending',
            'picked up' => 'Picked up',
            'complete' => 'Complete',
            'cancelled' => 'Cancelled'
        ], null, ['class' => 'form-control']) !!}
    </div>
<div class="form-group mb-3">
        {!! Form::label('date_picked_up', 'Date Picked Up') !!}
        {!! Form::date('date_picked_up', $pickup->date_picked_up ?? null, ['class' => 'form-control']) !!}
    </div>
    
    <div class="text-end">
        <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
    </div>

    {!! Form::close() !!}
</div>




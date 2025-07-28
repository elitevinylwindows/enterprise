<div class="modal-body">
    {!! Form::model($delivery, [
        'url' => url('sr/deliveries/' . $delivery->id),
        'method' => 'PUT',
        'class' => 'ajaxForm'
    ]) !!}

    <div class="form-group">
        {!! Form::label('address', 'Address') !!}
        {!! Form::text('address', null, ['class' => 'form-control', 'required']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('city', 'City') !!}
        {!! Form::text('city', null, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('contact_phone', 'Contact Phone') !!}
        {!! Form::text('contact_phone', null, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('timeframe', 'Timeframe') !!}
        {!! Form::text('timeframe', null, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('status', 'Status') !!}
        {!! Form::select('status', [
            'pending' => 'Pending',
            'complete' => 'Complete',
            'cancelled' => 'Cancelled'
        ], null, ['class' => 'form-control']) !!}
    </div>

    <div class="text-end">
        <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
    </div>

    {!! Form::close() !!}
</div>

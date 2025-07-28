<div class="modal-body">
    {!! Form::model($delivery, [
        'url' => url('sr/deliveries/' . $delivery->id),
        'method' => 'PUT',
        'class' => 'ajaxForm'
    ]) !!}

    <div class="form-group">
        {!! Form::label('address', 'Address') !!}
        {!! Form::text('address', $delivery->address ?? '', ['class' => 'form-control', 'required']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('city', 'City') !!}
        {!! Form::text('city', $delivery->city ?? '', ['class' => 'form-control']) !!}
    </div>

 <div class="form-group">
    {!! Form::label('contact_phone', 'Contact Phone') !!}
    {!! Form::text('contact_phone', $delivery->shop->contact_phone ?? '', ['class' => 'form-control']) !!}
</div>

    <div class="form-group">
        {!! Form::label('customer_email', 'Email') !!}
        {!! Form::text('customer_email', $delivery->customer_email ?? ($delivery->shop->email ?? ''), ['class' => 'form-control']) !!}
    </div>

    <div class="form-group mb-3">
        {!! Form::label('delivery_date', 'Delivery Date') !!}
        {!! Form::date('delivery_date', $delivery->delivery_date ?? null, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('timeframe', 'Timeframe') !!}
        {!! Form::text('timeframe', $delivery->timeframe ?? '', ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('notes', 'Notes') !!}
        {!! Form::textarea('notes', $delivery->notes ?? '', ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('status', 'Status') !!}
        {!! Form::select('status', \App\Models\Delivery::statusOptions(), $delivery->status ?? null, ['class' => 'form-control']) !!}
    </div>

    <div class="text-end">
        <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
    </div>

    {!! Form::close() !!}
</div>

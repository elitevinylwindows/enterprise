<div class="modal-body">
    {!! Form::model($driver, ['route' => ['drivers.update', $driver->id], 'method' => 'PUT', 'class' => 'ajaxForm']) !!}
    <div class="form-group">
        <label>{{ __('Name') }}</label>
        <input type="text" name="name" class="form-control" value="{{ $driver->name }}" required>
    </div>
    <div class="form-group">
        <label>{{ __('Phone') }}</label>
        <input type="text" name="phone" class="form-control" value="{{ $driver->phone }}">
    </div>
    <div class="form-group">
        <label>{{ __('Email') }}</label>
        <input type="text" name="email" class="form-control" value="{{ $driver->email }}">
    </div>
    <div class="form-group">
        <label>{{ __('License Number') }}</label>
        <input type="text" name="license_number" class="form-control" value="{{ $driver->license_number }}" required>
    </div>
    <div class="text-end">
        <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
    </div>
    {!! Form::close() !!}
</div>

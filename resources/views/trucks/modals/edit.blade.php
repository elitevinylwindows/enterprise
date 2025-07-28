<div class="modal-body">
    {!! Form::model($truck, ['route' => ['trucks.update', $truck->id], 'method' => 'PUT', 'class' => 'ajaxForm']) !!}
    <div class="form-group">
        <label>{{ __('Truck ID') }}</label>
        <input type="text" name="truck_number" class="form-control" value="{{ $truck->truck_number }}" required>
    </div>
    <div class="form-group">
        <label>{{ __('Model') }}</label>
        <input type="text" name="model" class="form-control" value="{{ $truck->model }}">
    </div>
    <div class="form-group">
        <label>{{ __('Capacity') }}</label>
        <input type="text" name="capacity" class="form-control" value="{{ $truck->capacity }}">
    </div>
    <div class="form-group">
        <label>{{ __('License Plate') }}</label>
        <input type="text" name="license_plate" class="form-control" value="{{ $truck->license_plate }}" required>
    </div>
    <div class="text-end">
        <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
    </div>
    {!! Form::close() !!}
</div>

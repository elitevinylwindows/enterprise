<div class="modal-body">
    {!! Form::open(['route' => 'trucks.store', 'method' => 'POST', 'class' => 'ajaxForm']) !!}
    <div class="form-group">
        <label>{{ __('Truck Number') }}</label>
        <input type="text" name="truck_number" class="form-control" required>
    </div>
    <div class="form-group">
        <label>{{ __('Model') }}</label>
        <input type="text" name="model" class="form-control">
    </div>
    <div class="form-group">
        <label>{{ __('Capacity') }}</label>
        <input type="text" name="capacity" class="form-control">
    </div>
    <div class="form-group">
        <label>{{ __('License Plate') }}</label>
        <input type="text" name="license_plate" class="form-control" required>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
    </div>
</form>
    {!! Form::close() !!}
</div>

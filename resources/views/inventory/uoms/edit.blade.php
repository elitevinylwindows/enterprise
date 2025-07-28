{!! Form::model($uom, ['route' => ['inventory.uoms.update', $uom->id], 'method' => 'PUT']) !!}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-6">
            {!! Form::label('name', __('Name'), ['class' => 'form-label']) !!}
            {!! Form::text('name', null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('short_code', __('Short Code'), ['class' => 'form-label']) !!}
            {!! Form::text('short_code', null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group col-md-12">
            {!! Form::label('status', __('Status'), ['class' => 'form-label']) !!}
            {!! Form::select('status', ['Active' => 'Active', 'Inactive' => 'Inactive'], null, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>
<div class="modal-footer">
    {!! Form::submit(__('Update'), ['class' => 'btn btn-secondary']) !!}
</div>
{!! Form::close() !!}

{{ Form::model($request ?? null, ['route' => $request ? ['inventory.purchase-requests.update', $request->id] : 'inventory.purchase-requests.store', 'method' => $request ? 'PUT' : 'POST']) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-12">
            {!! Form::label('title', __('Title'), ['class' => 'form-label']) !!}
            {!! Form::text('title', null, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>
<div class="modal-footer">
    {!! Form::submit($request ? __('Update') : __('Create'), ['class' => 'btn btn-secondary']) !!}
</div>
{{ Form::close() }}

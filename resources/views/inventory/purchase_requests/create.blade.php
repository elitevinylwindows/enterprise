{{ Form::model( ?? null, ['route' =>  ? ['inventory.purchase-requests.update', ->id] : 'inventory.purchase-requests.store', 'method' =>  ? 'PUT' : 'POST']) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-12">
            {!! Form::label('title', __('Title'), ['class' => 'form-label']) !!}
            {!! Form::text('title', null, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>
<div class="modal-footer">
    {!! Form::submit( ? __('Update') : __('Create'), ['class' => 'btn btn-secondary']) !!}
</div>
{{ Form::close() }}

{{ Form::open(['route' => 'inventory.barcodes.store', 'method' => 'post']) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-6">
            {!! Form::label('product', __('Product'), ['class' => 'form-label']) !!}
            {!! Form::text('product', null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('sku', __('SKU'), ['class' => 'form-label']) !!}
            {!! Form::text('sku', null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group col-md-12">
            {!! Form::label('barcode', __('Barcode'), ['class' => 'form-label']) !!}
            {!! Form::text('barcode', null, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>
<div class="modal-footer">
    {!! Form::submit(__('Create'), ['class' => 'btn btn-secondary']) !!}
</div>
{{ Form::close() }}

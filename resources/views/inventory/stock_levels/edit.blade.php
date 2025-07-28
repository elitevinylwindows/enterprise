{!! Form::model($stockLevel, ['route' => ['inventory.stock-level.update', $stockLevel->id], 'method' => 'PUT']) !!}
<div class="modal-body">
    <div class="row">
        {{-- Same fields as create.blade.php --}}
        {{-- Replace null with old or $stockLevel values if needed --}}
        <div class="form-group col-md-6">
            {!! Form::label('product_id', 'Product') !!}
            {!! Form::select('product_id', $products, null, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group col-md-6">
            {!! Form::label('location_id', 'Location') !!}
            {!! Form::select('location_id', $locations, null, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group col-md-6">
            {!! Form::label('stock_on_hand', 'Stock On Hand') !!}
            {!! Form::number('stock_on_hand', null, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group col-md-6">
            {!! Form::label('stock_reserved', 'Stock Reserved') !!}
            {!! Form::number('stock_reserved', null, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group col-md-6">
            {!! Form::label('stock_available', 'Stock Available') !!}
            {!! Form::number('stock_available', null, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group col-md-6">
            {!! Form::label('minimum_level', 'Minimum Level') !!}
            {!! Form::number('minimum_level', null, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group col-md-6">
            {!! Form::label('maximum_level', 'Maximum Level') !!}
            {!! Form::number('maximum_level', null, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group col-md-6">
            {!! Form::label('reorder_level', 'Reorder Level') !!}
            {!! Form::number('reorder_level', null, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>
<div class="modal-footer">
    {!! Form::submit('Update', ['class' => 'btn btn-primary']) !!}
</div>
{!! Form::close() !!}

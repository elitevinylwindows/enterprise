{!! Form::open(['route' => 'inventory.products.store', 'method' => 'post']) !!}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-6">
            {!! Form::label('name', 'Product #', ['class' => 'form-label']) !!}
            {!! Form::text('name', null, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group col-md-6">
            {!! Form::label('description', 'Description', ['class' => 'form-label']) !!}
            {!! Form::text('description', null, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group col-md-6">
            {!! Form::label('category_id', 'Category', ['class' => 'form-label']) !!}
            {!! Form::select('category_id', $categories, null, ['class' => 'form-control', 'placeholder' => 'Select Category']) !!}
        </div>

        <div class="form-group col-md-6">
            {!! Form::label('uom_id', 'UOM', ['class' => 'form-label']) !!}
            {!! Form::select('uom_id', $uoms, null, ['class' => 'form-control', 'placeholder' => 'Select UOM']) !!}
        </div>

        <div class="form-group col-md-6">
            {!! Form::label('supplier_id', 'Supplier', ['class' => 'form-label']) !!}
            {!! Form::select('supplier_id', $suppliers, null, ['class' => 'form-control', 'placeholder' => 'Select Supplier']) !!}
        </div>

        <div class="form-group col-md-6">
            {!! Form::label('unit', 'Unit', ['class' => 'form-label']) !!}
            {!! Form::text('unit', null, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group col-md-6">
            {!! Form::label('price', 'Price', ['class' => 'form-label']) !!}
            {!! Form::number('price', null, ['class' => 'form-control', 'step' => '0.01']) !!}
        </div>

        <div class="form-group col-md-6">
            {!! Form::label('unit_price', 'Unit Price', ['class' => 'form-label']) !!}
            {!! Form::number('unit_price', null, ['class' => 'form-control', 'step' => '0.01']) !!}
        </div>

        <div class="form-group col-md-6">
            {!! Form::label('status', 'Status', ['class' => 'form-label']) !!}
            {!! Form::select('status', ['Active' => 'Active', 'Inactive' => 'Inactive'], null, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>
<div class="modal-footer">
    {!! Form::submit('Create', ['class' => 'btn btn-secondary']) !!}
</div>
{!! Form::close() !!}

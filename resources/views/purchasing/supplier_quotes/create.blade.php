{{ Form::open(['route' => 'purchasing.supplier-quotes.store', 'method' => 'post', 'enctype' => 'multipart/form-data']) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-6">
            {!! Form::label('purchase_request_id', __('Purchase Request'), ['class' => 'form-label']) !!}
            {!! Form::select('purchase_request_id', $purchaseRequests, null, ['class' => 'form-control', 'required' => true]) !!}
        </div>

        <div class="form-group col-md-6">
            {!! Form::label('supplier_id', __('Supplier'), ['class' => 'form-label']) !!}
            {!! Form::select('supplier_id', $suppliers, null, ['class' => 'form-control', 'required' => true]) !!}
        </div>

        <div class="form-group col-md-6">
            {!! Form::label('quote_date', __('Quote Date'), ['class' => 'form-label']) !!}
            {!! Form::date('quote_date', \Carbon\Carbon::now(), ['class' => 'form-control']) !!}
        </div>

        <div class="form-group col-md-6">
            {!! Form::label('valid_until', __('Valid Until'), ['class' => 'form-label']) !!}
            {!! Form::date('valid_until', null, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group col-md-6">
            {!! Form::label('price', __('Price'), ['class' => 'form-label']) !!}
            {!! Form::number('price', null, ['class' => 'form-control', 'step' => '0.01']) !!}
        </div>

        <div class="form-group col-md-6">
            {!! Form::label('status', __('Status'), ['class' => 'form-label']) !!}
            {!! Form::select('status', ['Pending' => 'Pending', 'Submitted' => 'Submitted', 'Accepted' => 'Accepted', 'Rejected' => 'Rejected'], 'Pending', ['class' => 'form-control']) !!}
        </div>

        <div class="form-group col-md-12">
            {!! Form::label('product', __('Product Description'), ['class' => 'form-label']) !!}
            {!! Form::textarea('product', null, ['class' => 'form-control', 'rows' => 3]) !!}
        </div>

        <div class="form-group col-md-12">
            {!! Form::label('attachment', __('Attach Quote (PDF, DOC, etc)'), ['class' => 'form-label']) !!}
            {!! Form::file('attachment', ['class' => 'form-control', 'accept' => '.pdf,.doc,.docx,.xls,.xlsx,.png,.jpg,.jpeg']) !!}
        </div>
    </div>
</div>
<div class="modal-footer">
    {!! Form::submit(__('Submit Quote'), ['class' => 'btn btn-secondary']) !!}
</div>
{{ Form::close() }}

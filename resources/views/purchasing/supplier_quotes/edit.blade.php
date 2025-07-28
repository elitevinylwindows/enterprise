{{ Form::model($quote, ['route' => ['purchasing.supplier-quotes.update', $quote->id], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-6">
            {!! Form::label('quote_number', __('Quote Number'), ['class' => 'form-label']) !!}
            {!! Form::text('quote_number', $quote->quote_number, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group col-md-6">
            {!! Form::label('purchase_request_id', __('Purchase Request'), ['class' => 'form-label']) !!}
            {!! Form::select('purchase_request_id', $purchaseRequests, $quote->purchase_request_id, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group col-md-6">
            {!! Form::label('supplier_id', __('Supplier'), ['class' => 'form-label']) !!}
            {!! Form::select('supplier_id', $suppliers, $quote->supplier_id, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group col-md-6">
            {!! Form::label('quote_date', __('Quote Date'), ['class' => 'form-label']) !!}
            {!! Form::date('quote_date', \Carbon\Carbon::parse($quote->quote_date), ['class' => 'form-control']) !!}
        </div>

        <div class="form-group col-md-6">
            {!! Form::label('price', __('Price'), ['class' => 'form-label']) !!}
            {!! Form::number('price', $quote->price, ['class' => 'form-control', 'step' => '0.01']) !!}
        </div>

        <div class="form-group col-md-6">
            {!! Form::label('status', __('Status'), ['class' => 'form-label']) !!}
            {!! Form::select('status', ['Pending' => 'Pending', 'Submitted' => 'Submitted', 'Accepted' => 'Accepted', 'Rejected' => 'Rejected'], $quote->status, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group col-md-12">
            {!! Form::label('attachment', __('Quote Attachment'), ['class' => 'form-label']) !!}
            <input type="file" name="attachment" class="form-control" />
            @if($quote->attachment)
                <p class="mt-2">
                    <a href="{{ asset('storage/' . $quote->attachment) }}" target="_blank">{{ __('View current file') }}</a>
                </p>
            @endif
        </div>

        <div class="form-group col-md-12">
            {!! Form::label('notes', __('Notes'), ['class' => 'form-label']) !!}
            {!! Form::textarea('notes', $quote->notes, ['class' => 'form-control', 'rows' => 3]) !!}
        </div>
    </div>
</div>

<div class="modal-footer">
    {!! Form::submit(__('Update Quote'), ['class' => 'btn btn-primary']) !!}
</div>
{{ Form::close() }}

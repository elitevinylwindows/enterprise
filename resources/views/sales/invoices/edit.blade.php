{{ Form::model($invoice, ['route' => ['sales.invoices.update', $invoice->id], 'method' => 'PUT']) }}
<div class="modal-body">
    <div class="row">
        {{-- Customer Dropdown --}}
        <div class="form-group col-md-6">
            {!! Form::label('customer_id', __('Customer'), ['class' => 'form-label']) !!}
            {!! Form::select('customer_id', $customers, $invoice->customer_id, ['class' => 'form-control select2']) !!}
        </div>

        {{-- Invoice Date --}}
        <div class="form-group col-md-6">
            {!! Form::label('invoice_date', __('Invoice Date'), ['class' => 'form-label']) !!}
            {!! Form::date('invoice_date', $invoice->invoice_date, ['class' => 'form-control']) !!}
        </div>

        {{-- Net Price --}}
        <div class="form-group col-md-6">
            {!! Form::label('net_price', __('Net Price'), ['class' => 'form-label']) !!}
            {!! Form::number('net_price', null, ['class' => 'form-control', 'step' => '0.01']) !!}
        </div>

        {{-- Paid Amount --}}
        <div class="form-group col-md-6">
            {!! Form::label('paid_amount', __('Paid Amount'), ['class' => 'form-label']) !!}
            {!! Form::number('paid_amount', null, ['class' => 'form-control', 'step' => '0.01']) !!}
        </div>

        {{-- Status --}}
        <div class="form-group col-md-6">
            {!! Form::label('status', __('Status'), ['class' => 'form-label']) !!}
            {!! Form::select('status', [
                'unpaid' => 'Unpaid',
                'partial' => 'Partially Paid',
                'paid' => 'Paid'
            ], $invoice->status, ['class' => 'form-control']) !!}
        </div>

        {{-- Notes --}}
        <div class="form-group col-md-12">
            {!! Form::label('notes', __('Notes'), ['class' => 'form-label']) !!}
            {!! Form::textarea('notes', null, ['class' => 'form-control', 'rows' => 3]) !!}
        </div>
    </div>
</div>

<div class="modal-footer">
    {!! Form::submit(__('Update'), ['class' => 'btn btn-secondary']) !!}
</div>
{{ Form::close() }}

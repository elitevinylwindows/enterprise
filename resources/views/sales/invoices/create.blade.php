@extends('layouts.app')

@section('page-title')
    {{ __('New Invoice') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('sales.invoices.index') }}">{{ __('Invoices') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('New Invoice') }}</li>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header"><h5>{{ __('Create New Invoice') }}</h5></div>
            <div class="card-body">
                {!! Form::open(['route' => 'sales.invoices.store', 'method' => 'post']) !!}
                <div class="row">
                    <div class="form-group col-md-6">
                        {!! Form::label('invoice_date', __('Invoice Date'), ['class' => 'form-label']) !!}
                        {!! Form::date('invoice_date', \Carbon\Carbon::now(), ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group col-md-6">
                        {!! Form::label('status', __('Status'), ['class' => 'form-label']) !!}
                        {!! Form::select('status', ['Pending' => 'Pending', 'Paid' => 'Paid'], null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group col-md-6">
    {!! Form::label('customer_number', __('Customer Number'), ['class' => 'form-label']) !!}
    <input type="text" name="customer_number" class="form-control" required>
</div>

<div class="form-group col-md-6">
    {!! Form::label('customer_name', __('Customer Name'), ['class' => 'form-label']) !!}
    <input type="text" name="customer_name" class="form-control" readonly>
</div>

                    <div class="form-group col-md-6">
                        {!! Form::label('net_price', __('Net Price'), ['class' => 'form-label']) !!}
                        {!! Form::number('net_price', null, ['class' => 'form-control', 'step' => '0.01']) !!}
                    </div>
                    <div class="form-group col-md-6">
                        {!! Form::label('paid_amount', __('Paid Amount'), ['class' => 'form-label']) !!}
                        {!! Form::number('paid_amount', null, ['class' => 'form-control', 'step' => '0.01']) !!}
                    </div>
                    <div class="form-group col-md-6">
                        {!! Form::label('remaining_amount', __('Remaining Amount'), ['class' => 'form-label']) !!}
                        {!! Form::number('remaining_amount', null, ['class' => 'form-control', 'step' => '0.01']) !!}
                    </div>
                    <div class="form-group col-md-12">
                        {!! Form::label('notes', __('Notes'), ['class' => 'form-label']) !!}
                        {!! Form::textarea('notes', null, ['class' => 'form-control', 'rows' => 3]) !!}
                    </div>
                </div>
                <div class="mt-4 text-end">
                    {!! Form::submit(__('Save Invoice'), ['class' => 'btn btn-primary']) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection


@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const customerInput = document.querySelector('input[name="customer_number"]');
    const customerNameInput = document.querySelector('input[name="customer_name"]');

    customerInput.addEventListener('change', function () {
        const number = this.value;

        if (!number.trim()) return;

        fetch(`/sales/customers/${number}`)
            .then(res => res.json())
            .then(data => {
                if (data.customer_name) {
                    customerNameInput.value = data.customer_name;
                } else {
                    customerNameInput.value = '';
                    alert('Customer not found');
                }
            })
            .catch(() => {
                customerNameInput.value = '';
                alert('Failed to fetch customer.');
            });
    });
});
</script>
@endpush


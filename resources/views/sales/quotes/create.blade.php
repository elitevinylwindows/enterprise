@extends('layouts.app')

@section('page-title')
    {{ __('Start Quote') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('sales.quotes.index') }}">{{ __('Quotes') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Start Quote') }}</li>
@endsection

@section('content')
<div class="container mt-4">
    {{-- <div class="mb-3">
        <a href="{{ route('sales.quotes.create') }}" class="btn btn-primary">
            <i class="ti ti-edit"></i> Edit Quote Header (Card 1)
        </a>
    </div> --}}

    <div class="card shadow">
        <div class="card-header bg-white">
            <h4 class="mb-0 text-dark">Start Quote</h4>
        </div>
        {{-- @include('sales.quotes.partials.quote-steps', ['activeStep' => 1]) --}}

        <div class="card-body">
            <form action="{{ route('sales.quotes.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-2 mb-3">
                        <label>Customer #</label>
                        <input type="text" name="customer_number" class="form-control" value="{{ old('customer_number', $customerNumber ?? '') }}" required>

                    </div>
                    <div class="col-md-2 mb-3">
                        <label>Quote #</label>
                        <input type="text" name="quote_number" class="form-control" value="{{ $quoteNumber ?? '' }}" readonly>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label>Order Type</label>
                        <select name="order_type" class="form-control">
                            <option value="pickup">Office Pick-up</option>
                            <option value="delivery">Delivery</option>
                        </select>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label>Entry Date</label>
                        <input type="date" name="entry_date" class="form-control" value="{{ date('Y-m-d') }}" readonly>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label>Expected Delivery</label>
                        <input type="date" name="expected_delivery" class="form-control" value="{{ \Carbon\Carbon::now()->addDays(14)->format('Y-m-d') }}">
                    </div>
                    <div class="col-md-2 mb-3">
                        <label>Valid Until</label>
                        <input type="date" name="valid_until" class="form-control" value="{{ \Carbon\Carbon::now()->addDays(30)->format('Y-m-d') }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label>Customer Name</label>
                        <input type="text" name="customer_name" class="form-control" value="{{ old('customer_name', $customerName ?? '') }}" readonly>

                    </div>
                    <div class="col-md-2 mb-3">
                        <label>Entered By</label>
                        <input type="text" name="entered_by" class="form-control" value="{{ auth()->user()->name }}" readonly>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label>Region</label>
                        <select name="region" class="form-control">
                            <option value="Region 1">Region 1</option>
                            <option value="Region 2">Region 2</option>
                        </select>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label>Measurement Type</label>
                        <select name="measurement_type" class="form-control">
                            <option value="Imperial">Imperial</option>
                            <option value="Metric">Metric</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-5 mb-3">
                        <label>Reference</label>
                        <input type="text" name="reference" class="form-control">
                    </div>
                    <div class="col-md-5 mb-3">
                        <label>Contact</label>
                        <input type="text" name="contact" class="form-control">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-5 mb-3">
                        <label>Comment</label>
                        <textarea name="comment" class="form-control" rows="4"></textarea>
                    </div>
                    <div class="col-md-5 mb-3">
                        <label>Notes</label>
                        <textarea name="notes" class="form-control" rows="4"></textarea>
                    </div>
                </div>

                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-play"></i> Start Quote
                    </button>
                </div>
            </form>
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

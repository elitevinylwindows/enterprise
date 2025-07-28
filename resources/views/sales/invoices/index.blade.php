@extends('layouts.app')

@section('page-title', __('Invoices'))

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Invoices') }}</li>
@endsection

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card table-card">
            <div class="card-header">
                <div class="row align-items-center g-2">
                    <div class="col">
                        <h5>{{ __('Invoices') }}</h5>
                    </div>
                    <div class="col-auto">
                        <a href="#" class="btn btn-primary customModal"
                           data-size="lg"
                           data-url="{{ route('sales.invoices.create') }}"
                           data-title="{{ __('Send to Quickbooks') }}">
                            <i data-feather="plus"></i> {{ __('Send to Quickbooks') }}
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body pt-0">
                <div class="dt-responsive table-responsive">
                    <table class="table table-hover advance-datatable">
                        <thead class="table-light">
                            <tr>
                                <th>{{ __('Customer Number') }}</th>
                                <th>{{ __('Customer Name') }}</th>
                                <th>{{ __('Invoice Date') }}</th>
                                <th>{{ __('Net Price') }}</th>
                                <th>{{ __('Paid Amount') }}</th>
                                <th>{{ __('Remaining Amount') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Notes') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($invoices as $invoice)
                                <tr>
                                    <td>{{ $invoice->customer->customer_number ?? '-' }}</td>
                                    <td>{{ $invoice->customer->customer_name ?? '-' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('Y-m-d') }}</td>
                                    <td>${{ number_format($invoice->net_price, 2) }}</td>
                                    <td>${{ number_format($invoice->paid_amount, 2) }}</td>
                                    <td>${{ number_format($invoice->net_price - $invoice->paid_amount, 2) }}</td>
                                    <td>
                                        @if ($invoice->status === 'paid')
                                            <span class="badge bg-success">Paid</span>
                                        @elseif ($invoice->status === 'partial')
                                            <span class="badge bg-warning text-dark">Partially Paid</span>
                                        @else
                                            <span class="badge bg-danger">Unpaid</span>
                                        @endif
                                    </td>
                                    <td>{{ $invoice->notes }}</td>
                                    <td class="text-nowrap">
                                        <a href="#" class="btn btn-sm btn-info customModal"
                                           data-size="lg"
                                           data-url="{{ route('sales.invoices.edit', $invoice->id) }}"
                                           data-title="{{ __('Edit Invoice') }}">
                                            <i data-feather="edit"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div> <!-- table-responsive -->
            </div> <!-- card-body -->
        </div> <!-- card -->
    </div> <!-- col -->
</div>
@endsection


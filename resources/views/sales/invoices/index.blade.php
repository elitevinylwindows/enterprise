@extends('layouts.app')

@section('page-title')
    {{ __('Invoices') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Invoices') }}</li>
@endsection

@section('content')
<div class="mb-4"></div> {{-- Space after title --}}

    
<div class="mb-4"></div> {{-- Space --}}


<div class="row">
    {{-- Taskbar Card --}}
    <div class="col-md-2">
        <div class="card">
            <div class="list-group list-group-flush">
<a href="{{ route('sales.invoices.index', ['status' => 'all']) }}" class="list-group-item">All Invoices</a>
<a href="{{ route('sales.invoices.index', ['status' => 'paid']) }}" class="list-group-item">Paid Invoices</a>
<a href="{{ route('sales.invoices.index', ['status' => 'balance']) }}" class="list-group-item text-danger">Balance</a>

            </div>
        </div>
    </div>

  {{-- Main Content Card --}}
 <div class="col-sm-10">
        <div class="card table-card">
            <div class="card-header">
                <div class="row align-items-center g-2">
                    <div class="col">
                        <h5>{{ __('Invoice List') }}</h5>
                    </div>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="dt-responsive table-responsive">
                    <table class="table table-hover advance-datatable" id="invoicesTable">
                        <thead class="table-light">
                            <tr>
                                <th>{{ __('Invoice #') }}</th>
                                <th>{{ __('Order #') }}</th>
                                <th>{{ __('Quote #') }}</th>
                                <th>{{ __('Customer #') }}</th>
                                <th>{{ __('Customer Name') }}</th>
                                <th>{{ __('Invoice Date') }}</th>
                                <th>{{ __('Total') }}</th>
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
                                    <td>{{ $invoice->invoice_number }}</td>
                                    <td>{{ $invoice->order_number }}</td>
                                    <td>{{ $invoice->quote_number }}</td>
                                    <td>{{ $invoice->customer_number }}</td>
                                    <td>{{ $invoice->customer_name }}</td>
                                    <td>{{ $invoice->invoice_date }}</td>
                                    <td>${{ number_format($invoice->total ?? 0, 2) }}</td>
                                    <td>{{ $invoice->paid_amount }}</td>
                                    <td>{{ $invoice->remaining_amount }}</td>   
                                    <td>
                                        @if($invoice->status === 'active')
                                            <span class="badge bg-success">Active</span>
                                        @elseif($invoice->status === 'draft')
                                            <span class="badge bg-secondary">Draft</span>
                                        @else
                                            <span class="badge bg-light text-muted">{{ ucfirst($invoice->status) }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $invoice->notes }}</td>
                                    <td class="text-nowrap">
                                        {{-- View --}}
                                        <a class="avtar avtar-xs btn-link-success text-success customModal"
                                           data-bs-toggle="tooltip"
                                           data-bs-original-title="View Summary"
                                           href="#"
                                           data-size="xl"
                                           data-url=""
                                           data-title="Invoice Summary">
                                            <i data-feather="eye"></i>
                                        </a>

                                        {{-- Send to QB --}}
                                        <a class="avtar avtar-xs btn-link-success text-success customModal"
                                           data-bs-toggle="tooltip"
                                           data-bs-original-title="Send to QuickBooks"
                                           href="#"
                                           data-size="xl"
                                           data-url=""
                                           data-title="Send to Quickbooks">
                                            <i class="fa-regular fa-share-from-square"> to QB</i>
                                        </a>


                                        {{-- Email --}}
                                        <a class="avtar avtar-xs btn-link-warning text-warning customModal"
                                           data-bs-toggle="tooltip"
                                           data-bs-original-title="Email"
                                           href="#"
                                           data-size="md"
                                           data-url="{{ route('sales.invoices.email', $invoice->id) }}"
                                           data-title="Send Email">
                                            <i data-feather="mail"></i>
                                        </a>

                                        {{-- Take Payment --}}
                                        <a class="avtar avtar-xs btn-link-success text-success customModal"
                                           data-bs-toggle="tooltip"
                                           data-bs-original-title="View Summary"
                                           href="#"
                                           data-size="xl"
                                           data-url=""
                                           data-title="Payment">
                                            <i class="fa-regular fa-credit-card"></i>
                                        </a>

                                        <!--{{-- Edit --}}
                                        <a class="avtar avtar-xs btn-link-primary text-primary customModal"
                                           data-bs-toggle="tooltip"
                                           data-bs-original-title="Edit"
                                           href="#"
                                           data-size="xl"
                                           data-url="{{ route('sales.invoices.edit', $invoice->id) }}"
                                           data-title="Edit Invoice">
                                            <i data-feather="edit"></i>
                                        </a>

                                        

                                        {{-- Billing --}}
                                        <a class="avtar avtar-xs btn-link-info text-info"
                                           data-bs-toggle="tooltip"
                                           data-bs-original-title="Billing"
                                           href="{{ route('sales.invoices.index', ['billing' => $invoice->id]) }}">
                                            <i data-feather="shopping-cart"></i>
                                        </a>

                                        {{-- Delete --}}
                                        <a class="avtar avtar-xs btn-link-danger text-danger customModal"
                                           data-bs-toggle="tooltip"
                                           data-bs-original-title="Delete"
                                           href="#"
                                           data-size="md"
                                           data-url="{{ route('sales.invoices.destroy', $invoice->id) }}"
                                           data-title="Delete Invoice">
                                            <i data-feather="trash-2"></i>
                                        </a>-->
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





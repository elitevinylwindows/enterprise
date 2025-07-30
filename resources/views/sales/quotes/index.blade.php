@extends('layouts.app')

@section('page-title')
    {{ __('Quotes') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Quotes') }}</li>
@endsection

@section('content')
<div class="mb-4"></div> {{-- Space after title --}}

    
<div class="mb-4"></div> {{-- Space --}}
    


<div class="row">
    {{-- Taskbar Card --}}
    <div class="col-md-2">
        <div class="card">
            <div class="list-group list-group-flush">
<a href="{{ route('sales.quotes.index', ['status' => 'all']) }}" class="list-group-item">All Quotes</a>
<a href="{{ route('sales.quotes.index', ['status' => 'draft']) }}" class="list-group-item">Draft Quotes</a>
<a href="{{ route('sales.quotes.index', ['status' => 'deleted']) }}" class="list-group-item text-danger">Deleted</a>

            </div>
        </div>
    </div>

  {{-- Main Content Card --}}
 <div class="col-sm-10">
        <div class="card table-card">
            <div class="card-header">
                <div class="row align-items-center g-2">
                    <div class="col">
                        <h5>{{ __('Quote List') }}</h5>
                    </div>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="dt-responsive table-responsive">
                    <table class="table table-hover advance-datatable" id="quotesTable">
                        <thead class="table-light">
                            <tr>
                                <th>Quote #</th>
                                <th>Customer</th>
                                <th>Entry Date</th>
                                <th>PO #</th>
                                <th>Reference</th>
                                <th>Total</th>
                                <th>Expires By</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($quotes as $quote)
                                <tr>
                                    <td>{{ $quote->quote_number }}</td>
                                    <td>{{ $quote->customer_name }}</td>
                                    <td>{{ $quote->entry_date }}</td>
                                    <td>{{ $quote->po_number }}</td>
                                    <td>{{ $quote->reference }}</td>
                                    <td>${{ number_format($quote->total ?? 0, 2) }}</td>
                                    <td>{{ $quote->valid_until }}</td>
                                    <td>
                                        @if($quote->status === 'active')
                                            <span class="badge bg-success">Active</span>
                                        @elseif($quote->status === 'draft')
                                            <span class="badge bg-secondary">Draft</span>
                                        @else
                                            <span class="badge bg-light text-muted">{{ ucfirst($quote->status) }}</span>
                                        @endif
                                    </td>
                                    <td class="text-nowrap">
                                        {{-- View --}}
                                        <a class="avtar avtar-xs btn-link-success text-success customModal"
                                           data-bs-toggle="tooltip"
                                           data-bs-original-title="View Summary"
                                           href="#"
                                           data-size="xl"
                                           data-url=""
                                           data-title="Quote Summary">
                                            <i data-feather="eye"></i>
                                        </a>

                                        {{-- Edit --}}
                                        <a class="avtar avtar-xs btn-link-primary text-primary customModal"
                                           data-bs-toggle="tooltip"
                                           data-bs-original-title="Edit"
                                           href="#"
                                           data-size="xl"
                                           data-url="{{ route('sales.quotes.edit', $quote->id) }}"
                                           data-title="Edit Quote">
                                            <i data-feather="edit"></i>
                                        </a>

                                        {{-- Email --}}
                                        <a class="avtar avtar-xs btn-link-warning text-warning customModal"
                                           data-bs-toggle="tooltip"
                                           data-bs-original-title="Email"
                                           href="#"
                                           data-size="md"
                                           data-url="{{ route('sales.quotes.email', $quote->id) }}"
                                           data-title="Send Email">
                                            <i data-feather="mail"></i>
                                        </a>


                                        {{-- Manual Convert to Order --}}

                                        {{-- Orders --}}

                                        <a class="avtar avtar-xs btn-link-info text-info"
                                           data-bs-toggle="tooltip"
                                           data-bs-original-title="Orders"
                                           href="{{ route('sales.orders.index', ['quote' => $quote->id]) }}">

                                        {{-- Manual Convert to Order --}}
                                        <a href="{{ route('sales.quotes.convertToOrder', ['id' => $quote->id]) }}"
                                            class="avtar avtar-xs btn-link-info text-info"
                                            data-bs-toggle="tooltip"
                                            data-bs-original-title="Convert to Order">
                                            <i data-feather="shopping-cart"></i>
                                        </a>


                                        {{-- Delete --}}
                                        <a class="avtar avtar-xs btn-link-danger text-danger customModal"
                                           data-bs-toggle="tooltip"
                                           data-bs-original-title="Delete"
                                           href="#"
                                           data-size="md"
                                           data-url="{{ route('sales.quotes.destroy', $quote->id) }}"
                                           data-title="Delete Quote">
                                            <i data-feather="trash-2"></i>
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



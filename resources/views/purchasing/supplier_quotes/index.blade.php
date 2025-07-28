@extends('layouts.app')
@section('page-title', __('Supplier Quotes'))

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
<li class="breadcrumb-item active" aria-current="page">{{ __('Supplier Quotes') }}</li>
@endsection

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card table-card">
            <div class="card-header">
                <div class="row align-items-center g-2">
                    <div class="col"><h5>{{ __('Supplier Quotes') }}</h5></div>
                    <div class="col-auto">
                        <a href="#" class="btn btn-primary customModal"
                           data-size="lg"
                           data-url="{{ route('purchasing.supplier-quotes.create') }}"
                           data-title="{{ __('Create Quote') }}">
                           <i class="fa-solid fa-circle-plus"></i> {{ __('Create') }}
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body pt-0">
                <div class="dt-responsive table-responsive">
                    <table class="table table-hover advance-datatable">
                        <thead>
                            <tr>
                                <th>{{ __('Quote No') }}</th>
                                <th>{{ __('Product') }}</th>
                                <th>{{ __('Supplier') }}</th>
                                <th>{{ __('Purchase Request') }}</th>
                                <th>{{ __('Quote Date') }}</th>
                                <th>{{ __('Total Amount') }}</th>
                                <th>{{ __('Attachment') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($supplierQuotes as $quote)
                            <tr>
                                <td>{{ $quote->quote_number }}</td>
                                <td>{{ $quote->product }}</td>
                                <td>{{ $quote->supplier->name ?? '-' }}</td>
                                <td>{{ $quote->purchaseRequest->request_number ?? '-' }}</td>
                                <td>{{ \Carbon\Carbon::parse($quote->quote_date)->format('M d, Y') }}</td>
                                <td>{{ number_format($quote->total_amount, 2) }}</td>
                                <td>
                                    @if ($quote->attachment)
                                        <a href="{{ asset('storage/' . $quote->attachment) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                            <i class="fa fa-file-pdf"></i> View
                                        </a>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td><span class="badge bg-{{ $quote->status == 'accepted' ? 'success' : ($quote->status == 'rejected' ? 'danger' : 'secondary') }}">
                                    {{ ucfirst($quote->status) }}</span>
                                </td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-info customModal"
                                       data-size="lg"
                                       data-url="{{ route('purchasing.supplier-quotes.edit', $quote->id) }}"
                                       data-title="{{ __('Edit Quote') }}">
                                       <i class="fa fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

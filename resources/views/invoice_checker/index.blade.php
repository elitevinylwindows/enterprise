@extends('layouts.app')

@section('page-title')
    {{ __('Invoice Check') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item" aria-current="page">{{ __('Invoice Check') }}</li>
@endsection

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card table-card">
            <div class="card-header">
                <div class="row align-items-center g-2">
                    <div class="col">
                        <h5>{{ __('Invoice Check') }}</h5>
                    </div>
                   
                </div>
            </div>
                    <div class="card-body pt-0">
                <div class="dt-responsive table-responsive">
                    <table class="table table-hover advance-datatable" id="ordersTable">
                        <thead>
                            <tr>
                                <th>Order #</th>
                <th>Customer #</th>
                <th>Customer Name</th>
                <th>Payment Method</th>
                <th>Payment Amount</th>
                <th>Payment Status</th>
                <th>Cancel Note</th>
                <th>Delivery Note</th>
                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
            @forelse($invoices as $invoice)
                                <tr>
                                    <td>{{ $invoice->order_number }}</td>
                    <td>{{ $invoice->customer }}</td>
                    <td>{{ $invoice->customer_name }}</td>
<td>{{ ucfirst($invoice->payment_method ?? '-') }}</td>
<td>{{ $invoice->payment_amount ?? '-' }}</td>
<td>{{ ucfirst($invoice->payment_status ?? '-') }}</td>

                    <td>{{ $invoice->cancel_note ?? '-' }}</td>
                    <td>{{ $invoice->delivery_note ?? '-' }}</td>
                    <td>
                        <span class="badge bg-{{ $invoice->status === 'delivered' ? 'success' : ($invoice->status === 'cancelled' ? 'danger' : 'info') }}">
                            {{ ucfirst($invoice->status) }}
                        </span>
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





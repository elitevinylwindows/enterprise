@extends('layouts.app')
@section('page-title', __('Stock Out'))
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
<li class="breadcrumb-item active" aria-current="page">{{ __('Stock Out') }}</li>
@endsection
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card table-card">
            <div class="card-header">
                <div class="row align-items-center g-2">
                    <div class="col"><h5>{{ __('Stock Out') }}</h5></div>
                    <div class="col-auto">
                        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createStockOutModal">
    <i class="fas fa-plus"></i> {{ __('Create') }}
</a>

                    </div>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="dt-responsive table-responsive">
                    <table class="table table-hover advance-datatable">
                        <thead>
    <tr>
        <th>{{ __('Date') }}</th>
        <th>{{ __('Product') }}</th>
        <th>{{ __('Quantity') }}</th>
        <th>{{ __('Location') }}</th>
        <th>{{ __('Issued To') }}</th>
        <th>{{ __('Reference') }}</th>
        <th>{{ __('Remarks') }}</th>
        <th>{{ __('Status') }}</th>
        <th>{{ __('Action') }}</th>
    </tr>
</thead>

                        <tbody>
                            @foreach ($stockOuts as $out)
<tr>
    <td>{{ \Carbon\Carbon::parse($out->issued_date)->format('m/d/Y') }}</td>
    <td>{{ $out->product->name ?? '-' }}</td>
    <td>{{ $out->quantity }}</td>
    <td>{{ $out->location->name ?? '-' }}</td>
    <td>{{ $out->issued_to }}</td>
    <td>{{ $out->reference ?? '-' }}</td>
    <td>{{ $out->note ?? '-' }}</td>
    <td>{{ ucfirst($out->status) }}</td>
    <td>
        <a href="#" class="btn btn-sm btn-info customModal"
           data-size="lg"
           data-url="{{ route('inventory.stock-out.edit', $out->id) }}"
           data-title="{{ __('Edit Stock Out') }}">
           <i data-feather="edit"></i>
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


@include('inventory.stock_out.create')

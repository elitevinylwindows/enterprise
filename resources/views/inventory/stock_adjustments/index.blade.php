@extends('layouts.app')
@section('page-title', __('Stock Adjustments'))
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
<li class="breadcrumb-item active" aria-current="page">{{ __('Stock Adjustments') }}</li>
@endsection
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card table-card">
            <div class="card-header">
                <div class="row align-items-center g-2">
                    <div class="col"><h5>{{ __('Stock Adjustments') }}</h5></div>
                    <div class="col-auto">
                        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createStockAdjustmentModal">
    <i class="fas fa-plus"></i> New Adjustment
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
                                <th>{{ __('Reference No') }}</th>
                                <th>{{ __('Product') }}</th>
                                <th>{{ __('Quantity') }}</th>
                                <th>{{ __('Reason') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($adjustments as $adjustment)
                            <tr>
                                <td>{{ $adjustment->date }}</td>
                                <td>{{ $adjustment->reference_no }}</td>
                                <td>{{ $adjustment->product->name ?? '-' }}</td>
                                <td>{{ $adjustment->quantity }}</td>
                                <td>{{ $adjustment->reason }}</td>
                                <td>{{ $adjustment->status }}</td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-info customModal"
                                       data-size="lg"
                                       data-url="{{ route('inventory.stock-adjustments.edit', $adjustment->id) }}"
                                       data-title="{{ __('Edit Stock Adjustment') }}">
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


@include('inventory.stock_adjustments.create')

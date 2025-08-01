@extends('layouts.app')

@section('page-title')
    {{ __('Stock In') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Stock In') }}</li>
@endsection

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card table-card">
            <div class="card-header">
                <div class="row align-items-center g-2">
                    <div class="col">
                        <h5>{{ __('Stock In Records') }}</h5>
                    </div>
                    <div class="col-auto">
                        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createStockInModal">
                            <i class="fas fa-plus"></i> New Stock In
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body pt-0">
                <div class="dt-responsive table-responsive">
                    <table class="table table-hover advance-datatable">
                       <thead class="table-light">
    <tr>
        <th>{{ __('Date') }}</th>
        <th>{{ __('Reference') }}</th>
        <th>{{ __('Warehouse') }}</th>
        <th>{{ __('Location') }}</th>
        <th>{{ __('Product') }}</th>
        <th>{{ __('Quantity') }}</th>
        <th>{{ __('Supplier') }}</th>
        <th>{{ __('Status') }}</th>
        <th>{{ __('Action') }}</th>
    </tr>
</thead>
<tbody>
    @foreach ($stockIns as $stock)
        <tr>
            <td>{{ \Carbon\Carbon::parse($stock->date)->format('Y-m-d') }}</td>
            <td>{{ $stock->reference_no }}</td>
            <td>{{ $stock->warehouse }}</td>
            <td>{{ $stock->location->name ?? '-' }}</td>
            <td>{{ $stock->product->name ?? '-' }}</td>
            <td>{{ $stock->quantity }}</td>
            <td>{{ $stock->supplier->name ?? '-' }}</td>
            <td>
                @if ($stock->status === 'received')
                    <span class="badge bg-success">Received</span>
                @else
                    <span class="badge bg-warning text-dark">Pending</span>
                @endif
            </td>
            <td>
                <a href="#" class="btn btn-sm btn-info customModal"
                   data-size="lg"
                   data-url="{{ route('inventory.stock-in.edit', $stock->id) }}"
                   data-title="{{ __('Edit Stock In') }}">
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

@include('inventory.stock_in.create')

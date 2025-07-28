@extends('layouts.app')
@section('page-title', __('Stock Alerts'))
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
<li class="breadcrumb-item active" aria-current="page">{{ __('Stock Alerts') }}</li>
@endsection
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card table-card">
            <div class="card-header">
                <div class="row align-items-center g-2">
                    <div class="col"><h5>{{ __('Stock Alerts') }}</h5></div>
                    <div class="col-auto">
                        <a href="#" class="btn btn-primary customModal"
                           data-size="lg"
                           data-url="{{ route('inventory.stock-alerts.batch_requests') }}"
                           data-title="{{ __('Create Stock Alert') }}">
                           <i data-feather="copy"></i> {{ __('Bulk Create') }}
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="dt-responsive table-responsive">
                    <table class="table table-hover advance-datatable">
                        <thead>
    <tr>
        <th>{{ __('Product') }}</th>
        <th>{{ __('Reorder level') }}</th>
        <th>{{ __('Current Stock') }}</th>
        <th>{{ __('Reorder Qty') }}</th>
        <th>{{ __('Status') }}</th>
        <th>{{ __('Purchase Request') }}</th>
        <th>{{ __('Alert Date') }}</th>
        <th>{{ __('Action') }}</th>
    </tr>
</thead>
<tbody>
    @foreach ($stock_alerts as $alert)
    <tr>
        <td>{{ $alert->product->name ?? '' }}</td>
        <td>{{ $alert->reorder_level }}</td>
        <td>{{ $alert->current_stock }}</td>
        <td>{{ $alert->reorder_qty }}</td>
        <td>{{ $alert->status }}</td>
        <td>
    @if ($alert->purchaseRequest)
        <a href="#"
           class="text-primary customModal"
           data-size="lg"
           data-url="{{ route('purchasing.purchase-requests.show', $alert->purchaseRequest->id) }}"
           data-title="Purchase Request">
           {{ $alert->purchaseRequest->purchase_request_id }}
        </a>
    @else
        <span class="text-muted">–</span>
    @endif
</td>

        <td>{{ \Carbon\Carbon::parse($alert->alert_date)->format('Y-m-d') }}</td>
        <td>
   <!-- Edit Alert -->
<a class="avtar avtar-xs btn-link-primary text-primary customModal"
   data-bs-toggle="tooltip"
   data-bs-original-title="Edit"
   href="#"
   data-size="xl"
   data-url="{{ route('inventory.stock-alerts.edit', $alert->id) }}"
   data-title="Edit Alert">
    <i data-feather="edit"></i>
</a>

@if($alert->status === 'Low Stock')
    <!-- Create Request -->
    <a href="#"
       class="avtar avtar-xs btn-link-warning text-warning"
       onclick="event.preventDefault(); document.getElementById('create-request-{{ $alert->id }}').submit();"
       title="Create Purchase Request">
        <i data-feather="hexagon"></i>
    </a>

   <form id="create-request-{{ $alert->id }}" action="{{ route('inventory.stock-alerts.create_request', $alert->id) }}" method="GET" style="display: none;">
</form>

@else
    <span class="badge bg-success" data-bs-toggle="tooltip" title="Request already created">Requested</span>
@endif



<!-- Delete Alert -->
<a class="avtar avtar-xs btn-link-danger text-danger customModal"
   data-bs-toggle="tooltip"
   data-bs-original-title="Delete"
   href="#"
   data-size="md"
   data-url="{{ route('inventory.stock-alerts.destroy', $alert->id) }}"
   data-title="Delete Alert">
    <i data-feather="trash-2"></i>
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


 <!-- Batched Request 
    <a class="avtar avtar-xs btn-link-success text-primary customModal"
       data-bs-toggle="tooltip"
       data-bs-original-title="Batched Request"
       href="#"
       data-size="xl"
       data-url="{{ route('inventory.stock-alerts.batch_requests') }}"
       data-title="Batched Request">
        <i data-feather="copy"></i>
    </a>-->
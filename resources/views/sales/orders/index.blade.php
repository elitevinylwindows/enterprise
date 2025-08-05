@extends('layouts.app')

@section('page-title')
    {{ __('Orders') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Orders') }}</li>
@endsection

@section('content')
<div class="mb-4"></div> {{-- Space after title --}}

<div class="row">
    <div class="col-auto ms-auto">
        <a href="javascript:void(0);" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createOrderModal">
            <i class="fas fa-circle-plus"></i> Create Order
        </a>
    </div>
</div>

    
<div class="mb-4"></div> {{-- Space --}}


<div class="row">
    {{-- Taskbar Card --}}
    <div class="col-md-2">
        <div class="card">
            <div class="list-group list-group-flush">
<a href="{{ route('sales.orders.index', ['status' => 'all']) }}" class="list-group-item">All Orders</a>
<a href="{{ route('sales.orders.index', ['status' => 'modified']) }}" class="list-group-item">Modified Orders</a>
<a href="{{ route('sales.orders.index', ['status' => 'deleted']) }}" class="list-group-item text-danger">Cancelled/Deleted</a>

            </div>
        </div>
    </div>

  {{-- Main Content Card --}}
 <div class="col-sm-10">
        <div class="card table-card">
            <div class="card-header">
                <div class="row align-items-center g-2">
                    <div class="col">
                        <h5>{{ __('Orders List') }}</h5>
                    </div>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="dt-responsive table-responsive">
                    <table class="table table-hover advance-datatable" id="ordersTable">
                        <thead class="table-light">
                            <tr>
                                <th>Order #</th>
                                <th>Quote #</th>
                                <th>Customer #</th>
                                <th>Customer</th>
                                <th>Entry Date</th>
                                <th>Total Qty</th>
                                <th>SubTotal</th>
                                <th>Total</th>
                                <th>Delivery Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td>{{ $order->order_number }}</td>
                                    <td>{{ $order->quote->quote_number }}</td>
                                    <td>{{ $order->customer->customer_number }}</td>
                                    <td>{{ $order->customer->customer_name }}</td>
                                    <td>{{ $order->created_at }}</td>
                                    <td>{{ $order->items->sum('qty') }}</td>
                                    <td>{{ $order->net_price }}</td>
                                    <td>${{ number_format($order->remaining_amount ?? 0, 2) }}</td>
                                    <td>{{ $order->expected_delivery_date }}</td>
                                    <td>
                                        @if($order->status === 'active')
                                            <span class="badge bg-success">Active</span>
                                        @elseif($order->status === 'draft')
                                            <span class="badge bg-secondary">Draft</span>
                                        @else
                                            <span class="badge bg-light text-muted">{{ ucfirst($order->status) }}</span>
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
                                           data-title="Order Summary">
                                            <i data-feather="eye"></i>
                                        </a>

                                        {{-- Email --}}
                                        <a class="avtar avtar-xs btn-link-warning text-warning customModal"
                                           data-bs-toggle="tooltip"
                                           data-bs-original-title="Email"
                                           href="#"
                                           data-size="md"
                                           data-url="{{ route('sales.orders.email', $order->id) }}"
                                           data-title="Send Email">
                                            <i data-feather="mail"></i>
                                        </a>

                                        {{-- Convert to an Invoice --}}
                                        <a class="avtar avtar-xs btn-link-info text-info"
                                           data-bs-toggle="tooltip"
                                           data-bs-original-title="Invoice"
                                           href="{{ route('sales.orders.index', ['order' => $order->id]) }}">
                                            <i data-feather="shopping-cart"></i>
                                        </a>


                                        {{-- Edit --}}
                                        <a class="avtar avtar-xs btn-link-primary text-primary customModal"
                                           data-bs-toggle="tooltip"
                                           data-bs-original-title="Edit"
                                           href="#"
                                           data-size="xl"
                                           data-url="{{ route('sales.orders.edit', $order->id) }}"
                                           data-title="Edit Order">
                                            <i data-feather="edit"></i>
                                        </a>

                                
                                        {{-- Delete --}}
                                        <a class="avtar avtar-xs btn-link-danger text-danger customModal"
                                           data-bs-toggle="tooltip"
                                           data-bs-original-title="Delete"
                                           href="#"
                                           data-size="md"
                                           data-url="{{ route('sales.orders.destroy', $order->id) }}"
                                           data-title="Delete Order">
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

@include('sales.orders.create')

@push('scripts')
<script>
document.getElementById('quote_number').addEventListener('blur', function () {
    const quoteNumber = this.value;
    if (!quoteNumber) return;

    fetch(`/sales/quotes/get-by-number/${quoteNumber}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('customerName').textContent = data.customer_name;
                document.getElementById('deliveryDate').textContent = data.delivery_date;
                document.getElementById('quote_id').value = data.quote_id;
                document.getElementById('customer_id').value = data.customer_id;

                document.getElementById('quoteDetailsPreview').style.display = 'block';
                document.getElementById('submitOrderBtn').disabled = false;
            } else {
                alert('Quote not found.');
                document.getElementById('submitOrderBtn').disabled = true;
            }
        });
});
</script>
@endpush

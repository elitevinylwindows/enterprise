@extends('layouts.app')

@section('page-title')
    {{ __('Orders') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Orders') }}</li>
@endsection

@section('content')
<div class="mb-4"></div> {{-- space --}}

<div class="row">
    {{-- Taskbar --}}
    <div class="col-md-2">
        <div class="card">
            <div class="list-group list-group-flush">
                <a href="{{ route('sales.orders.index', ['status' => 'all']) }}" class="list-group-item">All Orders</a>
                <a href="{{ route('sales.orders.index', ['status' => 'modified']) }}" class="list-group-item">Modified Orders</a>
                <a href="{{ route('sales.orders.index', ['status' => 'deleted']) }}" class="list-group-item text-danger">Cancelled/Deleted</a>
            </div>
        </div>
    </div>

    {{-- Main --}}
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
                    <table class="table table-hover table-sm advance-datatable" id="ordersTable">
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
                                <td class="align-middle">{{ $order->order_number }}</td>
                                <td class="align-middle">{{ $order->quote->quote_number }}</td>
                                <td class="align-middle">{{ $order->customer->customer_number }}</td>
                                <td class="align-middle text-truncate" style="max-width: 200px;">{{ $order->customer->customer_name }}</td>
                                <td class="align-middle">{{ $order->created_at }}</td>
                                <td class="align-middle">{{ $order->items->sum('qty') }}</td>
                                <td class="align-middle">${{ number_format($order->net_price ?? 0, 2) }}</td>
                                <td class="align-middle">${{ number_format($order->remaining_amount ?? 0, 2) }}</td>
                                <td class="align-middle">{{ $order->expected_delivery_date }}</td>
                                <td class="align-middle">
                                    @if($order->status === 'active')
                                        <span class="badge bg-success">Active</span>
                                    @elseif($order->status === 'draft')
                                        <span class="badge bg-secondary">Draft</span>
                                    @else
                                        <span class="badge bg-light text-muted">{{ ucfirst($order->status) }}</span>
                                    @endif
                                </td>
                                <td class="align-middle text-nowrap">
                                    {{-- View --}}
                                    <a class="avtar avtar-xs btn-link-success text-success customModal"
                                       data-bs-toggle="tooltip" data-bs-original-title="View Summary"
                                       href="#" data-size="xl"
                                       data-url="{{ route('sales.orders.show', $order->id) }}"
                                       data-title="Order Summary">
                                        <i data-feather="eye"></i>
                                    </a>

                                    {{-- Email --}}
                                    <a class="avtar avtar-xs btn-link-warning text-warning customModal"
                                       data-bs-toggle="tooltip" data-bs-original-title="Email"
                                       href="#" data-size="md"
                                       data-url="{{ route('sales.orders.email', $order->id) }}"
                                       data-title="Send Email">
                                        <i data-feather="mail"></i>
                                    </a>

                                    @if(!$order->invoice)
                                    {{-- Convert to Invoice --}}
                                    <a class="avtar avtar-xs btn-link-info text-info"
                                       data-bs-toggle="tooltip" data-bs-original-title="Invoice"
                                       href="{{ route('sales.orders.convertToInvoice', ['id' => $order->id]) }}">
                                        <i data-feather="file-text"></i>
                                    </a>
                                    @endif

                                    {{-- Edit --}}
                                    <a class="avtar avtar-xs btn-link-primary text-primary customModal"
                                       data-bs-toggle="tooltip" data-bs-original-title="Edit"
                                       href="#" data-size="xl"
                                       data-url="{{ route('sales.orders.edit', $order->id) }}"
                                       data-title="Edit Order">
                                        <i data-feather="edit"></i>
                                    </a>

                                    {{-- Delete (form post to keep RESTful) --}}
                                    <form action="{{ route('sales.orders.destroy', $order->id) }}"
                                          method="POST" class="d-inline delete-order-form">
                                        @csrf @method('DELETE')
                                        <button type="button"
                                                class="avtar avtar-xs btn-link-danger text-danger border-0 bg-transparent p-0 delete-order-btn"
                                                data-bs-toggle="tooltip" data-bs-original-title="Delete">
                                            <i data-feather="trash-2"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div> <!-- table-responsive -->
            </div>
        </div>
    </div>
</div>
@endsection

{{-- Optional: create modal include --}}
{{-- @include('sales.orders.create') --}}

@push('scripts')
<script>
    @if ($errors->any())
        toastr.error("{{ $errors->first() }}");
    @endif

    @if(session('success'))
        toastr.success("{{ session('success') }}");
    @endif
</script>
@endpush

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


<div class="mb-4"></div> {{-- Space --}}



<div class="row">
    {{-- Taskbar Card --}}
    <div class="col-md-2">
  <div class="card">
    <div class="list-group list-group-flush">
        <a href="{{ route('sales.orders.index', ['status' => 'all']) }}"
           class="list-group-item {{ $status === 'all' ? 'active' : '' }}">
           All Orders
        </a>
        <a href="{{ route('sales.orders.index', ['status' => 'modified']) }}"
           class="list-group-item {{ $status === 'modified' ? 'active' : '' }}">
           Modified Orders
        </a>
        <a href="{{ route('sales.orders.index', ['status' => 'deleted']) }}"
           class="list-group-item {{ $status === 'deleted' ? 'active' : '' }}">
           Deleted
        </a>
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
        <td>{{ $order->quote->quote_number ?? 'N/A' }}</td>
        <td>{{ $order->customer->customer_number ?? 'N/A' }}</td>
        <td>{{ $order->customer->customer_name ?? 'N/A' }}</td>
        <td>{{ $order->created_at->format('m/d/Y') }}</td>
        <td>{{ $order->items->sum('qty') }}</td>
        <td>${{ number_format($order->sub_total ?? 0, 2) }}</td>
        <td>${{ number_format($order->total ?? 0, 2) }}</td>
        <td>{{ $order->expected_delivery_date }}</td>
        <td>
            @if($status === 'deleted')
                <span class="badge bg-danger">Deleted</span>
            @elseif($order->status === 'sent')
                <span class="badge bg-success">Sent</span>
            @elseif($order->status === 'created')
                <span class="badge bg-secondary">Created</span>
            @else
                <span class="badge bg-light text-muted">{{ ucfirst($order->status) }}</span>
            @endif
        </td>
        <td class="text-nowrap">
            @if($status === 'deleted')
                {{-- Restore Button --}}
                <form action="{{ route('sales.orders.restore', $order->id) }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="avtar avtar-xs btn-link-success text-success border-0 bg-transparent p-0"
                            data-bs-toggle="tooltip" data-bs-original-title="Restore Order">
                        <i data-feather="rotate-ccw"></i>
                    </button>
                </form>

                {{-- Permanent Delete Button --}}
                <form action="{{ route('sales.orders.force-delete', $order->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="avtar avtar-xs btn-link-danger text-danger border-0 bg-transparent p-0"
                            data-bs-toggle="tooltip" data-bs-original-title="Delete Permanently"
                            onclick="return confirm('Permanently delete this order?')">
                        <i data-feather="trash-2"></i>
                    </button>
                </form>
            @else
                {{-- View --}}
                <a class="avtar avtar-xs btn-link-success text-success customModal"
                   data-bs-toggle="tooltip"
                   data-bs-original-title="View Order"
                   href="#"
                   data-size="xl"
                   data-url="{{ route('sales.orders.show', $order->id) }}"
                   data-title="Order Summary">
                    <i data-feather="eye"></i>
                </a>

                {{-- Email --}}
                <a class="avtar avtar-xs btn-link-warning text-warning emailButton" data-bs-toggle="tooltip" 
                    data-bs-original-title="Email" href="#" data-size="md" 
                    data-url="{{ route('sales.orders.email', $order->id) }}" 
                    data-title="Send Email">
                    <i data-feather="mail" id="emailIcon"></i>
                    <span class="spinner-border spinner-border-sm d-none" id="emailSpinner"></span>
                </a>
                

                @if(!$order->invoice)
                {{-- Convert to Invoice --}}
                <a class="avtar avtar-xs btn-link-info text-info"
                   data-bs-toggle="tooltip"
                   data-bs-original-title="Convert to Invoice"
                   href="{{ route('sales.orders.convertToInvoice', ['id' => $order->id]) }}">
                    <i data-feather="file-text"></i>
                </a>
                @endif

       {{-- Rush --}}
<form action="{{ route('sales.orders.rush', $order->id) }}" method="POST" class="d-inline">
  @csrf
  <button type="submit" class="avtar avtar-xs btn-link-warning text-warning" title="Rush (bypass 48h; requires payment or Special)">
    <i data-feather="zap"></i>
  </button>
</form>


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
                <form action="{{ route('sales.orders.destroy', $order->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="avtar avtar-xs btn-link-danger text-danger border-0 bg-transparent p-0"
                            data-bs-toggle="tooltip" data-bs-original-title="Delete"
                            onclick="return confirm('Delete this order?')">
                        <i data-feather="trash-2"></i>
                    </button>
                </form>
            @endif
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

@push('scripts')

<script>
    $(document).ready(function() {

         $('.emailButton').on('click', function(e) {
            e.preventDefault();

            const $button = $(this);
            const $icon = $button.find('#emailIcon');
            const $spinner = $button.find('.spinner-border');
            const url = $button.data('url');

            // Show spinner and hide icon
            $icon.addClass('d-none');
            $spinner.removeClass('d-none');
            $button.prop('disabled', true);

            $.ajax({
                url: url
                , type: 'GET'
                , data: {
                    _token: '{{ csrf_token() }}'
                }
                , success: function(response) {
                    toastr.success('Email sent successfully!', 'Success', {
                        timeOut: 3000
                        , progressBar: true
                        , closeButton: true
                    });
                }
                , error: function(xhr) {
                    toastr.error('Failed to send email. Please try again.', 'Error', {
                        timeOut: 3000
                        , progressBar: true
                        , closeButton: true
                    });
                }
                , complete: function() {
                    // Always hide spinner and show icon when request is complete
                    $spinner.addClass('d-none');
                    $icon.removeClass('d-none');
                    $button.prop('disabled', false);
                }
            });
        });

        // Delete quote with confirmation
        $('.delete-quote-btn').on('click', function(e) {
            e.preventDefault();
            const $form = $(this).closest('form');
            if (confirm('Are you sure you want to delete this quote?')) {
            $form.submit();
            }
        });
    });

</script>
@endpush



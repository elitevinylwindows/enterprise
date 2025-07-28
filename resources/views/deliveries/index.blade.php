@extends('layouts.app')

@section('page-title')
    {{ __('Deliveries') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item" aria-current="page"> {{ __('Deliveries') }}</li>
@endsection

@section('card-action-btn')
    @if (Gate::check('create delivery'))
        <a class="btn btn-secondary btn-sm ml-20 customModal" href="#" data-size="lg"
            data-url="{{ route('delivery.create') }}" data-title="{{ __('Create Delivery') }}">
            <i class="ti-plus mr-5"></i>{{ __('Create Delivery') }}</a>
    @endif
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card table-card">
                <div class="card-header">
                    <div class="row align-items-center g-2">
                        <div class="col">
                            <h5>
                                {{ __('Deliveries') }}
                            </h5>
                        </div>
                        @if (Gate::check('create delivery'))
                            <div class="col-auto">
                                <a class="btn btn-secondary customModal" href="#" data-size="lg"
                                    data-url="{{ route('deliveries.create') }}" data-title="{{ __('Create Delivery') }}">
                                    <i class="ti ti-circle-plus align-text-bottom"></i> {{ __('Create Delivery') }}</a>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="card-body pt-0">
                    <div class="dt-responsive table-responsive">
                        <table class="table table-hover advance-datatable" id="deliveriesTable">
                            <thead>
                                <tr>
                                    <th>{{ __('Order #') }}</th>
                                    <th>{{ __('Customer Name') }}</th>
                                    <th>{{ __('Customer') }}</th>
                                    <th>{{ __('Comment') }}</th>
                                    <th>{{ __('Address') }}</th>
                                    <th>{{ __('City') }}</th>
                                    <th>{{ __('Units') }}</th>
                                    <th>{{ __('Carts') }}</th>
                                    <th>{{ __('Driver') }}</th>
                                    <th>{{ __('Truck') }}</th>
                                    <th>{{ __('Notes') }}</th>
                                    <th>{{ __('Delivery Date') }}</th>

                                    <th>{{ __('Status') }}</th>
                                    
                                        <th class="text-right">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($deliveries as $delivery)
                                    <tr role="row">
                                       <td>{{ $delivery->order_number }}</td>
    <td>{{ $delivery->customer_name }}</td>
    <td>{{ $delivery->customer }}</td>
        <td>{{ $delivery->comment }}</td>
    <td>{{ $delivery->address }}</td>
    <td>{{ $delivery->city }}</td>
    <td>{{ $delivery->units }}</td>
    <td>{{ $delivery->carts }}</td>
   <td>{{ $delivery->driver?->name ?? '-' }}</td>
   
<td>{{ $delivery->truck_number }}</td> <!-- ✅ shows actual truck number -->

    <td>{{ $delivery->notes }}</td>
    <td>{{ \Carbon\Carbon::parse($delivery->delivery_date)->format('M d, Y') }}</td>

    
                                     <td>
    @if ($delivery->status == 'pending')
        <span class="d-inline badge text-bg-primary">Pending</span>
    @elseif ($delivery->status == 'customer_notified')
        <span class="d-inline badge text-bg-info">Customer Notified</span>
    @elseif ($delivery->status == 'in_transit')
        <span class="d-inline badge text-bg-warning">In Transit</span>
    @elseif ($delivery->status == 'cancelled')
        <span class="d-inline badge text-bg-danger">Cancelled</span>
    @elseif ($delivery->status == 'delivered' || $delivery->status == 'complete')
        <span class="d-inline badge text-bg-success">{{ ucfirst($delivery->status) }}</span>
    @else
        <span class="d-inline badge text-bg-secondary">{{ ucfirst($delivery->status) }}</span>
    @endif
</td>

                                        
                                        
                                        <td>
    @if (Gate::check('edit delivery') || Gate::check('delete delivery') || Gate::check('show delivery'))
        <div class="cart-action">
            {!! Form::open(['method' => 'DELETE', 'route' => ['deliveries.destroy', $delivery->id]]) !!}
            @can('show delivery')
                <a class="avtar avtar-xs btn-link-warning text-warning customModal"
                    data-bs-toggle="tooltip"
                    data-bs-original-title="{{ __('Details') }}" href="#"
                    data-size="lg" data-url="{{ route('deliveries.show', $delivery->id) }}"
                    data-title="{{ __('Delivery Details') }}">
                    <i data-feather="eye"></i></a>
            @endcan
            @can('edit delivery')
                <a class="avtar avtar-xs btn-link-secondary text-secondary customModal"
                    data-bs-toggle="tooltip"
                    data-bs-original-title="{{ __('Edit') }}" href="#"
                    data-size="lg" data-url="{{ route('deliveries.edit', $delivery->id) }}"
                    data-title="{{ __('Edit Delivery') }}">
                    <i data-feather="edit"></i></a>
            @endcan
           <!-- @can('delete delivery')
                <a class="avtar avtar-xs btn-link-danger text-danger confirm_dialog"
                    data-bs-toggle="tooltip"
                    data-bs-original-title="{{ __('Delete') }}" href="#">
                    <i data-feather="trash-2"></i></a>
            @endcan-->
            {!! Form::close() !!}
        </div>
    @endif
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

@push('scripts')
<script>
    $(document).on('submit', '#deliveryEditForm', function (e) {
        e.preventDefault();
        let form = $(this);
        let action = form.attr('action');
        let data = form.serialize();

        $.ajax({
            url: action,
            method: 'POST',
            data: data,
            success: function (response) {
                if (response.success) {
                    $('#commonModal').modal('hide');
                    toastr.success(response.message || 'Delivery updated.');

                    // Optional: Reload the page to reflect changes
                    setTimeout(function () {
                        location.reload();
                    }, 1000); // delay to show toast before reload
                } else {
                    toastr.error(response.message || 'Failed to update.');
                }
            },
            error: function (xhr) {
                let message = xhr.responseJSON?.message || 'Server error.';
                toastr.error(message);
            }
        });
    });

    // Optional: Re-initialize tooltips if needed after reload
    $(document).on('shown.bs.modal', function () {
        $('[data-bs-toggle="tooltip"]').tooltip();
    });
</script>
@endpush

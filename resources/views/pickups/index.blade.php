@extends('layouts.app')

@section('page-title')
    {{ __('Pickups') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item" aria-current="page"> {{ __('Pickups') }}</li>
@endsection

@section('card-action-btn')
    @if (Gate::check('create pickup'))
        <a class="btn btn-secondary btn-sm ml-20 customModal" href="#" data-size="lg"
            data-url="{{ route('pickup.create') }}" data-title="{{ __('Create Pickup') }}">
            <i class="ti-plus mr-5"></i>{{ __('Create Pickup') }}</a>
    @endif
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card table-card">
                <div class="card-header">
                    <div class="row align-items-center g-2">
                        <div class="col">
                            <h5>{{ __('Pickups') }}</h5>
                        </div>
                        @if (Gate::check('create pickup'))
                            <div class="col-auto">
                                <a class="btn btn-secondary customModal" href="#" data-size="lg"
                                    data-url="{{ route('pickup.create') }}" data-title="{{ __('Create Pickup') }}">
                                    <i class="ti ti-circle-plus align-text-bottom"></i> {{ __('Create Pickup') }}</a>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="card-body pt-0">
                    <div class="dt-responsive table-responsive">
                        <table class="table table-hover advance-datatable" id="pickupsTable">
                            <thead>
                                <tr>
                                    <th>{{ __('Order #') }}</th>
                                    <th>{{ __('Customer Name') }}</th>
                                    <th>{{ __('Customer') }}</th>
                                    <th>{{ __('Units') }}</th>
                                    <th>{{ __('Carts') }}</th>
                                    <th>{{ __('Date Picked Up') }}</th>

                                    <th>{{ __('Status') }}</th>
                                    
                                        <th class="text-right">{{ __('Action') }}</th>
                                  
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pickups as $pickup)
                                    <tr>
                                        <td>{{ $pickup->order_number }}</td>
                                        <td>{{ $pickup->customer_name }}</td>
                                        <td>{{ $pickup->customer }}</td>
                                        <td>{{ $pickup->units }}</td>
           <td>{{ $pickup->carts }}</td>

                                        <td>
    {{ $pickup->date_picked_up ? \Carbon\Carbon::parse($pickup->date_picked_up)->format('M d, Y') : '-' }}
</td>

                                        <td>
                                            @php
                                                $statusClass = match($pickup->status) {
                                                    'pending' => 'primary',
                                                    'ready' => 'info',
                                                    'picked_up' => 'success',
                                                    'cancelled' => 'danger',
                                                    default => 'secondary'
                                                };
                                            @endphp
                                            <span class="d-inline badge text-bg-{{ $statusClass }}">
                                                {{ ucfirst($pickup->status) }}
                                            </span>
                                        </td>
  <td>
    <div class="cart-action">
        {!! Form::open(['method' => 'DELETE', 'route' => ['pickup.destroy', $pickup->id]]) !!}

        <a class="avtar avtar-xs btn-link-warning text-warning customModal"
            data-bs-toggle="tooltip" title="Details" href="#"
            data-size="lg" data-url="{{ route('pickup.show', $pickup->id) }}"
            data-title="Pickup Details">
            <i data-feather="eye"></i>
        </a>

        <a class="avtar avtar-xs btn-link-secondary text-secondary customModal"
            data-bs-toggle="tooltip" title="Edit" href="#"
            data-size="lg" data-url="{{ route('pickup.edit', $pickup->id) }}"
            data-title="Edit Pickup">
            <i data-feather="edit"></i>
        </a>

        <a class="avtar avtar-xs btn-link-danger text-danger confirm_dialog"
            data-bs-toggle="tooltip" title="Delete" href="#">
            <i data-feather="trash-2"></i>
        </a>

        {!! Form::close() !!}
    </div>
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
    // Handle pickup form submission via AJAX
    $(document).on('submit', '#pickupEditForm', function (e) {
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
                    toastr.success(response.message || 'Pickup updated.');
                    setTimeout(function () {
                        location.reload();
                    }, 1000);
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

    // Tooltip reinitialization for modal elements
    $(document).on('shown.bs.modal', function () {
        $('[data-bs-toggle="tooltip"]').tooltip();
    });

    // ✅ DataTable with pagination length dropdown
    $(function () {
        let table = $('#deliveriesTable');

        if ($.fn.DataTable.isDataTable(table)) {
            table.DataTable().destroy();
        }

        table.DataTable({
            dom: 'lBfrtip', // 'l' shows entries dropdown
            pageLength: 25,
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            buttons: [
                { extend: 'copyHtml5', className: 'btn btn-sm btn-light', exportOptions: { columns: ':visible' } },
                { extend: 'excelHtml5', className: 'btn btn-sm btn-light', exportOptions: { columns: ':visible' } },
                { extend: 'pdfHtml5', className: 'btn btn-sm btn-light', exportOptions: { columns: ':visible' } },
                { extend: 'colvis', className: 'btn btn-sm btn-light' }
            ],
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search deliveries..."
            },
            responsive: true,
            order: [[0, 'desc']]
        });

        $('[data-bs-toggle="tooltip"]').tooltip();
    });
</script>
@endpush



@extends('layouts.app')

@section('page-title')
    {{ __('Locations') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item" aria-current="page"> {{ __('Locations') }}</li>
@endsection

@section('card-action-btn')
<form action="{{ route('cims.import') }}" method="POST" enctype="multipart/form-data" class="d-inline-block">
    @csrf
    <input type="file" name="import_file" accept=".csv, .xls, .xlsx" required class="form-control d-inline-block w-auto">
    <button type="submit" class="btn btn-sm btn-primary">
        <i data-feather="upload"></i> Import Locations
    </button>
</form>

     <!-- <a class="btn btn-outline-primary btn-sm" href="{{ route('cims.import') }}">
        <i class="ti ti-upload"></i> {{ __('Import cims') }}
    </a>
  <a class="btn btn-outline-success btn-sm" href="{{ route('cims.create') }}">
        <i class="ti ti-plus"></i> {{ __('Add cim') }}
    </a>-->
@endsection

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card table-card">
            <div class="card-header">
                <div class="row align-items-center g-2">
                    <div class="col">
                        <h5>{{ __('Locations') }}</h5>
                    </div>
                </div>
            </div>

            <div class="card-body pt-0">
                <div class="dt-responsive table-responsive">
                    <table class="table table-hover advance-datatable" id="cimsTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Order #</th>
                                <th>Cart #</th>
                                <th>Production Barcode</th>
                                <th>Customer</th>
                                <th>Customer Name</th>
                                <th>Short Name</th>
                                <th>Description</th>
                                <th>Comment</th>
                                <th>Width</th>
                                <th>Height</th>
                             <!--    <th>Action</th>-->
                              
                       
                           
                             
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cims as $cim)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $cim->order_number }}</td>
                                    <td>{{ $cim->cart_barcode }}</td>
                                    <td>{{ $cim->production_barcode }}</td>
                                    <td>{{ $cim->customer }}</td>
                                    <td>{{ $cim->customer_name }}</td>
                                    <td>{{ $cim->customer_short_name }}</td>
                                    <td>{{ $cim->description }}</td>
                                    <td>{{ $cim->comment }}</td>
                                    <td>{{ $cim->width }}</td>
                                    <td>{{ $cim->height }}</td>
                                   
                                
                                  <!--  <td>
                                        <div class="cart-action">
                                            <a class="avtar avtar-xs btn-link-warning text-warning customModal"
                                                data-bs-toggle="tooltip" title="{{ __('Details') }}" href="#"
                                                data-size="lg" data-url="{{ route('cims.show', $cim->id) }}"
                                                data-title="{{ __('CIM Details') }}">
                                                <i data-feather="eye"></i>
                                            </a>
                                            <a class="avtar avtar-xs btn-link-secondary text-secondary customModal"
                                                data-bs-toggle="tooltip" title="{{ __('Edit') }}" href="#"
                                                data-size="lg" data-url="{{ route('cims.edit', $cim->id) }}"
                                                data-title="{{ __('Edit cim') }}">
                                                <i data-feather="edit"></i>
                                            </a>
                                            <a class="avtar avtar-xs btn-link-danger text-danger confirm_dialog"
                                                data-bs-toggle="tooltip" title="{{ __('Delete') }}"
                                                data-url="{{ route('cims.destroy', $cim->id) }}"
                                                data-confirm="{{ __('Are you sure?') }}">
                                                <i data-feather="trash-2"></i>
                                            </a>
                                        </div>
                                    </td>-->
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
   // Custom Modal Loader
    $(document).on('click', '.customModal', function (e) {
        e.preventDefault();
        let url = $(this).data('url');
        let title = $(this).data('title');
        let size = $(this).data('size') ?? 'md';

        $.ajax({
            url: url,
            success: function (response) {
                $('#commonModal .modal-title').text(title);
                $('#commonModal .modal-body').html(response);
                $('#commonModal .modal-dialog')
                    .removeClass('modal-sm modal-md modal-lg modal-xl')
                    .addClass('modal-' + size);
                $('#commonModal').modal('show');
            },
            error: function () {
                alert('Failed to load modal.');
            }
        });
    });

</script>
@endpush


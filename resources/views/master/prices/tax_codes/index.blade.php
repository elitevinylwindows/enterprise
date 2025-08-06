@extends('layouts.app')

@section('page-title')
    {{ __('Tax Codes') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Tax Codes') }}</li>
@endsection

@section('content')
<div class="mb-4"></div>

<div class="row">
    <div class="col-auto ms-auto">
        <a href="javascript:void(0);" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createTaxCodeModal">
            <i class="fas fa-circle-plus"></i> Create Tax Code
        </a>
    </div>
</div>

<div class="mb-4"></div>

<div class="row">
    <div class="col-sm-12">
        <div class="card table-card">
            <div class="card-header">
                <div class="row align-items-center g-2">
                    <div class="col">
                        <h5>{{ __('Tax Codes List') }}</h5>
                    </div>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="dt-responsive table-responsive">
                    <table class="table table-hover advance-datatable" id="taxCodesTable">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Code</th>
                                <th>City</th>
                                <th>Description</th>
                                <th>Rate (%)</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($taxCodes as $tax)
                                <tr>
                                    <td>{{ $tax->id }}</td>
                                    <td>{{ $tax->code }}</td>
                                    <td>{{ $tax->city }}</td>
                                    <td>{{ $tax->description }}</td>
                                    <td>{{ $tax->rate }}</td>
                                    <td class="text-nowrap">
                                        {{-- Edit --}}
                                        <a class="avtar avtar-xs btn-link-primary text-primary customModal"
                                           data-bs-toggle="tooltip"
                                           title="Edit"
                                           href="#"
                                           data-size="md"
                                           data-url="{{ route('master.prices.tax_codes.edit', $tax->id) }}"
                                           data-title="Edit Tax Code">
                                            <i data-feather="edit"></i>
                                        </a>

                                        {{-- Delete --}}
                                        <form action="{{ route('master.prices.tax_codes.destroy', $tax->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure you want to delete this tax code?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="avtar avtar-xs btn-link-danger text-danger border-0 bg-transparent" data-bs-toggle="tooltip" title="Delete">
                                                <i data-feather="trash-2"></i>
                                            </button>
                                        </form>
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

{{-- Create Modal --}}
@include('master.prices.tax_codes.create')

{{-- Dynamic Edit Modal Container --}}
<div class="modal fade" id="dynamicEditModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content" id="dynamicEditContent">
            <div class="modal-body text-center p-5">
                <div class="spinner-border text-primary" role="status"></div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Edit modal trigger
    $(document).on('click', '.customModal', function (e) {
        e.preventDefault();
        const url = $(this).data('url');
        $('#dynamicEditModal').modal('show');
        $('#dynamicEditContent').html('<div class="modal-body text-center p-5"><div class="spinner-border text-primary" role="status"></div></div>');

        $.get(url, function (response) {
            $('#dynamicEditContent').html(response);
        }).fail(function () {
            $('#dynamicEditContent').html('<div class="modal-body text-center p-5 text-danger">Failed to load content.</div>');
        });
    });

    // ✅ Safe DataTable init — prevent double initialization
    $(document).ready(function () {
        if (!$.fn.DataTable.isDataTable('#taxCodesTable')) {
            $('#taxCodesTable').DataTable({
                responsive: true
            });
        }
    });
</script>
@endpush

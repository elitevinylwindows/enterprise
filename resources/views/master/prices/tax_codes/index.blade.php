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
                                           data-bs-original-title="Edit"
                                           href="#"
                                           data-size="md"
                                           data-url="{{ route('master.tax-codes.edit', $tax->id) }}"
                                           data-title="Edit Tax Code">
                                            <i data-feather="edit"></i>
                                        </a>

                                        {{-- Delete --}}
                                        <a class="avtar avtar-xs btn-link-danger text-danger customModal"
                                           data-bs-toggle="tooltip"
                                           data-bs-original-title="Delete"
                                           href="#"
                                           data-size="sm"
                                           data-url="{{ route('master.tax-codes.destroy', $tax->id) }}"
                                           data-title="Delete Tax Code">
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

@include('master.prices.tax_codes.create') {{-- Modal View --}}

@extends('layouts.app')

@section('page-title')
    {{ __('Material Prices') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item">{{ __('Bill of Material') }}</li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Material Prices') }}</li>
@endsection

@section('card-action-btn')
    <button type="button" class="btn btn-md btn-primary me-2" data-bs-toggle="modal" data-bs-target="#addMaterialModal">
        <i class="ti ti-plus"></i> Add Material
    </button>
    <form action="{{ route('price.import') }}" method="POST" enctype="multipart/form-data" class="d-inline-block">
        @csrf
        <input type="file" name="import_file" accept=".csv, .xls, .xlsx" required class="form-control d-inline-block w-auto">
        <button type="submit" class="btn btn-md btn-outline-primary">
            <i class="ti ti-upload"></i> Import Prices
        </button>
    </form>
@endsection

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card table-card">
            <div class="card-header">
                <div class="row align-items-center g-2">
                    <div class="col">
                        <h5 class="mb-0">{{ __('Material Prices List') }}</h5>
                    </div>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="dt-responsive table-responsive">
                    <table class="table table-hover" id="pricesTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Material Name</th>
                                <th>Description</th>
                                <th>Unit</th>
                                <th>Vendor</th>
                                <th>Price</th>
                                <th>Sold By</th>
                                <th>L in/Each Pcs</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($prices as $price)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $price->material_name }}</td>
                                    <td>{{ $price->description }}</td>
                                    <td>{{ $price->unit }}</td>
                                    <td>{{ $price->vendor }}</td>
                                    <td>${{ number_format($price->price, 2) }}</td>
                                    <td>{{ $price->sold_by }}</td>
                                    <td>{{ $price->lin_pcs }}</td>
                                    <td class="text-end">
                                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editPriceModal{{ $price->id }}">
                                            Edit
                                        </button>
                                        <form action="{{ route('prices.destroy', $price->id) }}" method="POST" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>

                                <!-- Edit Modal -->
                                <div class="modal fade" id="editPriceModal{{ $price->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            @include('bill_of_material.prices.edit', ['price' => $price])
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addMaterialModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            @include('bill_of_material.prices.create')
        </div>
    </div>
</div>
@endsection

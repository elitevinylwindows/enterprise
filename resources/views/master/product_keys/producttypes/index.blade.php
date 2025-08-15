@extends('layouts.app')

@section('page-title')
    {{ __('Product Type') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="#">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Product Type') }}</li>
@endsection

@section('card-action-btn')
    <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
        <i data-feather="plus"></i> {{ __('Add Product Type') }}
    </a>
@endsection

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card table-card">
            <div class="card-header">
                <div class="row align-items-center g-2">
                    <div class="col">
                        <h5>{{ __('Product Type') }}</h5>
                    </div>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="dt-responsive table-responsive">
                    <table class="table table-hover advance-datatable" id="dataTable">
                        <thead>
                            <tr>
                                <th>{{ __('Product Type') }}</th>
                                <th>{{ __('Description') }}</th>
                                <th>{{ __('Material Type') }}</th>
                                <th>{{ __('Glazing Bead Position') }}</th>
                                <th>{{ __('Schema Product ID') }}</th>
                                <th class="text-end">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $item)
                                <tr>
                                    <td>{{ $item->product_type }}</td>
                                    <td>{{ $item->description }}</td>
                                    <td>{{ $item->material_type }}</td>
                                    <td>{{ $item->glazing_bead_position }}</td>
                                    <td>{{ $item->product_id }}</td>
                                    <td class="text-end">
    <a href="#" class="btn btn-sm btn-info me-1" data-bs-toggle="modal" data-bs-target="#editModal{{ $item->id }}">
        <i data-feather="edit"></i>
    </a>

    <form action="{{ route('product_keys.producttypes.destroy', $item->id) }}" method="POST" class="d-inline">
        @csrf
        @method('DELETE')
        <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
            <i data-feather="trash-2"></i>
        </button>
    </form>
</td>

                                </tr>

                                <!-- Edit Modal -->
                                <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            @include('master.product_keys.producttypes.edit', ['productType' => $item])
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

<!-- Create Modal -->
<div class="modal fade" id="createModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            @include('master.product_keys.producttypes.create')
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('page-title')
    {{ __('Grid Type') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item">{{ __('BOM Menu') }}</li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Grid Type') }}</li>
@endsection

@section('card-action-btn')
    <button type="button" class="btn btn-md btn-primary me-2" data-bs-toggle="modal" data-bs-target="#addItemModal">
        <i class="ti ti-plus"></i> Add Grid Type
    </button>
@endsection

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card table-card">
            <div class="card-header">
                <div class="row align-items-center g-2">
                    <div class="col">
                        <h5>{{ __('Grid Type List') }}</h5>
                    </div>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="dt-responsive table-responsive">
                    <table class="table table-hover advance-datatable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th><th>Color</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($gridtype as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->name }}</td><td>{{ $item->color }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editItemModal{{ $item->id }}">
                                            Edit
                                        </button>
                                        <form action="{{ route('gridtype.destroy', $item->id) }}" method="POST" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
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

<!-- Add Modal -->
<div class="modal fade" id="addItemModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            @include('bill_of_material.menu.GridType.create')
        </div>
    </div>
</div>

<!-- Edit Modals -->
@foreach($gridtype as $item)
    <div class="modal fade" id="editItemModal{{ $item->id }}" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                @include('bill_of_material.menu.GridType.edit', ['item' => $item])
            </div>
        </div>
    </div>
@endforeach
@endsection

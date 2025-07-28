@extends('layouts.app')

@section('page-title')
    {{ __('Glass Type') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item">{{ __('BOM Menu') }}</li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Glass Type') }}</li>
@endsection

@section('card-action-btn')
    <button type="button" class="btn btn-md btn-primary me-2" data-bs-toggle="modal" data-bs-target="#addItemModal">
        <i class="ti ti-plus"></i> Add Glass Type
    </button>
@endsection

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card table-card">
            <div class="card-header">
                <div class="row align-items-center g-2">
                    <div class="col">
                        <h5>{{ __('Glass Type List') }}</h5>
                    </div>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="dt-responsive table-responsive">
                    <table class="table table-hover advance-datatable">
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>3.1mm</th>
            <th>3.9mm</th>
            <th>4.7mm</th>
            <th>5.7mm</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($glasstype as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->thickness_3_1_mm }}</td>
                <td>{{ $item->thickness_3_9_mm }}</td>
                <td>{{ $item->thickness_4_7_mm }}</td>
                <td>{{ $item->thickness_5_7_mm }}</td>
                <td>...</td>
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
            @include('bill_of_material.menu.GlassType.create')
        </div>
    </div>
</div>

<!-- Edit Modals -->
@foreach($glasstype as $item)
    <div class="modal fade" id="editItemModal{{ $item->id }}" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                @include('bill_of_material.menu.GlassType.edit', ['item' => $item])
            </div>
        </div>
    </div>
@endforeach
@endsection

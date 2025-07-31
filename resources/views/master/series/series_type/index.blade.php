@extends('layouts.app')

@section('page-title')
    {{ __('Configuration') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item">{{ __('Master') }}</li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Configuration') }}</li>
@endsection

@section('card-action-btn')
    <button type="button" class="btn btn-md btn-primary me-2" data-bs-toggle="modal" data-bs-target="#addItemModal">
        <i class="ti ti-plus"></i> Add Configuration
    </button>
@endsection

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card table-card">
            <div class="card-header">
                <div class="row align-items-center g-2">
                    <div class="col">
                        <h5>{{ __('Series Configurations') }}</h5>
                    </div>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="dt-responsive table-responsive">
                    <table class="table table-hover advance-datatable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Series</th>
                                <th>Product Type</th>
                                <th>Series Type</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($seriesTypes as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->series->series ?? '-' }}</td>
                                    <td>{{ $item->productType->product_type ?? '-' }}</td>
                                    <td><span class="badge bg-primary">{{ $item->series_type }}</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#editItemModal{{ $item->id }}">Edit</button>

                                        <form action="{{ route('master.series-type.destroy', $item->id) }}" method="POST" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>

                                <!-- Edit Modal -->
                                <div class="modal fade" id="editItemModal{{ $item->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            @include('master.series.series_type.edit', [
                                                'seriesType' => $item,
                                                'series' => $series,
                                                'productTypes' => $productTypes
                                            ])
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
<div class="modal fade" id="addItemModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            @include('master.series.series_type.create', [
                'series' => $series,
                'productTypes' => $productTypes
            ])
        </div>
    </div>
</div>
@endsection

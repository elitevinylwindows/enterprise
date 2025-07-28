@extends('layouts.app')

@section('page-title')
    {{ __('Series Names') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item">{{ __('Master') }}</li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Series Names') }}</li>
@endsection

@section('card-action-btn')
    <button type="button" class="btn btn-md btn-primary me-2" data-bs-toggle="modal" data-bs-target="#addItemModal">
        <i class="ti ti-plus"></i> Add Series Names
    </button>
@endsection

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card table-card">
            <div class="card-header">
                <div class="row align-items-center g-2">
                    <div class="col">
                        <h5>{{ __('Series Names List') }}</h5>
                    </div>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="dt-responsive table-responsive">
                    <table class="table table-hover advance-datatable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Series</th>
                                <th>Series Names</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
@foreach($seriesNames as $seriesName)
    <tr>
        <td>{{ $seriesName->id }}</td>
        <td>{{ $seriesName->series->series ?? '-' }}</td>
        <td>{{ $seriesName->series_name }}</td>
        <td>
            <!-- Edit Button -->
            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editItemModal{{ $seriesName->id }}">
                Edit
            </button>

            <!-- Delete Form -->
            <form action="{{ route('master.series-name.destroy', $seriesName->id) }}" method="POST" class="d-inline">
                @csrf @method('DELETE')
                <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
            </form>
        </td>
    </tr>

    <!-- Edit Modal -->
    <div class="modal fade" id="editItemModal{{ $seriesName->id }}" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                @include('master.series.series_name.edit', [
                    'seriesName' => $seriesName,
                    'series' => $series
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
            @include('master.series.series_name.create')
        </div>
    </div>
</div>


@endsection

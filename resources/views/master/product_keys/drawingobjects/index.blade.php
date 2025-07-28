@extends('layouts.app')

@section('page-title')
    {{ __('Drawingobject') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="#">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Drawingobject') }}</li>
@endsection

@section('card-action-btn')
    <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
        <i data-feather="plus"></i> {{ __('Add Drawingobject') }}
    </a>
@endsection

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card table-card">
            <div class="card-header">
                <div class="row align-items-center g-2">
                    <div class="col">
                        <h5>{{ __('Drawingobject') }}</h5>
                    </div>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="dt-responsive table-responsive">
                    <table class="table table-hover advance-datatable" id="dataTable">
                        <thead>
                            <tr>
                                <th>{{{ __('Object Id') }}}</th>
<th>{{{ __('Description') }}}</th>
                                <th class="text-end">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $item)
                                <tr>
                                    <td>{{ $item->object_id }}</td>
<td>{{ $item->description }}</td>
                                    <td class="text-end">
                                        <a href="#" class="btn btn-sm btn-info" data-id="{ $item->id }"><i data-feather="edit"></i></a>
                                        <button class="btn btn-sm btn-danger" data-id="{ $item->id }"><i data-feather="trash-2"></i></button>
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

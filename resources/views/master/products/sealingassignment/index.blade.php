@extends('layouts.app')

@section('page-title')
    {{ __('SealingAssignment') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="#">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('SealingAssignment') }}</li>
@endsection

@section('card-action-btn')
    <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
        <i data-feather="plus"></i> {{ __('Add SealingAssignment') }}
    </a>
@endsection

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card table-card">
            <div class="card-header">
                <div class="row align-items-center g-2">
                    <div class="col">
                        <h5>{{ __('SealingAssignment') }}</h5>
                    </div>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="dt-responsive table-responsive">
                    <table class="table table-hover advance-datatable" id="dataTable">
                        <thead>
                            <tr>
                                <th>{{ __('Rebate Depth') }}</th>
<th>{{ __('Installation Thickness From') }}</th>
<th>{{ __('Installation Thickness To') }}</th>
<th>{{ __('Style') }}</th>
<th>{{ __('Profile System') }}</th>
<th>{{ __('Condition') }}</th>
<th>{{ __('Comment') }}</th>
<th>{{ __('Area') }}</th>
<th>{{ __('Evaluation') }}</th>
<th>{{ __('Manufacturer System') }}</th>
<th>{{ __('Sort Order') }}</th>
                                <th class="text-end">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $item)
                                <tr>
                                    <td>{{ $item->rebate_depth }}</td>
<td>{{ $item->installation_thickness_from }}</td>
<td>{{ $item->installation_thickness_to }}</td>
<td>{{ $item->style }}</td>
<td>{{ $item->profile_system }}</td>
<td>{{ $item->condition }}</td>
<td>{{ $item->comment }}</td>
<td>{{ $item->area }}</td>
<td>{{ $item->evaluation }}</td>
<td>{{ $item->manufacturer_system }}</td>
<td>{{ $item->sort_order }}</td>
                                    <td class="text-end">
                                        <a href="#" class="btn btn-sm btn-info" data-id="{{ $item->id }}"><i data-feather="edit"></i></a>
                                        <button class="btn btn-sm btn-danger" data-id="{{ $item->id }}"><i data-feather="trash-2"></i></button>
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

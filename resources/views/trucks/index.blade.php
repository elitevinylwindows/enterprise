@extends('layouts.app')

@section('page-title')
    {{ __('Truck Board') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item" aria-current="page">{{ __('Trucks') }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center g-2">
                        <div class="col">
                            <h5>{{ __('Truck List') }}</h5>
                        </div>
                        @if(Gate::check('create truck'))
                            <div class="col-auto">
                                <a href="#" class="btn btn-secondary customModal" data-size="md"
                                   data-url="{{ route('trucks.create') }}" data-title="{{ __('Add Truck') }}">
                                    <i class="ti ti-circle-plus align-text-bottom"></i> {{ __('Add Truck') }}
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                   <div class="card-body pt-0">
                <div class="dt-responsive table-responsive">
                    <table class="table table-hover advance-datatable" id="ordersTable">
                        <thead>
                            <tr>
                                <th>{{ __('Truck Number') }}</th>
                                <th>{{ __('Model') }}</th>
                                <th>{{ __('Capacity') }}</th>
                                <th>{{ __('License Plate') }}</th>
                                <th>{{ __('Created Date') }}</th>
                                <th class="text-end">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($trucks as $truck)
                                <tr>
                                    <td>{{ $truck->truck_number }}</td>
                                    <td>{{ $truck->model }}</td>
                                    <td>{{ $truck->capacity }}</td>
                                    <td>{{ $truck->license_plate }}</td>
                                    <td>{{ dateFormat($truck->created_at) }}</td>
                                    <td class="text-end">
                                        @if (Gate::check('edit truck') || Gate::check('delete truck'))
                                            <div class="d-flex justify-content-end">
                                                @can('edit truck')
                                                    <a href="#" class="btn btn-sm btn-info customModal me-1"
                                                       data-url="{{ route('trucks.edit', $truck->id) }}"
                                                       data-title="{{ __('Edit Truck') }}">
                                                        <i class="ti ti-edit"></i>
                                                    </a>
                                                @endcan
                                                @can('delete truck')
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['trucks.destroy', $truck->id], 'id' => 'truck-'.$truck->id]) !!}
                                                        <button type="submit" class="btn btn-sm btn-danger confirm_dialog">
                                                            <i class="ti ti-trash"></i>
                                                        </button>
                                                    {!! Form::close() !!}
                                                @endcan
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">{{ __('No trucks found.') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('page-title')
    {{ __('Drivers') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item" aria-current="page">{{ __('Drivers') }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center g-2">
                        <div class="col">
                            <h5>{{ __('Driver List') }}</h5>
                        </div>
                        @if(Gate::check('create driver'))
                            <div class="col-auto">
                                <a href="#" class="btn btn-secondary customModal" data-size="md"
                                   data-url="{{ route('drivers.create') }}" data-title="{{ __('Add Driver') }}">
                                    <i class="ti ti-circle-plus align-text-bottom"></i> {{ __('Add Driver') }}
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
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Phone') }}</th>
                                    <th>{{ __('Email') }}</th>
                                    <th>{{ __('License Number') }}</th>
                                    <th>{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($drivers as $driver)
                                    <tr>
                                        <td>{{ $driver->name }}</td>
                                        <td>{{ $driver->phone }}</td>
                                        <td>{{ $driver->email }}</td>
                                        <td>{{ $driver->license_number }}</td>
                                        <td class="text-end">
                                        @if (Gate::check('edit driver') || Gate::check('delete driver'))
                                            <div class="d-flex justify-content-end">
                                                @can('edit driver')
                                                    <a href="#" class="btn btn-sm btn-info customModal me-1"
                                                       data-url="{{ route('drivers.edit', $driver->id) }}"
                                                       data-title="{{ __('Edit driver') }}">
                                                        <i class="ti ti-edit"></i>
                                                    </a>
                                                @endcan
                                                @can('delete driver')
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['drivers.destroy', $driver->id], 'id' => 'driver-'.$driver->id]) !!}
                                                        <button type="submit" class="btn btn-sm btn-danger confirm_dialog">
                                                            <i class="ti ti-trash"></i>
                                                        </button>
                                                    {!! Form::close() !!}
                                                @endcan
                                            </div>
                                        @endif
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

@extends('layouts.app')
@section('page-title')
    {{ __('Role') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item" aria-current="page"> {{ __('Role') }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card table-card">
                <div class="card-header">
                    <div class="row align-items-center g-2">
                        <div class="col">
                            <h5>{{ __('Role List') }}</h5>
                        </div>
                        @if (Gate::check('create role'))
                            <div class="col-auto">
                                <a class="btn btn-secondary"
                                href="{{ route('role.create') }}"> <i
                                        class="ti ti-circle-plus align-text-bottom"></i> {{ __('Create Role') }}</a>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="dt-responsive table-responsive">
                        <table class="table table-hover advance-datatable">
                            <thead>
                                <tr>
                                    <th>{{ __('Role') }}</th>
                                    <th>{{ __('Assigned Users') }}</th>
                                    <th>{{ __('Assigned Permissions') }}</th>
                                    <th class="text-right">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roleData as $role)
                                    <tr>
                                        <td>{{ ucfirst($role->name) }} </td>
                                        <td>{{ \Auth::user()->roleWiseUserCount($role->name) }}</td>
                                        <td>{{ $role->permissions()->count() }}</td>
                                        <td>
                                            <div class="cart-action">
                                                {!! Form::open(['method' => 'DELETE', 'route' => ['role.destroy', $role->id]]) !!}
                                                @can('edit role')
                                                    <a class="avtar avtar-xs btn-link-secondary text-secondary" data-bs-toggle="tooltip" data-bs-original-title="{{ __('Edit') }}"
                                                        href="{{ route('role.edit', $role->id) }}"> <i data-feather="edit"></i></a>
                                                @endcan
                                                @if ($role->name != 'tenant' && $role->name != 'maintainer')
                                                    @can('delete role')
                                                        <a class=" avtar avtar-xs btn-link-danger text-danger confirm_dialog" data-bs-toggle="tooltip"
                                                            data-bs-original-title="{{ __('Detete') }}" href="#"> <i
                                                                data-feather="trash-2"></i></a>
                                                    @endcan
                                                @endif
                                                {!! Form::close() !!}
                                            </div>

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

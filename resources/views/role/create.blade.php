@extends('layouts.app')
@section('page-title')
    {{ __('Role') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('role.index') }}">{{ __('Role') }}</a></li>
    <li class="breadcrumb-item" aria-current="Create"> {{ __('Create') }}</li>
@endsection

@section('content')
    @php
        $systemModules = \App\Models\User::$systemModules;
    @endphp

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center g-2">
                        <div class="col">
                            <h5>{{ __('Create Role And Permissions') }}</h5>
                        </div>

                    </div>
                </div>
                <div class="card-body">
                    {{ Form::open(['url' => 'role']) }}
                    <div class="form-group">
                        {{ Form::label('title', __('Role Title'), ['class' => 'form-label']) }}
                        {{ Form::text('title', null, ['class' => 'form-control', 'placeholder' => __('Enter role title') ]) }}
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-12 col-md-12">
                                @foreach ($systemModules as $module)
                                    <div class="row">
                                        @foreach ($permissionList as $permission)
                                            @if (str_contains(strtolower($permission->name), strtolower($module)))
                                                <div class="form-check custom-chek form-check-inline col-md-2">
                                                    {{ Form::checkbox('user_permission[]', $permission->id, null, ['class' => 'form-check-input', 'id' => $module . '_permission' . $permission->id]) }}
                                                    {{ Form::label($module . '_permission' . $permission->id, ucfirst($permission->name), ['class' => 'form-check-label']) }}
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                    <hr>
                                @endforeach

                            </div>
                        </div>
                    </div>

                    <div class="form-group mt-20 text-end">
                        {{ Form::submit(__('Create'), ['class' => 'btn btn-secondary btn-rounded']) }}
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection

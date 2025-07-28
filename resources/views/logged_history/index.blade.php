@extends('layouts.app')
@section('page-title')
    {{ __('Logged History') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item" aria-current="page"> {{ __('Logged History') }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card table-card">
                <div class="card-header">
                    <div class="row align-items-center g-2">
                        <div class="col">
                            <h5>{{ __('Logged History List') }}</h5>
                        </div>

                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="dt-responsive table-responsive">
                        <table class="table table-hover advance-datatable">
                            <thead>
                                <tr>
                                    <th>{{ __('User') }}</th>
                                    <th>{{ __('Email') }}</th>
                                    <th>{{ __('Login Date') }}</th>
                                    <th>{{ __('System IP') }}</th>
                                    <th>{{ __('City') }}</th>
                                    <th>{{ __('State') }}</th>
                                    <th>{{ __('Country') }}</th>
                                    <th>{{ __('System') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($histories as $history)
                                    @php
                                        $historydetail = json_decode($history->details);
                                    @endphp
                                    <tr>
                                        <td>{{ !empty($history->user) ? $history->user->name : '-' }}</td>
                                        <td>{{ !empty($history->user) ? $history->user->email : '-' }}</td>
                                        <td>{{ !empty($history->date) ? dateFormat($history->date) : '-' }}</td>
                                        <td>{{ $history->ip }}</td>
                                        <td>{{ !empty($historydetail) ? $historydetail->city : '-' }}</td>
                                        <td>{{ !empty($historydetail) ? $historydetail->regionName : '-' }}</td>
                                        <td>{{ !empty($historydetail) ? $historydetail->country : '-' }}</td>
                                        <td>{{ !empty($historydetail) ? $historydetail->os : '-' }}</td>
                                        <td class="text-right">
                                            <div class="cart-action">
                                                {!! Form::open(['method' => 'DELETE', 'route' => ['logged.history.destroy', $history->id]]) !!}
                                                <a class=" avtar avtar-xs btn-link-danger text-danger confirm_dialog" data-bs-toggle="tooltip"
                                                    data-bs-original-title="{{ __('Detete') }}" href="#"> <i
                                                        data-feather="trash-2"></i></a>
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

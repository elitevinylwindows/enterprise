@extends('layouts.app')
@section('page-title')
    {{ __('Pre Register Visitor') }}
@endsection
@php
    $ids = parentId();
    $authUser = \App\Models\User::find($ids);
    $subscription = \App\Models\Subscription::find($authUser->subscription);
@endphp


@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item" aria-current="page"> {{ __('Pre Register Visitor') }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card table-card">

                <div class="card-header">
                    <div class="row align-items-center g-2">
                        <div class="col">
                            <h5>{{ __('Pre Register Visitor') }}</h5>
                        </div>
                        @if (Gate::check('manage pre register visitor') &&
                                $subscription->enabled_pre_register == 1 &&
                                \Auth::user()->type == 'owner')
                            <div class="col-auto">
                                <a class="btn btn-secondary copy_register_link" href="#"
                                    data-url="{{ route('pre-register', \Auth::user()->code) }}"> {{ __('Copy Link') }}</a>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="card-body pt-0">
                    <div class="dt-responsive table-responsive">
                        <table class="table table-hover advance-datatable">
                            <thead>
                                <tr>
                                    <th>{{ __('ID') }}</th>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Email') }}</th>
                                    <th>{{ __('Phone Number') }}</th>
                                    <th>{{ __('Category') }}</th>
                                    <th>{{ __('Date') }}</th>
                                    <th>{{ __('Entry Time') }}</th>
                                    <th>{{ __('Exit Time') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    @if (Gate::check('delete pre register visitor') || Gate::check('show pre register visitor'))
                                        <th class="text-right">{{ __('Action') }}</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($visitors as $visitor)
                                    <tr role="row">
                                        <td> {{ visitorPrefix() . $visitor->visitor_id }} </td>
                                        <td> {{ $visitor->first_name . ' ' . $visitor->last_name }} </td>
                                        <td> {{ $visitor->email }} </td>
                                        <td> {{ $visitor->phone_number }} </td>
                                        <td>
                                            {{ !empty($visitor->categories) ? $visitor->categories->title : '-' }}
                                        </td>
                                        <td>
                                            {{ dateFormat($visitor->date) }}
                                        </td>
                                        <td>
                                            {{ timeFormat($visitor->entry_time) }}
                                        </td>
                                        <td>
                                            @if (!empty($visitor->exit_time))
                                                {{ timeFormat($visitor->exit_time) }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @if ($visitor->status == 'pending')
                                                <span
                                                    class="d-inline badge text-bg-primary">{{ \App\Models\Visitor::$status[$visitor->status] }}</span>
                                            @elseif($visitor->status == 'cancelled')
                                                <span
                                                    class="d-inline badge text-bg-warning">{{ \App\Models\Visitor::$status[$visitor->status] }}</span>
                                            @elseif($visitor->status == 'rejected')
                                                <span
                                                    class="d-inline badge text-bg-danger">{{ \App\Models\Visitor::$status[$visitor->status] }}</span>
                                            @elseif($visitor->status == 'completed')
                                                <span
                                                    class="d-inline badge text-bg-success">{{ \App\Models\Visitor::$status[$visitor->status] }}</span>
                                            @endif
                                        </td>
                                        @if (Gate::check('delete pre register visitor') || Gate::check('show pre register visitor'))
                                            <td class="text-right">
                                                <div class="cart-action">
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['visitor.pre-register.destroy', $visitor->id]]) !!}
                                                    @if (Gate::check('show pre register visitor'))
                                                        <a class="text-warning customModal" data-bs-toggle="tooltip"
                                                            data-bs-original-title="{{ __('Details') }}" href="#"
                                                            data-size="lg"
                                                            data-url="{{ route('visitor.show', $visitor->id) }}"
                                                            data-title="{{ __('Visitor Details') }}"> <i
                                                                data-feather="eye"></i></a>

                                                        @if (Gate::check('delete pre register visitor'))
                                                            <a class=" text-danger confirm_dialog" data-bs-toggle="tooltip"
                                                                data-bs-original-title="{{ __('Detete') }}"
                                                                href="#"> <i data-feather="trash-2"></i></a>
                                                        @endif
                                                    @endif

                                                    {!! Form::close() !!}
                                                </div>
                                            </td>
                                        @endif
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

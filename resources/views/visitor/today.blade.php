@extends('layouts.app')
@section('page-title')
    {{ __('Today Visitor') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item" aria-current="page"> {{ __('Today Visitor') }}</li>
@endsection


@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card table-card">
                <div class="card-header">
                    <div class="row align-items-center g-2">
                        <div class="col">
                            <h5>
                                {{ __('Visit Category') }}
                            </h5>
                        </div>

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
                                    <th>{{ __('Entry Time') }}</th>
                                    <th>{{ __('Exit Time') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    @if (Gate::check('edit visitor') || Gate::check('show visitor'))
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
                                        @if (Gate::check('edit visitor') || Gate::check('show visitor'))
                                            <td>
                                                <div class="cart-action">
                                                    @can('edit visitor')
                                                        <a class="avtar avtar-xs btn-link-secondary text-secondary customModal" data-bs-toggle="tooltip"
                                                            data-bs-original-title="{{ __('Edit') }}" href="#"
                                                            data-size="lg" data-url="{{ route('visitor.edit', $visitor->id) }}"
                                                            data-title="{{ __('Edit Visitor') }}"> <i
                                                                data-feather="edit"></i></a>
                                                    @endcan

                                                    @can('show visitor')
                                                        <a class="avtar avtar-xs btn-link-warning text-warning customModal" data-bs-toggle="tooltip"
                                                            data-bs-original-title="{{ __('Details') }}" href="#"
                                                            data-size="lg" data-url="{{ route('visitor.show', $visitor->id) }}"
                                                            data-title="{{ __('Visitor Details') }}"> <i
                                                                data-feather="eye"></i></a>
                                                    @endcan
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

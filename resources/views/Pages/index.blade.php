@extends('layouts.app')
@section('page-title')
    {{ __('Page') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item" aria-current="page"> {{ __('Page') }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card table-card">
                <div class="card-header">
                    <div class="row align-items-center g-2">
                        <div class="col">
                            <h5>{{ __('Page') }}</h5>
                        </div>
                        @can('create Page')
                            <div class="col-auto">
                                <a href="#" class="btn btn-secondary customModal" data-size="xl"
                                    data-url="{{ route('pages.create') }}" data-title="{{ __('Create New Page') }}">
                                    <i class="ti ti-circle-plus align-text-bottom"></i> {{ __('Create Page') }}</a>
                            </div>
                        @endcan

                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="dt-responsive table-responsive">
                        <table class="table table-hover advance-datatable">
                            <thead>
                                <tr>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Enable') }}</th>
                                    @if (Gate::check('edit Page') || Gate::check('delete Page'))
                                        <th>{{ __('Action') }}</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($Pages as $item)
                                    <tr>
                                        <td>{{ $item->title }} </td>
                                        <td>

                                            @if ($item->enabled == 1)
                                                <span class="d-inline badge text-bg-success">{{ __('Enable') }}</span>
                                            @else
                                                <span class="d-inline badge text-bg-danger">{{ __('Disable') }}</span>
                                            @endif

                                        </td>
                                        @if (Gate::check('edit Page') || Gate::check('delete Page'))
                                            <td>
                                                <div class="cart-action">
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['pages.destroy', $item->id]]) !!}
                                                    @can('show Page')
                                                        <a class="avtar avtar-xs btn-link-warning text-warning customModal" data-bs-toggle="tooltip"
                                                            data-size="xl" data-bs-original-title="{{ __('Edit') }}"
                                                            href="#" data-url="{{ route('pages.show', $item->id) }}"
                                                            data-title="{{ __('Show Pages') }}"> <i data-feather="eye"></i></a>
                                                    @endcan
                                                    @can('edit Page')
                                                        <a class="avtar avtar-xs btn-link-secondary text-secondary customModal" data-bs-toggle="tooltip"
                                                            data-size="xl" data-bs-original-title="{{ __('Edit') }}"
                                                            href="#" data-url="{{ route('pages.edit', $item->id) }}"
                                                            data-title="{{ __('Edit Pages') }}"> <i data-feather="edit"></i></a>
                                                    @endcan
                                                    @can('delete Page')
                                                        @if (!in_array($item->id, [1,2]))
                                                        <a class=" avtar avtar-xs btn-link-danger text-danger confirm_dialog" data-bs-toggle="tooltip"
                                                            data-bs-original-title="{{ __('Detete') }}" href="#"> <i
                                                                data-feather="trash-2"></i></a>
                                                        @endif
                                                    @endcan
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

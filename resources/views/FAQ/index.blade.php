@extends('layouts.app')
@section('page-title')
    {{ __('FAQ') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item" aria-current="page"> {{ __('FAQ') }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card table-card">
                <div class="card-header">
                    <div class="row align-items-center g-2">
                        <div class="col">
                            <h5>{{ __('FAQ') }}</h5>
                        </div>
                        @can('create FAQ')
                            <div class="col-auto">
                                <a href="#" class="btn btn-secondary customModal" data-size="md"
                                    data-url="{{ route('FAQ.create') }}" data-title="{{ __('Create New FAQ') }}">
                                    <i class="ti ti-circle-plus align-text-bottom"></i> {{ __('Create FAQ') }}</a>
                            </div>
                        @endcan

                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="dt-responsive table-responsive">
                        <table class="table table-hover advance-datatable">
                            <thead>
                                <tr>
                                    <th>{{ __('Question') }}</th>
                                    <th>{{ __('Enable') }}</th>
                                    @if (Gate::check('edit FAQ') || Gate::check('delete FAQ'))
                                        <th>{{ __('Action') }}</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($FAQs as $item)
                                    <tr>
                                        <td>{{ $item->question }} </td>
                                        <td>

                                            @if ($item->enabled == 1)
                                                <span class="d-inline badge text-bg-success">{{ __('Enable') }}</span>
                                            @else
                                                <span class="d-inline badge text-bg-danger">{{ __('Disable') }}</span>
                                            @endif

                                        </td>
                                        @if (Gate::check('edit FAQ') || Gate::check('delete FAQ'))
                                            <td>
                                                <div class="cart-action">
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['FAQ.destroy', $item->id]]) !!}
                                                    @can('edit FAQ')
                                                        <a class="avtar avtar-xs btn-link-secondary text-secondary customModal"
                                                            data-bs-toggle="tooltip" data-size="lg"
                                                            data-bs-original-title="{{ __('Edit') }}" href="#"
                                                            data-url="{{ route('FAQ.edit', $item->id) }}"
                                                            data-title="{{ __('Edit FAQ') }}"> <i data-feather="edit"></i></a>
                                                    @endcan
                                                    @can('delete FAQ')
                                                        <a class=" avtar avtar-xs btn-link-danger text-danger confirm_dialog"
                                                            data-bs-toggle="tooltip"
                                                            data-bs-original-title="{{ __('Detete') }}" href="#"> <i
                                                                data-feather="trash-2"></i></a>
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

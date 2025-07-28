@extends('layouts.app')
@section('page-title')
    {{ __('Coupon History') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item" aria-current="page"> {{ __('Coupon History') }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card table-card">
                <div class="card-header">
                    <div class="row align-items-center g-2">
                        <div class="col">
                            <h5>{{ __('Coupon History List') }}</h5>
                        </div>

                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="dt-responsive table-responsive">
                        <table class="table table-hover advance-datatable">
                            <thead>
                                <tr>
                                    <th>{{ __('Coupon') }}</th>
                                    <th>{{ __('Package') }}</th>
                                    <th>{{ __('User') }}</th>
                                    <th>{{ __('Date') }}</th>
                                    @if (Gate::check('delete coupon history'))
                                        <th class="text-right">{{ __('Action') }}</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($couponhistory as $history)
                                    <tr role="row">
                                        <td> {{ !empty($history->coupons) ? $history->coupons->name : '-' }} </td>
                                        <td>{{ !empty($history->pakages) ? $history->pakages->name : '-' }} </td>
                                        <td>{{ !empty($history->users) ? $history->users->name : '-' }} </td>
                                        <td>{{ dateFormat($history->date) }} </td>
                                        @if (Gate::check('delete coupon history'))
                                            <td class="text-right">
                                                <div class="cart-action">
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['coupons.history.destroy', $history->id]]) !!}

                                                    @if (Gate::check('delete coupon history'))
                                                        <a class=" avtar avtar-xs btn-link-danger text-danger confirm_dialog" data-bs-toggle="tooltip"
                                                            data-bs-original-title="{{ __('Detete') }}" href="#"> <i
                                                                data-feather="trash-2"></i></a>
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

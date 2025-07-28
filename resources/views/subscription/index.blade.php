@extends('layouts.app')
@section('page-title')
    {{ __('Packages') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item" aria-current="page"> {{ __('Packages') }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">

            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center g-2">
                        <div class="col">
                            <h5>{{ __('Pricing Packages List') }}</h5>
                        </div>
                        @if (
                            \Auth::user()->type == 'super admin' &&
                                (subscriptionPaymentSettings()['STRIPE_PAYMENT'] == 'on' ||
                                    subscriptionPaymentSettings()['paypal_payment'] == 'on' ||
                                    subscriptionPaymentSettings()['bank_transfer_payment'] == 'on'))
                            <div class="col-auto">
                                <a href="#" class="btn btn-secondary customModal" data-size="md"
                                    data-url="{{ route('subscriptions.create') }}" data-title="{{ __('Create Package') }}">
                                    <i class="ti ti-circle-plus align-text-bottom"></i> {{ __('Create Package') }}
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="table-responsive">
                    <div class="price-card2">
                        @php
                            $features = [
                                __('User Limit'),
                                __('Visitor Pre Register'),
                                __('Enabled Logged History'),
                                __('Coupon Applicable'),
                            ];
                        @endphp
                        <table class="table table-striped m-0">
                            <thead>
                                <tr>
                                    <th>{{ __('Features') }}</th>
                                    @foreach ($subscriptions as $subscription)
                                        <th>
                                            <div class="card-body border-start text-center py-5 py-md-5">
                                                <h3 class="text-primary"><b> {{ $subscription->title }}</b></h3>
                                                <h3 class="text-muted mb-0 mt-5">
                                                    <b>
                                                        <sup>{{ subscriptionPaymentSettings()['CURRENCY_SYMBOL'] }}</sup>
                                                        {{ $subscription->package_amount }}
                                                        <span>/{{ $subscription->interval }}</span>
                                                    </b>
                                                </h3>
                                            </div>
                                        </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($features as $feature)
                                    <tr>
                                        <td>{{ __($feature) }}</td>
                                        @foreach ($subscriptions as $subscription)
                                            <td class="text-center">
                                                @switch($feature)
                                                    @case(__('User Limit'))
                                                        {{ $subscription->user_limit }}
                                                    @break

                                                    @case(__('Visitor Pre Register'))
                                                        @if ($subscription->enabled_pre_register == 1)
                                                            <div class="bg-success text-white avtar avtar-xs icon">
                                                                <i class="ti ti-check f-20"></i>
                                                            </div>
                                                        @else
                                                            <div class="bg-danger text-white avtar avtar-xs icon">
                                                                <i class="ti ti-x f-20"></i>
                                                            </div>
                                                        @endif
                                                    @break

                                                    @case(__('Enabled Logged History'))
                                                        @if ($subscription->enabled_logged_history)
                                                            <div class="bg-success text-white avtar avtar-xs icon">
                                                                <i class="ti ti-check f-20"></i>
                                                            </div>
                                                        @else
                                                            <div class="bg-danger text-white avtar avtar-xs icon">
                                                                <i class="ti ti-x f-20"></i>
                                                            </div>
                                                        @endif
                                                    @break

                                                    @case(__('Coupon Applicable'))
                                                        @if ($subscription->couponCheck() > 0)
                                                            <div class="bg-success text-white avtar avtar-xs icon">
                                                                <i class="ti ti-check f-20"></i>
                                                            </div>
                                                        @else
                                                            <div class="bg-danger text-white avtar avtar-xs icon">
                                                                <i class="ti ti-x f-20"></i>
                                                            </div>
                                                        @endif
                                                    @break
                                                @endswitch
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach

                            </tbody>
                            <tfoot>
                                <tr>
                                    <td></td>
                                    @foreach ($subscriptions as $subscription)
                                        <td class="text-center">
                                            @if (\Auth::user()->type != 'super admin' && \Auth::user()->subscription == $subscription->id)
                                                <span class="badge text-bg-success">{{ __('Active') }}</span>
                                                <br>
                                                <span>{{ \Auth::user()->subscription_expire_date ? dateFormat(\Auth::user()->subscription_expire_date) : __('Unlimited') }}</span>
                                                {{ __('Expiry Date') }}
                                            @else
                                                @if (\Auth::user()->type == 'owner' && \Auth::user()->subscription != $subscription->id)
                                                    <div class="border-start py-4 py-md-5">
                                                        <a href="{{ route('subscriptions.show', \Illuminate\Support\Facades\Crypt::encrypt($subscription->id)) }}"
                                                            class="btn btn-outline-primary bg-light text-primary">
                                                            {{ __('Purchase Now') }}
                                                        </a>
                                                    </div>
                                                @endif
                                            @endif

                                            {!! Form::open(['method' => 'DELETE', 'route' => ['subscriptions.destroy', $subscription->id]]) !!}
                                            @can('edit pricing packages')
                                                <a class="text-secondary customModal" data-bs-toggle="tooltip"
                                                    data-bs-original-title="{{ __('Edit') }}" href="#"
                                                    data-url="{{ route('subscriptions.edit', $subscription->id) }}"
                                                    data-title="{{ __('Edit Package') }}"> <i data-feather="edit"></i></a>
                                            @endcan
                                            @if ($subscription->id != 1)
                                                @can('delete pricing packages')
                                                    <a class=" text-danger confirm_dialog" data-bs-toggle="tooltip"
                                                        data-bs-original-title="{{ __('Detete') }}" href="#"> <i
                                                            data-feather="trash-2"></i></a>
                                                @endcan
                                            @endif
                                            {!! Form::close() !!}
                                        </td>
                                    @endforeach
                                </tr>
                            </tfoot>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

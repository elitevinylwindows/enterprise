@extends('layouts.app')
@section('page-title')
    {{ __('Transaction') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item" aria-current="page"> {{ __('Transaction') }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card table-card">
                <div class="card-header">
                    <div class="row align-items-center g-2">
                        <div class="col">
                            <h5>{{ __('Pricing Package Transaction List') }}</h5>
                        </div>

                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="dt-responsive table-responsive">
                        <table class="table table-hover advance-datatable">
                            <thead>
                                <tr>
                                    <th>{{__('User')}}</th>
                                    <th>{{__('Date')}}</th>
                                    <th>{{__('Subscription')}}</th>
                                    <th>{{__('Amount')}}</th>
                                    <th>{{__('Payment Type')}}</th>
                                    <th>{{__('Payment Status')}}</th>
                                    <th>{{__('Receipt')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transactions as $transaction)
                            <tr>
                                <td>{{!empty($transaction->users)?$transaction->users->name:''}}</td>
                                <td>{{dateFormat($transaction->created_at)}}</td>
                                <td>{{!empty($transaction->subscriptions)?$transaction->subscriptions->title:'-'}}</td>
                                <td>{{$settings['CURRENCY_SYMBOL'].$transaction->amount}}</td>
                                <td>{{$transaction->payment_type}}</td>
                                <td>
                                    @if($transaction->payment_status=='Pending')
                                        <span
                                            class="d-inline badge text-bg-warning">{{$transaction->payment_status}}</span>
                                    @elseif($transaction->payment_status=='succeeded' || $transaction->payment_status=='Success')
                                        <span
                                            class="d-inline badge text-bg-success">{{$transaction->payment_status}}</span>
                                    @else
                                        <span
                                            class="d-inline badge text-bg-danger">{{$transaction->payment_status}}</span>
                                    @endif


                                </td>
                                <td>
                                    @if($transaction->payment_type=='Stripe')
                                        <a class="avtar avtar-xs btn-link-primary text-primary" data-bs-toggle="tooltip" target="_blank"
                                           data-bs-original-title="{{__('Receipt')}}" href="{{$transaction->receipt}}">
                                            <i data-feather="file"></i></a>
                                    @elseif($transaction->payment_type=='Bank Transfer')
                                        {!! Form::open(['method' => 'DELETE', 'route' => ['subscription.bank.transfer.action', [$transaction->id,'accept']]]) !!}

                                        <a class="avtar avtar-xs btn-link-primary text-primary" data-bs-toggle="tooltip" target="_blank"
                                           data-bs-original-title="{{__('Receipt')}}"
                                           href="{{asset('/storage/upload/payment_receipt/'.$transaction->receipt)}}">
                                            <i data-feather="file"></i></a>

                                        @if(\Auth::user()->type=='super admin' && $transaction->payment_status=='Pending')
                                            <a class="avtar avtar-xs btn-link-success text-success" data-bs-toggle="tooltip"
                                               data-bs-original-title="{{__('Accept')}}"
                                               href="{{route('subscription.bank.transfer.action', [$transaction->id,'accept'])}}">
                                                <i data-feather="user-check"></i></a>

                                            <a class="avtar avtar-xs btn-link-danger text-danger" data-bs-toggle="tooltip"
                                               data-bs-original-title="{{__('Reject')}}"
                                               href="{{route('subscription.bank.transfer.action', [$transaction->id,'reject'])}}">
                                                <i data-feather="user-x"></i></a>
                                        @endif
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

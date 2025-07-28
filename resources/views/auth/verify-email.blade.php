@extends('layouts.auth')
@section('tab-title')
    {{ __('Verify') }}
@endsection
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="d-flex justify-content-center">
                    <div class="auth-header">
                        <h2 class="text-secondary"><b>{{ __('Verify your email address') }} </b></h2>
                        @if (session('resent'))
                            <div class="alert alert-secondary" role="alert">
                                {{ __('A fresh verification link has been sent to your email address.') }}
                            </div>
                        @endif
                        @if (session('error'))
            <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
            @endif
            @if (session('success'))
            <div class="alert alert-success" role="alert">{{ session('success') }}</div>
            @endif
            @if (session('status'))
            <div class="alert alert-success" role="alert">{{ session('status') }}</div>
            @endif
                        <p>{{ __('Before proceeding, please check your email for a verification link.') }}</p>
                    </div>
                    <hr />
                    <h5 class="d-flex justify-content-center">{{ __('If you did not receive the email') }} <a
                            class="ms-1 text-secondary"
                            href="{{ route('verification.resend') }}">{{ __('click here to request another') }}</a>
                    </h5>
                </div>
            </div>
        </div>
    </div>
@endsection

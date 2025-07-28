@extends('layouts.auth')
@php
    $settings = settings();
@endphp
@section('tab-title')
    {{ __('Login') }}
@endsection
@push('script-page')
@endpush
@section('content')
<style>
    /* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
input[type=number] {
  -moz-appearance: textfield;
}
</style>

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="d-flex justify-content-center">
                        <div class="auth-header">
                            <h2 class="text-secondary"><b>{{ __('Welcome to ') }}{{ env('APP_NAME') }}!</b></h2>
                            <h4 class="mx-2"><b>{{ __('Enter your 2FA Verification Code (OTP)') }}</b></h4>
                        </div>
                    </div>
                </div>
                {{ Form::open(['route' => 'otp.check', 'method' => 'post', 'id' => 'loginForm', 'class' => 'login-form']) }}
                @if (session('error'))
            <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
            @endif
            @if (session('success'))
            <div class="alert alert-success" role="alert">{{ session('success') }}</div>
            @endif
            @if (session('status'))
            <div class="alert alert-success" role="alert">{{ session('status') }}</div>
            @endif
                <div class="row text-center">
                    <input type="number" class="form-control w-100 mx-2 mt-3 text-center" name="otp" min="0" max="999999" />
                </div>
                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-secondary p-2">{{ __('Continue') }}</button>
                </div>
                {{ Form::close() }}

            </div>
        </div>

@endsection
@section('content1')
    {{-- <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="d-flex justify-content-center">
                    <div class="auth-header">
                        <h2 class="text-secondary"><b>{{ __('Hi, Welcome Back') }} </b></h2>
                        <p class="f-16 mt-2">{{ __('Enter your credentials to continue') }}</p>
                    </div>
                </div>
            </div>

            {{ Form::open(['route' => 'login', 'method' => 'post', 'id' => 'loginForm', 'class' => 'login-form']) }}
            @if (session('error'))
                <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
            @endif
            @if (session('success'))
                <div class="alert alert-success" role="alert">{{ session('success') }}</div>
            @endif
            <div class="form-floating mb-3">
                <input type="email" class="form-control" id="email" name="email"
                    placeholder="{{ __('Email address') }}" />
                <label for="email">{{ __('Email address') }}</label>
                @error('email')
                    <span class="invalid-email text-danger" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-floating mb-3">
                <input type="password" class="form-control" id="password" name="password"
                    placeholder="{{ __('Password') }}" />
                <label for="password">{{ __('Password') }}</label>
                @error('password')
                    <span class="invalid-password text-danger" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="d-flex mt-1 justify-content-between">
                <div class="form-check">
                    <input class="form-check-input input-primary" type="checkbox" id="agree"
                        {{ old('remember') ? 'checked' : '' }} />
                    <label class="form-check-label text-muted" for="agree">{{ __('Remember me') }}</label>
                </div>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-secondary">{{ __('Forgot Password?') }}</a>
                @endif
            </div>
            @if ($settings['google_recaptcha'] == 'on')
                <div class="form-group">
                    <label for="email" class="form-label"></label>
                    {!! NoCaptcha::display() !!}
                    @error('g-recaptcha-response')
                        <span class="small text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                @if ($errors->has('g-recaptcha-response'))
                    <span class="help-block">
                        <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                    </span>
                @endif
            @endif
            <div class="d-grid mt-4">
                <button type="submit" class="btn btn-secondary p-2">{{ __('Sign In') }}</button>
            </div>
            @if ($registerPage == 'on')
                <hr />
                <h5 class="d-flex justify-content-center">{{ __("Don't Have An Account?") }} <a
                        class="ms-1 text-secondary" href="{{ route('register') }}">{{ __('Create an account') }}</a>
                </h5>
            @endif
            {{ Form::close() }}
        </div>
    </div> --}}
@endsection

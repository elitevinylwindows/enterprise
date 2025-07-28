@extends('layouts.auth')
@php
    $settings = settings();
@endphp
@section('tab-title')
    {{ __('Register') }}
@endsection
@push('script-page')
    @if ($settings['google_recaptcha'] == 'on')
        {!! NoCaptcha::renderJs() !!}
    @endif
@endpush
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="d-flex justify-content-center">
                    <div class="auth-header">
                        <h2 class="text-secondary"><b>{{ __('Sign up') }} </b></h2>
                        <p class="f-16 mt-2">{{ __('Enter your details and create account') }}</p>
                    </div>
                </div>
            </div>

            {{ Form::open(['route' => 'register', 'method' => 'post', 'id' => 'register-Form']) }}
            @if (session('error'))
            <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
            @endif
            @if (session('success'))
            <div class="alert alert-success" role="alert">{{ session('success') }}</div>
            @endif
            @if (session('status'))
            <div class="alert alert-success" role="alert">{{ session('status') }}</div>
            @endif
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="name" name="name" placeholder="{{ __('Name') }}" />
                <label for="name">{{ __('Name') }}</label>
                @error('name')
                    <span class="invalid-name text-danger" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
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
            <div class="form-floating mb-3">
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                    placeholder="{{ __('Password Confirmation') }}" />
                <label for="password_confirmation">{{ __('Password Confirmation') }}</label>
                @error('password_confirmation')
                    <span class="invalid-password_confirmation text-danger" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-check mt-3">
                <input class="form-check-input input-primary" type="checkbox" id="agree" name="agree" />
                <label class="form-check-label" for="agree">
                    <span class="h5 mb-0">
                        {{ __('Agree with') }}
                        <span><a href="{{ !empty($menu->slug) ? route('page', $menu->slug) : '#' }}">{{ __('Terms and conditions') }}</a>.</span>
                    </span>
                </label>
            </div>
            @if ($settings['google_recaptcha'] == 'on')
                <div class="form-group">
                    <label for="email" class="form-label"></label>
                    {!! NoCaptcha::display() !!}
                    
                </div>
                @if ($errors->has('g-recaptcha-response'))
                    <span class="help-block">
                        <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                    </span>
                @endif
            @endif
            <div class="d-grid mt-4">
                <button type="submit" class="btn btn-secondary p-2">{{ __('Sign Up') }}</button>
            </div>
            <hr />
            <h5 class="d-flex justify-content-center">{{__('Already have an account?')}} <a class="ms-1 text-secondary"
                    href="{{ route('login') }}">{{ __('Login in here') }}</a>
            </h5>
            {{ Form::close() }}
        </div>
    </div>
@endsection

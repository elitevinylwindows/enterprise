@extends('layouts.app')

@section('page-title')
    {{ __('Settings') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Settings') }}</li>
@endsection

@section('content')
<div class="mb-4"></div> {{-- Space after title --}}

<div class="row">
    {{-- Sidebar Card --}}
    <div class="col-md-4">
        <div class="card">
            <div class="list-group list-group-flush">
                <a href="{{ route('sales.settings.index', ['selected' => 'quickbooks']) }}" class="list-group-item {{ request('selected') == 'quickbooks' ? 'active' : '' }}">Quickbooks</a>
                <a href="{{ route('sales.settings.index', ['selected' => 'sales_admin']) }}" class="list-group-item {{ request('selected') == 'sales_admin' ? 'active' : '' }}">Sales Admin</a>
                <a href="{{ route('sales.settings.index', ['selected' => 'api']) }}" class="list-group-item {{ request('selected') == 'api' ? 'active' : '' }} text-danger">API</a>
            </div>
        </div>
    </div>

    {{-- Main Content Card --}}
    <div class="col-sm-8">
        <div class="card">
            <div class="card-header">
                <h5>{{ ucfirst(str_replace('_', ' ', request('selected', 'Settings'))) }} Settings</h5>
            </div>
            <div class="card-body">
                {!! Form::open(['route' => 'sales.settings.save', 'method' => 'post']) !!}
                {!! Form::hidden('section', request('selected')) !!}

                @if (request('selected') === 'quickbooks')
                    <div class="form-group mb-3">
                        {!! Form::label('quickbooks_api_key', 'API Key', ['class' => 'form-label']) !!}
                        {!! Form::text('quickbooks_api_key', sales_setting('quickbooks_api_key'), ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group mb-3">
                        {!! Form::label('quickbooks_company_id', 'Company ID', ['class' => 'form-label']) !!}
                        {!! Form::text('quickbooks_company_id', sales_setting('quickbooks_company_id'), ['class' => 'form-control']) !!}
                    </div>

                @elseif (request('selected') === 'sales_admin')
                    <div class="form-group mb-3">
                        {!! Form::label('default_sales_region', 'Default Sales Region', ['class' => 'form-label']) !!}
                        {!! Form::text('default_sales_region', sales_setting('default_sales_region'), ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group mb-3">
                        {!! Form::label('sales_notification_email', 'Notification Email', ['class' => 'form-label']) !!}
                        {!! Form::email('sales_notification_email', sales_setting('sales_notification_email'), ['class' => 'form-control']) !!}
                    </div>

                @elseif (request('selected') === 'api')
                    <div class="form-group mb-3">
                        {!! Form::label('api_access_token', 'Access Token', ['class' => 'form-label']) !!}
                        {!! Form::text('api_access_token', sales_setting('api_access_token'), ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group mb-3">
                        {!! Form::label('api_base_url', 'Base URL', ['class' => 'form-label']) !!}
                        {!! Form::url('api_base_url', sales_setting('api_base_url'), ['class' => 'form-control']) !!}
                    </div>
                @else
                    <p>Please select a section from the left.</p>
                @endif

                @if (request('selected'))
                <div class="mt-3 text-end">
                    {!! Form::submit(__('Save Settings'), ['class' => 'btn btn-primary']) !!}
                </div>
                @endif

                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('page-title')
    {{ __('Import CIMs') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('cims.index') }}">{{ __('CIMs') }}</a></li>
    <li class="breadcrumb-item active">{{ __('Import') }}</li>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {!! Form::open(['route' => 'cims.handleImport', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
            <div class="form-group mb-3">
                {!! Form::label('import_file', 'Upload Excel File') !!}
                {!! Form::file('import_file', ['class' => 'form-control', 'required']) !!}
                <small class="form-text text-muted">Accepted formats: .xlsx, .xls</small>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="ti ti-upload"></i> {{ __('Import') }}
            </button>
        {!! Form::close() !!}
    </div>
</div>
@endsection

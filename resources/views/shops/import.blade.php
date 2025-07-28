@extends('layouts.app')

@section('page-title')
    {{ __('Import Shops') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('shops.index') }}">{{ __('Shops') }}</a></li>
    <li class="breadcrumb-item active">{{ __('Import') }}</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-6 offset-md-3">
        <div class="card">
            <div class="card-header"><h5>{{ __('Import Shops from Excel') }}</h5></div>
            <div class="card-body">
                <form method="POST" action="{{ route('shops.import') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="file">{{ __('Choose Excel File') }}</label>
                        <input type="file" name="file" class="form-control" required accept=".xlsx,.xls,.csv">
                    </div>
                    <div class="form-group mt-3">
                        <button type="submit" class="btn btn-primary">{{ __('Import') }}</button>
                        <a href="{{ route('shops.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                    </div>
                </form>
                <hr>
                <p class="text-muted">
                    {{ __('Excel columns must include: customer, address, city, zip.') }}
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

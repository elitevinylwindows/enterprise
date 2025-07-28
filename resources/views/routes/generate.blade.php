@extends('layouts.app')

@section('page-title')
    {{ __('Auto Route Generator') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Auto Route') }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">{{ __('Generate Auto Routes') }}</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('routes.optimize') }}">
                        @csrf
                        <div class="form-group">
                            <label for="delivery_date">{{ __('Delivery Date') }}</label>
                            <input type="date" id="delivery_date" name="delivery_date" class="form-control" required>
                        </div>
                        <div class="form-group mt-3">
                            <label for="max_stops">{{ __('Max Stops Per Truck') }}</label>
                            <input type="number" id="max_stops" name="max_stops" class="form-control" value="10" min="1" required>
                        </div>
                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary">{{ __('Generate Routes') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

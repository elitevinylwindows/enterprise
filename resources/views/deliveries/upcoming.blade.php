@extends('deliveries.index')

@section('page-title', __('Upcoming Deliveries'))

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Upcoming Deliveries') }}</li>
@endsection

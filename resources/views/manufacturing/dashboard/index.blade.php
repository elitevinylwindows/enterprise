@extends('layouts.app')

@section('page-title', __('Manufacturing Dashboard'))

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
<li class="breadcrumb-item active" aria-current="page">{{ __('Manufacturing') }}</li>
@endsection

@section('content')
<div class="container-fluid">
  <div class="mb-3"></div>

  <div class="card">
    <div class="card-body">
      <h5 class="mb-2">{{ __('Manufacturing Dashboard') }}</h5>
      <p class="text-muted mb-0">
        {{ __('This is the general dashboard for users without a station assigned.') }}
      </p>
      <div class="mt-3">
        <a href="{{ route('manufacturing.stations.index') }}" class="btn btn-outline-primary">
          {{ __('Go to Stations') }}
        </a>
      </div>
    </div>
  </div>
</div>
@endsection

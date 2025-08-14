{{-- resources/views/manufacturing/dashboard/station_host.blade.php --}}
@extends('layouts.app')

@section('page-title', __('Terminal Dashboard'))

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
<li class="breadcrumb-item active" aria-current="page">{{ $station->station }}</li>
@endsection

@section('content')
<div class="container-fluid">
  <div class="mb-3"></div>
  {{-- Include the layout chosen by ui_key --}}
  @include($partial, ['station' => $station])
</div>
@endsection

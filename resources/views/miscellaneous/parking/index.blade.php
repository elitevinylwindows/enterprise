@extends('layouts.app')

@section('page-title', __('Parking'))

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
  <li class="breadcrumb-item">{{ __('Miscellaneous') }}</li>
  <li class="breadcrumb-item active" aria-current="page">{{ __('Parking') }}</li>
@endsection

@section('content')
<div class="mb-4"></div>
<div class="mb-4"></div>

<div class="card">
  <div class="card-header">
    <div class="row align-items-center g-2">
      <div class="col"><h5>{{ __('Parking Assignments') }}</h5></div>
      <div class="col-auto">
        <a href="#"
           class="btn btn-primary customModal"
           data-size="lg"
           data-url="{{ route('misc.parking.create') }}"
           data-title="{{ __('Assign Parking') }}">
          <i class="fa-solid fa-circle-plus"></i> {{ __('Create') }}
        </a>
      </div>
    </div>

    <div class="row mt-2">
      <div class="col-md-6">
        <form method="GET" action="{{ route('misc.parking.index') }}">
          <div class="input-group">
            <input type="text" name="q" class="form-control" placeholder="{{ __('Search name/email/spot…') }}"
                   value="{{ $q ?? '' }}">
            <button class="btn btn-primary" type="submit">{{ __('Search') }}</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="card-body">
    <div class="row g-3">
      @forelse($assignments as $a)
        @php
          $name = $a->user->name ?? '—';
          $email = $a->user->email ?? '';
          $parts = preg_split('/\s+/', trim($name));
          $initials = '';
          foreach ($parts as $p) { $initials .= mb_substr($p,0,1); }
        @endphp
        <div class="col-12 col-sm-6 col-lg-4 col-xxl-3">
          <div class="card h-100 shadow-sm rounded-3">
            <div class="card-body d-flex flex-column">
              <div class="d-flex align-items-start justify-content-between">
                <div class="d-flex align-items-center gap-3">
                  <div class="avatar-circle">{{ strtoupper($initials) }}</div>
                  <div>
                    <div class="fw-semibold">{{ $name }}</div>
                    <div class="text-muted small">{{ $email }}</div>
                  </div>
                </div>

                <a href="#"
                   class="btn btn-sm btn-light border customModal"
                   data-size="lg"
                   data-url="{{ route('misc.parking.edit', $a->id) }}"
                   data-title="{{ __('Edit Parking') }}"
                   title="{{ __('Edit') }}">
                  <i data-feather="edit"></i>
                </a>
              </div>

              <div class="mt-3">
                <span class="badge bg-dark">{{ __('Spot') }}: {{ $a->spot }}</span>
              </div>
              @if(!empty($a->notes))
                <div class="text-muted small mt-2">{{ $a->notes }}</div>
              @endif
            </div>
          </div>
        </div>
      @empty
        <div class="col-12">
          <div class="alert alert-secondary mb-0">{{ __('No parking assignments yet.') }}</div>
        </div>
      @endforelse
    </div>
  </div>
</div>

<style>
.avatar-circle{
  width:42px;height:42px;border-radius:999px;
  background:#f1f3f5;display:inline-flex;align-items:center;justify-content:center;
  font-weight:700;color:#495057;border:1px solid rgba(0,0,0,.06);
}
</style>
@endsection

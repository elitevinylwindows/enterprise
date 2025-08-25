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
        {{-- You still have a Create modal; you can keep/remove it. Index will ensure rows 1–50 exist --}}
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
          $hasUser = !empty($a->user);
          $name  = $hasUser ? $a->user->name : __('Unassigned');
          $email = $hasUser ? ($a->user->email ?? '') : '';
          // Avatar text: initials if assigned, else show spot number
          $avatarText = $hasUser
              ? collect(preg_split('/\s+/', trim($name)))->map(fn($p) => mb_substr($p,0,1))->implode('')
              : (string) $a->spot;
        @endphp

        <div class="col-12 col-sm-6 col-lg-4 col-xxl-3">
          <div class="card h-100 shadow-sm rounded-3 position-relative">
            {{-- Wheelchair badge top-left --}}
            @if($a->is_wheelchair)
              <div class="position-absolute top-0 start-0 m-2">
                <span class="badge bg-primary d-inline-flex align-items-center gap-1">
                  <i class="fa-solid fa-wheelchair"></i>
                </span>
              </div>
            @endif

            <div class="card-body d-flex flex-column">
              <div class="d-flex align-items-start justify-content-between">
                <div class="d-flex align-items-center gap-3">
                  <div class="avatar-circle">{{ strtoupper($avatarText) }}</div>
                  <div>
                    <div class="fw-semibold">{{ $name }}</div>
                    @if($email)<div class="text-muted small">{{ $email }}</div>@endif
                  </div>
                </div>

                <a href="#"
                   class="avtar avtar-xs btn-link-primary text-primary customModal"
                   data-bs-toggle="tooltip"
                   data-bs-original-title="{{ __('Edit') }}"
                   data-size="xl"
                   data-url="{{ route('misc.parking.edit', $a->id) }}"
                   data-title="{{ __('Edit Parking') }}">
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
.badge .fa-wheelchair { font-size: 14px; }
</style>
@endsection

@extends('layouts.app')

@section('page-title', __('Parking'))

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
  <li class="breadcrumb-item">{{ __('Miscellaneous') }}</li>
  <li class="breadcrumb-item active" aria-current="page">{{ __('Parking') }}</li>
@endsection

@section('content')
<div class="mb-3"></div>

<div class="card border-0 shadow-sm">
  <div class="card-header bg-white">
    <div class="row align-items-center g-2">
      <div class="col"><h5 class="mb-0">{{ __('Parking Assignments') }}</h5></div>
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

    <div class="row mt-3">
      <div class="col-md-6">
        <form method="GET" action="{{ route('misc.parking.index') }}">
          <div class="input-group">
            <input type="text" name="q" class="form-control" placeholder="{{ __('Search name/email/spot…') }}" value="{{ $q ?? '' }}">
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
          $u         = $a->user;
          $name      = $u->name ?? __('Unassigned');
          $email     = $u->email ?? '—';
          $phone     = $u->phone_number ?? '—';
          $department = $u && method_exists($u,'getRoleNames') ? ($u->getRoleNames()->first() ?? '—') : '—';
        @endphp

        <div class="col-12 col-sm-6 col-lg-3 col-xl-2">
          <div class="parking-card card border-0 shadow-sm h-100 position-relative text-center">

            {{-- wheelchair icon top-left (forced blue) --}}
            @if($a->wheelchair)
              <div class="position-absolute top-0 start-0 m-2">
                <i class="fa-solid fa-wheelchair" style="color:#0d6efd; font-size:18px;"></i>
              </div>
            @endif

            {{-- edit icon top-right --}}
            <div class="position-absolute top-0 end-0 m-2">
              <a href="#"
                 class="text-muted customModal"
                 data-size="xl"
                 data-url="{{ route('misc.parking.edit', $a->id) }}"
                 data-title="{{ __('Edit Parking') }}">
                <i class="fa-regular fa-pen-to-square" style="font-size:16px;"></i>
              </a>
            </div>

            <div class="card-body d-flex flex-column align-items-center p-3">

              {{-- AVATAR (your requested snippet goes RIGHT HERE) --}}
              @php
                use Illuminate\Support\Facades\Storage;

                $profileUrl = null;
                if ($u && $u->profile) {
                    $p = $u->profile;
                    $profileUrl = filter_var($p, FILTER_VALIDATE_URL)
                        ? $p
                        : Storage::url(ltrim($p, '/')); // requires `php artisan storage:link`
                }
              @endphp

              @if($profileUrl)
                <img src="{{ $profileUrl }}" alt="avatar"
                     class="parking-avatar-img mb-2"
                     onerror="this.onerror=null;this.replaceWith(Object.assign(document.createElement('div'),{className:'parking-avatar-fallback mb-2'}));">
              @else
                <div class="parking-avatar-fallback mb-2"></div>
              @endif
              {{-- END AVATAR --}}

              <div class="parking-label">{{ __('Name') }}</div>
              <div class="parking-value mb-1">{{ $name }}</div>

              <div class="parking-label">{{ __('Department') }}</div>
              <div class="parking-value mb-1">{{ $department }}</div>

              <div class="parking-label">{{ __('Phone') }}</div>
              <div class="parking-value mb-1">{{ $phone }}</div>

              <div class="parking-label">{{ __('Spot #') }}</div>
              <div class="parking-value mb-2">{{ $a->spot }}</div>

              {{-- Quick Look -> SHOW modal --}}
              <a href="#"
                 class="btn btn-danger btn-sm w-100 customModal"
                 data-size="lg"
                 data-url="{{ route('misc.parking.show', $a->id) }}"
                 data-title="{{ __('Parking Details') }}">
                {{ __('Quick Look') }}
              </a>
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
.parking-card{ border-radius:14px; font-size:.85rem; }
.parking-avatar-img{ width:70px; height:70px; border-radius:50%; object-fit:cover; border:2px solid #9b0000; }
.parking-avatar-fallback{ width:70px; height:70px; border-radius:50%; background:#9b0000; }
.parking-label{ font-weight:700; font-size:.8rem; color:#222; }
.parking-value{ font-size:.8rem; color:#444; }
</style>
@endsection

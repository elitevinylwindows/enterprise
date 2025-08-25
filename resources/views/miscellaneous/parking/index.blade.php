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
            <input type="text" name="q" class="form-control" placeholder="{{ __('Search name/email/spot…') }}"
                   value="{{ $q ?? '' }}">
            <button class="btn btn-primary" type="submit">{{ __('Search') }}</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="card-body">
    <div class="row g-4">
      @forelse($assignments as $a)
        @php
          $u = $a->user;
          $name  = $u->name ?? __('Unassigned');
          $email = $u->email ?? '—';
          // Optional: adjust these if your users table has different columns
          $department = $u->department ?? '—';
          $phone      = $u->phone ?? '—';

          // For avatar: show big red circle; text is optional (spot or initials)
          $avatarText = ''; // leave empty for solid red circle (like mock)
        @endphp

        <div class="col-12 col-sm-6 col-lg-4 col-xxl-3">
          <div class="parking-card card border-0 shadow-sm h-100 position-relative">

            {{-- wheelchair icon top-left (blue) --}}
            @if($a->wheelchair)
              <div class="position-absolute top-0 start-0 m-3">
                <i class="fa-solid fa-wheelchair text-primary" style="font-size:22px;"></i>
              </div>
            @endif

            {{-- edit icon top-right --}}
            <div class="position-absolute top-0 end-0 m-3">
              <a href="#"
                 class="text-muted customModal"
                 data-size="xl"
                 data-url="{{ route('misc.parking.edit', $a->id) }}"
                 data-title="{{ __('Edit Parking') }}">
                <i class="fa-regular fa-pen-to-square" style="font-size:20px;"></i>
              </a>
            </div>

            <div class="card-body d-flex flex-column align-items-center text-center">
              {{-- big red avatar --}}
              <div class="parking-avatar mb-3">{{ $avatarText }}</div>

              {{-- stacked labels + values --}}
              <div class="w-100">
                <div class="parking-label">{{ __('Name') }}</div>
                <div class="parking-value mb-2">{{ $name }}</div>

                <div class="parking-label">{{ __('Department') }}</div>
                <div class="parking-value mb-2">{{ $department }}</div>

                <div class="parking-label">{{ __('Phone') }}</div>
                <div class="parking-value mb-2">{{ $phone }}</div>

                <div class="parking-label">{{ __('Spot #') }}</div>
                <div class="parking-value mb-3">{{ $a->spot }}</div>
              </div>

              {{-- Quick Look button (opens the same edit modal, or wire to a show modal if you prefer) --}}
              <a href="#"
                 class="btn btn-danger w-75 mt-2 customModal"
                 data-size="md"
                 data-url="{{ route('misc.parking.edit', $a->id) }}"
                 data-title="{{ __('Quick Look') }}">
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

{{-- styles to match the mock --}}
<style>
.parking-card{
  border-radius: 18px;
}
.parking-avatar{
  width: 140px;
  height: 140px;
  border-radius: 50%;
  background: #9b0000; /* deep red */
  color: #fff;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 700;
  font-size: 28px;
}
.parking-label{
  font-weight: 700;
  color: #2b2b2b;
}
.parking-value{
  color: #444;
}
</style>
@endsection

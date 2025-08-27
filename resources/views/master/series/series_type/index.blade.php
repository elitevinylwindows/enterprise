{{-- resources/views/master/series/series_type/index.blade.php --}}
@extends('layouts.app')

@section('page-title', __('Series Types'))

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
  <li class="breadcrumb-item">{{ __('Master') }}</li>
  <li class="breadcrumb-item active" aria-current="page">{{ __('Series Types') }}</li>
@endsection

@section('content')

<div class="mb-4"></div>
<div class="mb-4"></div>

@php
  $active = (string)($activeSeriesId ?? '');
@endphp

<div class="row">
  {{-- Taskbar Card (filters by Series) --}}
  <div class="col-md-2">
    <div class="card">
      <div class="list-group list-group-flush">
        <a href="{{ route('master.series-type.index') }}"
           class="list-group-item {{ $active === '' ? 'active' : '' }}">
          {{ __('All Series') }}
        </a>

        @foreach($seriesList as $s)
          <a href="{{ route('master.series-type.index', ['series_id' => $s->id]) }}"
             class="list-group-item {{ $active === (string)$s->id ? 'active' : '' }}">
            {{ $s->series }}
          </a>
        @endforeach
      </div>
    </div>
  </div>

  <div class="col-sm-10">
    <div class="card table-card">
      <div class="card-header">
        <div class="row align-items-center g-2">
          <div class="col"><h5>{{ __('Series Types') }}</h5></div>
          <div class="col-auto">
            <a href="#"
               class="btn btn-primary customModal"
               data-size="lg"
               data-title="{{ __('Add Series Type') }}"
               data-url="{{ route('master.series-type.create', ['series_id' => $activeSeriesId]) }}">
              <i class="fa-solid fa-circle-plus"></i> {{ __('Create') }}
            </a>
          </div>
        </div>
      </div>

      <div class="card-body pt-0">
        <div class="dt-responsive table-responsive">
          <table class="table table-hover align-middle">
            <thead>
              <tr>
                <th>{{ __('ID') }}</th>
                <th>{{ __('Series') }}</th>
                <th>{{ __('Series Types') }}</th>
                <th class="text-end" style="white-space: nowrap; width: 160px;">{{ __('Actions') }}</th>
              </tr>
            </thead>
            <tbody>
              @forelse($series as $s)
                <tr>
                  <td>{{ $s->id }}</td>
                  <td class="fw-semibold">{{ $s->series }}</td>
                  <td>
                    <div class="badge-wrap">
                      @forelse($s->seriesTypes as $st)
                        <span class="badge bg-secondary me-1 mb-1">{{ $st->series_type }}</span>
                      @empty
                        <span class="text-muted">-</span>
                      @endforelse
                    </div>
                  </td>
                  <td class="text-end">
                    <a href="#"
                       class="btn btn-sm btn-info customModal me-1"
                       data-size="lg"
                       data-title="{{ __('Edit Series Types for') }} {{ $s->series }}"
                       data-url="{{ route('master.series-type.manage', $s->id) }}">
                      <i data-feather="edit"></i>
                    </a>

                    <form action="{{ route('master.series-type.destroy-by-series', $s->id) }}"
                          method="POST" class="d-inline">
                      @csrf @method('DELETE')
                      <button type="submit" class="btn btn-sm btn-danger"
                              onclick="return confirm('{{ __('Remove ALL types for this series?') }}')">
                        <i data-feather="trash-2"></i>
                      </button>
                    </form>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="4" class="text-center text-muted">{{ __('No series found.') }}</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>

    </div>
  </div>
</div>

<style>
/* allow badges to wrap into multiple lines naturally */
.badge-wrap {
  display: flex;
  flex-wrap: wrap;   /* ✅ wrap to multiple rows */
  gap: .25rem;
  max-width: 100%;
}
</style>

@endsection

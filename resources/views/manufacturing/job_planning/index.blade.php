@extends('layouts.app')

@section('page-title', __('Job Planning'))

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
<li class="breadcrumb-item active" aria-current="page">{{ __('Job Planning') }}</li>
@endsection

@section('content')
<div class="container-fluid">

  <div class="mb-4"></div>

  {{-- Filters --}}
  <div class="row g-3 mb-4">
    <div class="col-md-8">
      <div class="card p-3">
        <div class="d-flex align-items-center justify-content-between">
          <div class="fw-semibold">{{ __('Filter by:') }}</div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" value="queued" id="filterQueued"
                   @checked(request('status') === 'queued')
                   onclick="window.location='{{ route('manufacturing.job_planning.index', ['status'=>'queued']) }}'">
            <label class="form-check-label" for="filterQueued">{{ __('Queued') }}</label>
          </div>
        </div>
        <input
          type="text"
          class="form-control mt-3"
          placeholder="{{ __('Search by Job # / Customer / Series') }}"
          value="{{ request('q') }}"
          onkeydown="if(event.key==='Enter'){window.location='{{ route('manufacturing.job_planning.index') }}?q='+encodeURIComponent(this.value)}"
        >
      </div>
    </div>

    <div class="col-md-4">
      <div class="card p-3">
        <div class="fw-semibold mb-2">&nbsp;</div>
        <div class="d-flex gap-2">
          <a href="{{ route('manufacturing.job_planning.index') }}" class="btn btn-outline-secondary w-50">
            {{ __('Clear') }}
          </a>
          <a href="#" class="btn btn-primary customModal w-50"
             data-size="xl"
             data-title="{{ __('Create / Send to Production') }}"
             data-url="{{ route('manufacturing.job_planning.create') }}">
            <i class="fa-solid fa-circle-plus"></i> {{ __('Create') }}
          </a>
        </div>
      </div>
    </div>
  </div>

  {{-- Queue Title --}}
  <h5 class="mb-3">{{ __('Job Queue 01') }}</h5>


   {{-- {{ Sample Card }} --}}
<div class="col-12 col-sm-6 col-lg-4 col-xxl-3">
  <div class="card h-100 shadow-sm rounded-3 overflow-hidden">
    <div class="p-3 text-white" style="background: var(--brand-red, #a70f0f);">
      <div class="d-flex justify-content-between align-items-start">
        <div class="fw-bold" style="font-size:1.1rem;">
          {{ __('Job Order #') }} JP-0001
        </div>
        <span class="badge rounded-pill bg-light text-dark">{{ __('Job Created') }}</span>
      </div>
      <div class="mt-2 small opacity-75">
        <div>{{ __('Delivery Date:') }} 2025-08-20</div>
        <div>{{ __('Customer #:') }} CUST-42</div>
        <div>{{ __('Customer Name:') }} Wayne Enterprises</div>
      </div>
    </div>

    <div class="p-3">
      <div class="small text-muted">
        <div class="mb-1">{{ __('Line:') }} <span class="text-body">Line A</span></div>
        <div class="mb-1">{{ __('Series:') }} <span class="text-body">LAM-WH</span></div>
        <div class="mb-3">{{ __('Qty:') }} <span class="text-body">36</span></div>
      </div>

      {{-- Opens the "Open Job" modal; replace 123 with a real job ID when ready --}}
      <a href="#"
         class="btn w-100 text-white customModal"
         style="background: var(--brand-red, #a70f0f); border-radius: 18px;"
         data-size="xl"
         data-title="{{ __('Job #') }} JP-0001"
         data-url="{{ route('manufacturing.job_planning.show', 123) }}">
         {{ __('Open Job') }}
      </a>
    </div>
  </div>
</div>
{{-- {{ /Sample Card }} --}}

    


  {{-- Cards --}}
  <div class="row g-3">
    @forelse($jobs as $job)
      @php
        $status = strtolower($job->production_status ?? '');
        $pill = $status === 'completed' ? 'success' : (in_array($status, ['queued','pending']) ? 'warning' : 'info');
      @endphp
      <div class="col-12 col-sm-6 col-lg-4 col-xxl-3">
        <div class="card h-100 shadow-sm rounded-3 overflow-hidden">

          {{-- Red header --}}
          <div class="p-3 text-white" style="background: var(--brand-red, #a70f0f);">
            <div class="d-flex justify-content-between align-items-start">
              <div class="fw-bold" style="font-size:1.1rem;">
                {{ __('Job Order #') }} {{ $job->job_order_number }}
              </div>
              <span class="badge rounded-pill bg-light text-dark">
                {{ $job->production_status ? ucwords(str_replace('_',' ',$job->production_status)) : __('Job Created') }}
              </span>
            </div>
            <div class="mt-2 small opacity-75">
              <div>{{ __('Delivery Date:') }} {{ optional($job->delivery_date)->format('Y-m-d') ?: '-' }}</div>
              <div>{{ __('Customer #:') }} {{ $job->customer_number ?? '-' }}</div>
              <div>{{ __('Customer Name:') }} {{ $job->customer_name ?? '-' }}</div>
            </div>
          </div>

          {{-- Body --}}
          <div class="p-3">
            <div class="small text-muted">
              <div class="mb-1">{{ __('Line:') }} <span class="text-body">{{ $job->line ?: '-' }}</span></div>
              <div class="mb-1">{{ __('Series:') }} <span class="text-body">{{ $job->series ?: '-' }}</span></div>
              <div class="mb-3">{{ __('Qty:') }} <span class="text-body">{{ $job->qty }}</span></div>
            </div>

            {{-- Single button (no duplicate <a>) --}}
            <a href="#"
               class="btn w-100 text-white customModal"
               style="background: var(--brand-red, #a70f0f); border-radius: 18px;"
               data-size="xl"
               data-title="{{ __('Job #') }} {{ $job->job_order_number }}"
               data-url="{{ route('manufacturing.job_planning.show', $job->id) }}">
               {{ __('Open Job') }}
            </a>
          </div>

        </div>
      </div>
    @empty
      <div class="col-12">
        <div class="alert alert-secondary mb-0">{{ __('No jobs found.') }}</div>
      </div>
    @endforelse
  </div>

</div>
@endsection

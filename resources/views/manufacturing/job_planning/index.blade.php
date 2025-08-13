@extends('layouts.app')

@section('page-title', __('Job Pool'))

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
<li class="breadcrumb-item active" aria-current="page">{{ __('Job Pool') }}</li>
@endsection

@section('content')
<div class="container-fluid">

    {{-- Filters --}}
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="fw-semibold">{{ __('Filter by:') }}</div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="queued" id="filterQueued"
                               @checked(request('status') === 'queued') 
                               onclick="window.location='{{ route('manufacturing.job-planning.index', ['status'=>'queued']) }}'">
                        <label class="form-check-label" for="filterQueued">{{ __('Queued') }}</label>
                    </div>
                </div>
                <input type="text" class="form-control mt-3" placeholder="{{ __('Search by Job # / Customer / Series') }}"
                       value="{{ request('q') }}"
                       onkeydown="if(event.key==='Enter'){window.location='{{ route('manufacturing.job-planning.index') }}?q='+encodeURIComponent(this.value)}">
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3">
                <div class="fw-semibold mb-2">&nbsp;</div>
                <div class="d-flex gap-2">
                    <a href="{{ route('manufacturing.job-planning.index') }}" class="btn btn-outline-secondary w-50">{{ __('Clear') }}</a>
                    <a href="{{ route('manufacturing.job-planning.create') }}" class="btn btn-primary customModal w-50"
                       data-size="lg" data-title="{{ __('Create Job') }}"
                       data-url="{{ route('manufacturing.job-planning.create') }}">
                        <i class="fa-solid fa-circle-plus"></i> {{ __('Create') }}
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Queue Title --}}
    <h5 class="mb-3">{{ __('Job Queue 01') }}</h5>

    {{-- Cards --}}
    <div class="row g-3">
        @forelse($jobs as $job)
        <div class="col-12 col-sm-6 col-lg-4 col-xxl-3">
            <div class="card h-100 shadow-sm" style="border-radius: 16px; overflow: hidden;">
                <div class="p-3 text-white" style="background:#a70f0f;">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="fw-bold" style="font-size:1.1rem;">{{ __('Job Order #') }} {{ $job->job_order_number }}</div>
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

                <div class="p-3">
                    <div class="small text-muted">
                        <div class="mb-1">{{ __('Line:') }} <span class="text-body">{{ $job->line ?: '-' }}</span></div>
                        <div class="mb-1">{{ __('Series:') }} <span class="text-body">{{ $job->series ?: '-' }}</span></div>
                        <div class="mb-3">{{ __('Qty:') }} <span class="text-body">{{ $job->qty }}</span></div>
                    </div>

                    <div class="mt-auto">
                        <a href="#" class="btn btn-lg w-100 text-white" style="background:#a70f0f; border-radius: 18px;"
                           data-size="xl"
                           data-title="{{ __('Job #') }} {{ $job->job_order_number }}"
                           data-url="{{ route('manufacturing.job-planning.show', $job->id) }}"
                           class="btn btn-primary customModal"
                           onclick="return false;"
                           data-bs-toggle="tooltip"
                           title="{{ __('Open Job') }}"
                        ></a>
                        <a href="#" class="btn btn-lg w-100 text-white customModal mt-n5" 
                           style="background:#a70f0f; border-radius: 18px;"
                           data-size="xl"
                           data-title="{{ __('Job #') }} {{ $job->job_order_number }}"
                           data-url="{{ route('manufacturing.job-planning.show', $job->id) }}">
                           {{ __('Open Job') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-secondary">{{ __('No jobs found.') }}</div>
        </div>
        @endforelse
    </div>

</div>
@endsection

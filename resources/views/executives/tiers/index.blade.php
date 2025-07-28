@extends('layouts.app')

@section('page-title', 'Tiers & Benefits')

@section('content')
<div class="mb-3 mt-4 d-flex justify-content-between align-items-center">
    <input type="text" class="form-control w-50" placeholder="Search tiers...">
    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#addTierModal">
        <i class="ti ti-plus"></i> Add Tier
    </button>
</div>

<div class="row">
    @forelse($tiers as $tier)
        <div class="col-md-3 mb-4">
            <div class="flip-card h-100">
                <div class="flip-card-inner">
                    {{-- Front --}}
                    <div class="flip-card-front card text-center p-3 d-flex flex-column justify-content-center">
                        <h5 class="fw-bold mb-0">{{ $tier->name }}</h5>
                        <button class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2" 
                                data-bs-toggle="modal" 
                                data-bs-target="#editTierModal-{{ $tier->id }}">
                            <i class="ti ti-pencil"></i>
                        </button>
                    </div>

                    {{-- Back --}}
                    <div class="flip-card-back card p-3 d-flex flex-column justify-content-center">
                        <h6 class="text-muted text-center">Benefits</h6>
                        <div class="text-center">
                            {!! nl2br(e($tier->benefits)) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Edit Modal --}}
        @include('executives.tiers.edit', ['tier' => $tier])
    @empty
        <p class="text-muted">No tiers added yet.</p>
    @endforelse
</div>

{{-- Add Modal --}}
@include('executives.tiers.create')
@endsection

@push('styles')
<style>
.flip-card {
    background-color: transparent;
    perspective: 1000px;
    height: 300px;
    position: relative;
}
.flip-card-inner {
    position: relative;
    width: 100%;
    height: 100%;
    transition: transform 0.6s;
    transform-style: preserve-3d;
}
.flip-card:hover .flip-card-inner {
    transform: rotateY(180deg);
}
.flip-card-front, .flip-card-back {
    position: absolute;
    width: 100%;
    height: 100%;
    backface-visibility: hidden;
    border-radius: 0.75rem;
}
.flip-card-front {
    background-color: #fff;
    z-index: 2;
}
.flip-card-back {
    background-color: #f8f9fa;
    transform: rotateY(180deg);
    z-index: 1;
}
</style>
@endpush

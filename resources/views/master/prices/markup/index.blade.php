@extends('layouts.app')

@section('page-title')
    {{ __('Markup') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item">{{ __('Master') }}</li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Markup') }}</li>
@endsection

@section('card-action-btn')
    <button type="button" class="btn btn-md btn-primary me-2" data-bs-toggle="modal" data-bs-target="#addMarkupModal">
        <i class="ti ti-plus"></i> Add Markup
    </button>
@endsection

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card table-card">
            <div class="card-header">
                <div class="row align-items-center g-2">
                    <div class="col">
                        <h5>{{ __('Markup List') }}</h5>
                    </div>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="dt-responsive table-responsive">
                    <table class="table table-hover advance-datatable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Series</th>
                                <th>Markup (%)</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($markups as $markup)
                                <tr>
                                    <td>{{ $markup->id }}</td>
                                    <td>{{ $markup->series->series ?? 'N/A' }}</td>
                                    <td>{{ $markup->percentage }}%</td>
                                    <td>
                                        @if(!$markup->locked)
                                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editMarkupModal{{ $markup->id }}">
                                                Edit
                                            </button>

                                            <form action="{{ route('master.prices.markup.lock', $markup->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-warning" onclick="return confirm('Lock this markup?')">
                                                    Lock
                                                </button>
                                            </form>
                                        @else
                                            <span class="badge bg-danger">Locked</span>
                                        @endif
                                    </td>
                                </tr>

                                <!-- Edit Modal -->
                                <div class="modal fade" id="editMarkupModal{{ $markup->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            @include('master.prices.markup.edit', ['markup' => $markup])
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addMarkupModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            @include('master.prices.markup.create')
        </div>
    </div>
</div>
@endsection

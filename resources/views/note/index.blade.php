@extends('layouts.app')
@section('page-title')
    {{ __('Notice Board') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item" aria-current="page"> {{ __('Notice Board') }}</li>
@endsection
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center g-2">
                        <div class="col">
                            <h5>{{ __('Note List') }}</h5>
                        </div>
                        @if (Gate::check('create note'))
                            <div class="col-auto">
                                <a href="#" class="btn btn-secondary customModal" data-size="md"
                                    data-url="{{ route('note.create') }}" data-title="{{ __('Create Note') }}"> <i
                                        class="ti ti-circle-plus align-text-bottom"></i> {{ __('Create Note') }}</a>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach ($notes as $note)
                            <div class="col-xxl-3 col-xl-4 col-md-6">
                                <div class="card follower-card">
                                    <div class="card-body p-3">
                                        @if (Gate::check('edit note') || Gate::check('delete note'))
                                            <div class="d-flex align-items-start mb-3">
                                                <div class="flex-grow-1 ">{{ dateFormat($note->created_at) }}</div>
                                                <div class="flex-shrink-0">
                                                    <div class="dropdown">
                                                        <a class="dropdown-toggle text-primary opacity-50 arrow-none"
                                                            href="#" data-bs-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                            <i class="ti ti-dots f-16"></i>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-end">
                                                            @if (Gate::check('edit note'))
                                                                <a class="dropdown-item customModal" href="#"
                                                                    data-url="{{ route('note.edit', $note->id) }}"
                                                                    data-title="{{ __('Edit Note') }}"> <i
                                                                        class="ti ti-edit"></i>{{ __('Edit') }}</a>
                                                            @endif
                                                            @if (Gate::check('delete note'))
                                                                {!! Form::open(['method' => 'DELETE', 'route' => ['note.destroy', $note->id], 'id' => 'user-' . $note->id]) !!}
                                                                <a href="#" class="dropdown-item confirm_dialog"><i
                                                                        class="ti ti-trash"></i> {{ __('Delete') }}</a>
                                                                {!! Form::close() !!}
                                                            @endif
                                                            @if (!empty($note->attachment))
                                                                <a class="dropdown-item"
                                                                    href="{{ asset('/storage/upload/applicant/attachment/' . $note->attachment) }}"
                                                                    target="_blank"><i class="ti ti-download"></i>{{ __('Download') }}</a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        <div class="row">
                                            <div class="col-12 mb-4">
                                                <p class="mb-0 text-muted text-sm">{{ __('Title') }}</p>
                                                <h6 class="mb-0">{{ $note->title }} </h6>
                                            </div>
                                            <div class="col-12 mb-4">
                                                <p class="mb-0 text-muted text-sm">{{ __('Description') }}</p>
                                                <h6 class="mb-0">
                                                    {{ !empty($note->description) ? $note->description : '-' }}
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

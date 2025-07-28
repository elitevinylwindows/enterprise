@extends('layouts.app')
@section('page-title')
    {{ __('Auth Page') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item" aria-current="page"> {{ __('Auth Page') }}</li>
@endsection
@php
    $profile = asset(Storage::url('upload/profile'));
    $settings = settings();
    $activeTab = session('tab', 'footer_column_1');
@endphp
@push('script-page')
    <script>
        $('.location').on('click', '.location_list_remove', function() {
            if ($('.location_list').length > 1) {
                $(this).closest('.location_remove').remove();
            }
        });
        $('.location').on('click', '.location_clone', function() {
            var clonedlocation = $(this).closest('.location').find('.location_list').first().clone();
            clonedlocation.find('input[type="text"]').val('');
            $(this).closest('.location').find('.location_list_results').append(clonedlocation);
        });
    </script>
@endpush


@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    {{ Form::model($authPage, ['route' => ['authPage.update', $authPage->id ?? 1], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) }}
                    <div class="row">

                        <div class="col form-group">
                            {{ Form::label('section', __('Section Enabled'), ['class' => 'form-label']) }}
                            <div class="form-check form-switch">
                                {{ Form::hidden('section', '0') }}
                                {{ Form::checkbox('section', '1', $authPage->section ?? false, ['class' => 'form-check-input', 'role' => 'switch']) }}
                            </div>
                        </div>

                        <div class="col form-group">
                            {{ Form::label('image', __('Image'), ['class' => 'form-label']) }}
                            @if (!empty($authPage->image))
                                <a href="{{ asset(Storage::url($authPage->image)) }}" target="_blank">
                                    <i class="ti ti-eye ms-2 f-15"></i>
                                </a>
                            @endif
                            {{ Form::file('image', ['class' => 'form-control']) }}
                        </div>

                        <div class="col-md-12 form-group location">
                            @if (!empty($titles) && count($titles) > 0)
                                @foreach ($titles as $index => $title)
                                    <div class="row location_list location_remove">
                                        <div class="col form-group">
                                            {{ Form::label('Sec6_Box_title', __('Title'), ['class' => 'form-label']) }}
                                            {{ Form::text('title[]', $title, ['class' => 'form-control', 'placeholder' => __('Enter title')]) }}
                                        </div>
                                        <div class="col form-group">
                                            {{ Form::label('Sec6_Box_subtitle', __('Sub Title'), ['class' => 'form-label']) }}
                                            {{ Form::text('description[]', $descriptions[$index] ?? '', ['class' => 'form-control', 'placeholder' => __('Enter subtitle')]) }}
                                        </div>
                                        <div class="col-auto form-group m-auto">
                                            <a href="javascript:void(0)"
                                                class="bg-danger text-white location_list_remove btn btn-md">
                                                <i class="ti ti-trash"></i>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <!-- If no titles are available, show blank input fields -->
                                <div class="row location_list location_remove">
                                    <div class="col form-group">
                                        {{ Form::label('title', __('Title'), ['class' => 'form-label']) }}
                                        {{ Form::text('title[]', '', ['class' => 'form-control', 'placeholder' => __('Enter title')]) }}
                                    </div>
                                    <div class="col form-group">
                                        {{ Form::label('description', __('Sub Title'), ['class' => 'form-label']) }}
                                        {{ Form::text('description[]', '', ['class' => 'form-control', 'placeholder' => __('Enter subtitle')]) }}
                                    </div>
                                    <div class="col-auto form-group m-auto">
                                        <a href="javascript:void(0)"
                                            class="bg-danger text-white location_list_remove btn btn-md">
                                            <i class="ti ti-trash"></i>
                                        </a>
                                    </div>
                                </div>
                            @endif

                            <div class="location_list_results"></div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <a href="javascript:void(0)" class="btn btn-secondary btn-xs location_clone">
                                        <i class="ti ti-plus"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-6"></div>
                            <div class="col-6 text-end">
                                {{ Form::hidden('tab', 'some_value') }}
                                {{ Form::submit(__('Save'), ['class' => 'btn btn-secondary btn-rounded']) }}
                            </div>
                        </div>

                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

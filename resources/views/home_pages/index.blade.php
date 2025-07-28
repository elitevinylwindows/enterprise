@extends('layouts.app')
@section('page-title')
    {{ __('System Settings') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item" aria-current="page"> {{ __('System Settings') }}</li>
@endsection
@php
    $profile = asset(Storage::url('upload/profile'));
    $settings = settings();
    $activeTab = session('tab', 'profile_tab_1');
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
                    <div class="row setting_page_cnt">
                        <div class="col-lg-4">
                            <ul class="nav flex-column nav-tabs account-tabs mb-3" id="myTab" role="tablist">
                                @foreach ($HomePage as $section_key => $section)
                                    @php
                                        $section->content_value = !empty($section->content_value)
                                            ? json_decode($section->content_value, true)
                                            : [];
                                    @endphp
                                    <li class="nav-item">
                                        <a class="nav-link {{ empty($activeTab) || $activeTab == 'profile_tab_'. $section->id  ? ' active ' : '' }}" id="profile-tab-{{ $section->id }}" data-bs-toggle="tab"
                                            href="#profile_tab_{{ $section->id }}" role="tab" aria-selected="true">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <i class="ti-view-list me-2 f-20"></i>
                                                </div>
                                                <div class="flex-grow-1 ms-2">
                                                    <h5 class="mb-0">
                                                        {{ !empty($section->content_value['name']) ? $section->content_value['name'] : $section->title }}
                                                    </h5>
                                                    <small class="text-muted"> {{ $section->title }}
                                                        {{ __('Section Settings') }}</small>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="col-lg-8">
                            @if (Gate::check('edit home page'))
                                <div class="tab-content">
                                    @foreach ($HomePage as $section)
                                        <div class="tab-pane {{ empty($activeTab) || $activeTab == 'profile_tab_'. $section->id  ? ' active show ' : '' }}" id="profile_tab_{{ $section->id }}" role="tabpanel"
                                            aria-labelledby="footer_column_1">
                                            {{ Form::model($section, ['route' => ['homepage.update', $section->id], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) }}
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        {{ Form::label('name', __('Name'), ['class' => 'form-label']) }}
                                                        {{ Form::text('content_value[name]', !empty($section->content_value['name']) ? $section->content_value['name'] : $section->title, ['class' => 'form-control', 'placeholder' => __('Enter Section name')]) }}
                                                    </div>
                                                </div>
                                                @if ($section->section == 'Section 0')
                                                    <div class="col-md-6 form-group">
                                                        {{ Form::label('Menu_pages', __('Menu Pages'), ['class' => 'form-label']) }}
                                                        {!! Form::select('content_value[menu_pages][]', $pages, null, [
                                                            'class' => 'form-control hidesearch',
                                                            'multiple',
                                                        ]) !!}
                                                    </div>
                                                @endif
                                                @if ($section->section == 'Section 1')
                                                    <div class="col-md-6 form-group">
                                                        {{ Form::label('enabled_email', __('Section Enabled'), ['class' => 'form-label']) }}
                                                        <div class="form-check form-switch">
                                                            {{ Form::hidden('content_value[section_enabled]', 'deactive') }}
                                                            {{ Form::checkbox('content_value[section_enabled]', 'active', !empty($section->content_value['section_enabled']) && $section->content_value['section_enabled'] == 'active' ? true : false, ['class' => 'form-check-input', 'role' => 'switch', 'id' => 'section_enabled']) }}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        {{ Form::label('title', __('Title'), ['class' => 'form-label']) }}
                                                        {{ Form::text('content_value[title]', !empty($section->content_value['title']) ? $section->content_value['title'] : '', ['class' => 'form-control', 'placeholder' => __('Enter Section name')]) }}
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        {{ Form::label('sub_title', __('Sub Title'), ['class' => 'form-label']) }}
                                                        {{ Form::text('content_value[sub_title]', !empty($section->content_value['sub_title']) ? $section->content_value['sub_title'] : '', ['class' => 'form-control', 'placeholder' => __('Enter sub title')]) }}
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        {{ Form::label('btn_name', __('Button Name'), ['class' => 'form-label']) }}
                                                        {{ Form::text('content_value[btn_name]', !empty($section->content_value['btn_name']) ? $section->content_value['btn_name'] : '', ['class' => 'form-control', 'placeholder' => __('Enter Button Name')]) }}
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        {{ Form::label('btn_link', __('Button Link'), ['class' => 'form-label']) }}
                                                        {{ Form::text('content_value[btn_link]', !empty($section->content_value['btn_link']) ? $section->content_value['btn_link'] : '', ['class' => 'form-control', 'placeholder' => __('Enter Button Link')]) }}
                                                    </div>
                                                    <div class="col-md-4 form-group">
                                                        {{ Form::label('section_footer_text', __('Header Sub Text'), ['class' => 'form-label']) }}
                                                        {{ Form::text('content_value[section_footer_text]', !empty($section->content_value['section_footer_text']) ? $section->content_value['section_footer_text'] : '', ['class' => 'form-control', 'placeholder' => __('Enter Footer Text')]) }}
                                                    </div>
                                                    <div class="col-md-4 form-group">
                                                        {{ Form::label('section_footer_image', __('Header Sub Image'), ['class' => 'form-label']) }}
                                                        <a href="{{ asset(Storage::url($section->content_value['section_footer_image_path'])) }}"
                                                            target="_blank"><i class="ti ti-eye ms-2 f-15"></i></a>
                                                        {{ Form::file('content_value[section_footer_image]', ['class' => 'form-control']) }}
                                                    </div>
                                                    <div class="col-md-4 form-group">
                                                        {{ Form::label('section_main_image', __('Main Image'), ['class' => 'form-label']) }}
                                                        <a href="{{ asset(Storage::url($section->content_value['section_main_image_path'])) }}"
                                                            target="_blank"><i class="ti ti-eye ms-2 f-15"></i></a>
                                                        {{ Form::file('content_value[section_main_image]', ['class' => 'form-control']) }}
                                                    </div>
                                                @endif
                                                @if ($section->section == 'Section 2')
                                                    <div class="col-md-6 form-group">
                                                        {{ Form::label('enabled_email', __('Section Enabled'), ['class' => 'form-label']) }}
                                                        <div class="form-check form-switch">
                                                            {{ Form::hidden('content_value[section_enabled]', 'deactive') }}
                                                            {{ Form::checkbox('content_value[section_enabled]', 'active', !empty($section->content_value['section_enabled']) && $section->content_value['section_enabled'] == 'active' ? true : false, ['class' => 'form-check-input', 'role' => 'switch', 'id' => 'section_enabled']) }}
                                                        </div>
                                                    </div>
                                                    @for ($i = 1; $i <= 3; $i++)
                                                        <div class="col-md-4 form-group">
                                                            {{ Form::label('Box' . $i . '_title', $i . __(' Box Title'), ['class' => 'form-label']) }}
                                                            {{ Form::text('content_value[Box' . $i . '_title]', !empty($section->content_value['Box' . $i . '_title']) ? $section->content_value['Box' . $i . '_title'] : '', ['class' => 'form-control', 'placeholder' => __('Enter Box Name')]) }}
                                                        </div>
                                                        <div class="col-md-4 form-group">
                                                            {{ Form::label('Box' . $i . '_number', $i . __(' Box Number'), ['class' => 'form-label']) }}
                                                            {{ Form::text('content_value[Box' . $i . '_number]', !empty($section->content_value['Box' . $i . '_number']) ? $section->content_value['Box' . $i . '_number'] : '', ['class' => 'form-control', 'placeholder' => __('Enter Box Number')]) }}
                                                        </div>
                                                        <div class="col-md-4 form-group">
                                                            {{ Form::label('Box' . $i . '_Image', $i . __(' Box Image'), ['class' => 'form-label']) }}
                                                            <a href="{{ asset(Storage::url($section->content_value['box_image_' . $i . '_path'])) }}"
                                                                target="_blank"><i class="ti ti-eye ms-2 f-15"></i></a>
                                                            {{ Form::file('content_value[box' . $i . '_number_image]', ['class' => 'form-control']) }}
                                                        </div>
                                                    @endfor
                                                @endif
                                                @if ($section->section == 'Section 3')
                                                    <div class="col-md-6 form-group">
                                                        {{ Form::label('enabled_email', __('Section Enabled'), ['class' => 'form-label']) }}
                                                        <div class="form-check form-switch">
                                                            {{ Form::hidden('content_value[section_enabled]', 'deactive') }}
                                                            {{ Form::checkbox('content_value[section_enabled]', 'active', !empty($section->content_value['section_enabled']) && $section->content_value['section_enabled'] == 'active' ? true : false, ['class' => 'form-check-input', 'role' => 'switch', 'id' => 'section_enabled']) }}
                                                        </div>
                                                    </div>
                                                    @for ($i = 1; $i <= 2; $i++)
                                                        <div class="col-md-6 form-group">
                                                            {{ Form::label('Box' . $i . '_title', $i . __(' Box Title'), ['class' => 'form-label']) }}
                                                            {{ Form::text('content_value[Box' . $i . '_title]', !empty($section->content_value['Box' . $i . '_title']) ? $section->content_value['Box' . $i . '_title'] : '', ['class' => 'form-control', 'placeholder' => __('Enter Box Name')]) }}
                                                        </div>
                                                        <div class="col-md-6 form-group">
                                                            {{ Form::label('Box' . $i . '_image', __(' Box image'), ['class' => 'form-label']) }}
                                                            <a href="{{ asset(Storage::url($section->content_value['Box' . $i . '_image_path'])) }}"
                                                                target="_blank"><i class="ti ti-eye ms-2 f-15"></i></a>
                                                            {{ Form::file('content_value[Box' . $i . '_image]', ['class' => 'form-control']) }}
                                                        </div>
                                                        <div class="col-md-12 form-group">
                                                            {{ Form::label('Box' . $i . '_info', $i . __(' Box info'), ['class' => 'form-label']) }}
                                                            {{ Form::text('content_value[Box' . $i . '_info]', !empty($section->content_value['Box' . $i . '_info']) ? $section->content_value['Box' . $i . '_info'] : '', ['class' => 'form-control', 'placeholder' => __('Enter Box info')]) }}
                                                        </div>
                                                        <div class="col-md-12 form-group location">
                                                            @if (!empty($section->content_value['Box' . $i . '_list']))
                                                                @foreach ($section->content_value['Box' . $i . '_list'] as $Box_list_key => $Box_list)
                                                                    <div class="row location_list location_remove">
                                                                        <div class="col-md-11 form-group">
                                                                            {{ Form::label('Box' . $i . '_list', __('Point'), ['class' => 'form-label']) }}
                                                                            {{ Form::text('content_value[Box' . $i . '_list][]', !empty($section->content_value['Box' . $i . '_list'][$Box_list_key]) ? $section->content_value['Box' . $i . '_list'][$Box_list_key] : '', ['class' => 'form-control', 'placeholder' => __('Enter date')]) }}
                                                                        </div>
                                                                        <div class="col-md-1 form-group m-auto">
                                                                            <a href="javascript:void(0)"
                                                                                class="bg-danger text-white location_list_remove btn btn-md ">
                                                                                <i class="ti ti-trash"></i></a>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            @else
                                                                <div class="row location_list location_remove">
                                                                    <div class="col-md-11 form-group">
                                                                        {{ Form::label('Box' . $i . '_list', __('Point'), ['class' => 'form-label']) }}
                                                                        {{ Form::text('content_value[Box' . $i . '_list][]', !empty($section->content_value['Box' . $i . '_list']) ? $section->content_value['Box' . $i . '_list'] : '', ['class' => 'form-control', 'placeholder' => __('Enter date')]) }}
                                                                    </div>
                                                                    <div class="col-md-1 form-group m-auto">
                                                                        <a href="javascript:void(0)"
                                                                            class="bg-danger text-white location_list_remove btn btn-md ">
                                                                            <i class="ti ti-trash"></i></a>
                                                                    </div>
                                                                </div>
                                                            @endif

                                                            <div class="location_list_results"></div>
                                                            <div class="row ">
                                                                <div class="col-sm-12">
                                                                    <a href="javascript:void(0)"
                                                                        class="btn btn-secondary btn-xs location_clone "><i
                                                                            class="ti ti-plus"></i></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endfor
                                                @endif
                                                @if ($section->section == 'Section 4')
                                                    <div class="col-md-6 form-group">
                                                        {{ Form::label('enabled_email', __('Section Enabled'), ['class' => 'form-label']) }}
                                                        <div class="form-check form-switch">
                                                            {{ Form::hidden('content_value[section_enabled]', 'deactive') }}
                                                            {{ Form::checkbox('content_value[section_enabled]', 'active', !empty($section->content_value['section_enabled']) && $section->content_value['section_enabled'] == 'active' ? true : false, ['class' => 'form-check-input', 'role' => 'switch', 'id' => 'section_enabled']) }}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        {{ Form::label('Sec4_title', __('Main Title'), ['class' => 'form-label']) }}
                                                        {{ Form::text('content_value[Sec4_title]', !empty($section->content_value['Sec4_title']) ? $section->content_value['Sec4_title'] : '', ['class' => 'form-control', 'placeholder' => __('Enter Data')]) }}
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        {{ Form::label('Sec4_info', __('Main Info'), ['class' => 'form-label']) }}
                                                        {{ Form::text('content_value[Sec4_info]', !empty($section->content_value['Sec4_info']) ? $section->content_value['Sec4_info'] : '', ['class' => 'form-control', 'placeholder' => __('Enter Data')]) }}
                                                    </div>
                                                    @for ($is4 = 1; $is4 <= 6; $is4++)
                                                        <div class="col-md-5 form-group">
                                                            {{ Form::label('sec4_info', __('Title'), ['class' => 'form-label']) }}
                                                            {{ Form::text('content_value[Sec4_box' . $is4 . '_title]', !empty($section->content_value['Sec4_box' . $is4 . '_title']) ? $section->content_value['Sec4_box' . $is4 . '_title'] : '', ['class' => 'form-control', 'placeholder' => __('Enter Data')]) }}
                                                        </div>
                                                        <div class="col-md-5 form-group">
                                                            {{ Form::label('sec4_image', __('Image'), ['class' => 'form-label']) }}
                                                            <a href="{{ asset(Storage::url($section->content_value['Sec4_box' . $is4 . '_image_path'])) }}"
                                                                target="_blank"><i class="ti ti-eye ms-2 f-15"></i></a>
                                                            {{ Form::file('content_value[Sec4_box' . $is4 . '_image]', ['class' => 'form-control']) }}
                                                        </div>
                                                        <div class="col-md-2 form-group">
                                                            {{ Form::label('enabled_email', __('Enabled'), ['class' => 'form-label']) }}
                                                            <div class="form-check form-switch">
                                                                {{ Form::hidden('content_value[Sec4_box' . $is4 . '_enabled]', 'deactive') }}
                                                                {{ Form::checkbox('content_value[Sec4_box' . $is4 . '_enabled]', 'active', !empty($section->content_value['Sec4_box' . $is4 . '_enabled']) && $section->content_value['Sec4_box' . $is4 . '_enabled'] == 'active' ? true : false, ['class' => 'form-check-input', 'role' => 'switch', 'id' => 'section_enabled']) }}
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 form-group">
                                                            {{ Form::label('sec4_image', __('Info'), ['class' => 'form-label']) }}
                                                            {{ Form::text('content_value[Sec4_box' . $is4 . '_info]', !empty($section->content_value['Sec4_box' . $is4 . '_info']) ? $section->content_value['Sec4_box' . $is4 . '_info'] : '', ['class' => 'form-control', 'placeholder' => __('Enter Data')]) }}
                                                        </div>
                                                    @endfor
                                                @endif
                                                @if ($section->section == 'Section 5')
                                                    <div class="col-md-6 form-group">
                                                        {{ Form::label('enabled_email', __('Section Enabled'), ['class' => 'form-label']) }}
                                                        <div class="form-check form-switch">
                                                            {{ Form::hidden('content_value[section_enabled]', 'deactive') }}
                                                            {{ Form::checkbox('content_value[section_enabled]', 'active', !empty($section->content_value['section_enabled']) && $section->content_value['section_enabled'] == 'active' ? true : false, ['class' => 'form-check-input', 'role' => 'switch', 'id' => 'section_enabled']) }}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        {{ Form::label('Sec5_title', __('Main Title'), ['class' => 'form-label']) }}
                                                        {{ Form::text('content_value[Sec5_title]', !empty($section->content_value['Sec5_title']) ? $section->content_value['Sec5_title'] : '', ['class' => 'form-control', 'placeholder' => __('Enter Data')]) }}
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        {{ Form::label('Sec5_info', __('Main Info'), ['class' => 'form-label']) }}
                                                        {{ Form::text('content_value[Sec5_info]', !empty($section->content_value['Sec5_info']) ? $section->content_value['Sec5_info'] : '', ['class' => 'form-control', 'placeholder' => __('Enter Data')]) }}
                                                    </div>
                                                @endif
                                                @if ($section->section == 'Section 6')
                                                    <div class="col-md-6 form-group">
                                                        {{ Form::label('enabled_email', __('Section Enabled'), ['class' => 'form-label']) }}
                                                        <div class="form-check form-switch">
                                                            {{ Form::hidden('content_value[section_enabled]', 'deactive') }}
                                                            {{ Form::checkbox('content_value[section_enabled]', 'active', !empty($section->content_value['section_enabled']) && $section->content_value['section_enabled'] == 'active' ? true : false, ['class' => 'form-check-input', 'role' => 'switch', 'id' => 'section_enabled']) }}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        {{ Form::label('Sec6_title', __('Main Title'), ['class' => 'form-label']) }}
                                                        {{ Form::text('content_value[Sec6_title]', !empty($section->content_value['Sec6_title']) ? $section->content_value['Sec6_title'] : '', ['class' => 'form-control', 'placeholder' => __('Enter Data')]) }}
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        {{ Form::label('Sec6_info', __('Main Info'), ['class' => 'form-label']) }}
                                                        {{ Form::text('content_value[Sec6_info]', !empty($section->content_value['Sec6_info']) ? $section->content_value['Sec6_info'] : '', ['class' => 'form-control', 'placeholder' => __('Enter Data')]) }}
                                                    </div>

                                                    <div class="col-md-12 form-group location">
                                                        @if (!empty($section->content_value['Sec6_Box_title']))
                                                            @foreach ($section->content_value['Sec6_Box_title'] as $Box_title_key => $Box_title)
                                                                <div class="row location_list location_remove">
                                                                    <div class="col-md-4 form-group">
                                                                        {{ Form::label('Sec6_Box_title', __('Title'), ['class' => 'form-label']) }}
                                                                        {{ Form::text('content_value[Sec6_Box_title][]', !empty($section->content_value['Sec6_Box_title'][$Box_title_key]) ? $section->content_value['Sec6_Box_title'][$Box_title_key] : '', ['class' => 'form-control', 'placeholder' => __('Enter date')]) }}
                                                                    </div>
                                                                    <div class="col-md-4 form-group">
                                                                        {{ Form::label('Sec6_Box_subtitle', __('Sub Title'), ['class' => 'form-label']) }}
                                                                        {{ Form::text('content_value[Sec6_Box_subtitle][]', !empty($section->content_value['Sec6_Box_subtitle'][$Box_title_key]) ? $section->content_value['Sec6_Box_subtitle'][$Box_title_key] : '', ['class' => 'form-control', 'placeholder' => __('Enter date')]) }}
                                                                    </div>
                                                                    <div class="col-md-3 form-group">
                                                                        {{ Form::label('Sec6_Box_image', __('Image'), ['class' => 'form-label']) }}
                                                                        <a href="{{ asset(Storage::url($section->content_value['Sec6_box'.$Box_title_key.'_image_path'])) }}"
                                                                            target="_blank"><i
                                                                                class="ti ti-eye ms-2 f-15"></i></a>
                                                                        {{ Form::file('content_value[Sec6_box_image][]', ['class' => 'form-control']) }}
                                                                    </div>
                                                                    <div class="col-md-1 form-group m-auto">
                                                                        <a href="javascript:void(0)"
                                                                            class="bg-danger text-white location_list_remove btn btn-md ">
                                                                            <i class="ti ti-trash"></i></a>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        @else
                                                            <div class="row location_list location_remove">
                                                                <div class="col-md-4 form-group">
                                                                    {{ Form::label('Sec6_Box_title', __('Title'), ['class' => 'form-label']) }}
                                                                    {{ Form::text('content_value[Sec6_Box_title][]', null, ['class' => 'form-control', 'placeholder' => __('Enter date')]) }}
                                                                </div>
                                                                <div class="col-md-4 form-group">
                                                                    {{ Form::label('Sec6_Box_subtitle', __('Sub Title'), ['class' => 'form-label']) }}
                                                                    {{ Form::text('content_value[Sec6_Box_subtitle][]', null, ['class' => 'form-control', 'placeholder' => __('Enter date')]) }}
                                                                </div>
                                                                <div class="col-md-3 form-group">
                                                                    {{ Form::label('Sec6_Box_image', __('Image'), ['class' => 'form-label']) }}
                                                                    <a href="{{ asset(Storage::url($section->content_value['box_image_' . $i . '_path'])) }}"
                                                                        target="_blank"><i
                                                                            class="ti ti-eye ms-2 f-15"></i></a>
                                                                    {{ Form::file('content_value[Sec6_box_image][]', ['class' => 'form-control']) }}
                                                                </div>
                                                                <div class="col-md-1 form-group m-auto">
                                                                    <a href="javascript:void(0)"
                                                                        class="bg-danger text-white location_list_remove btn btn-md ">
                                                                        <i class="ti ti-trash"></i></a>
                                                                </div>
                                                            </div>
                                                        @endif

                                                        <div class="location_list_results"></div>
                                                        <div class="row ">
                                                            <div class="col-sm-12">
                                                                <a href="javascript:void(0)"
                                                                    class="btn btn-secondary btn-xs location_clone "><i
                                                                        class="ti ti-plus"></i></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                                @if ($section->section == 'Section 7')
                                                    <div class="col-md-6 form-group">
                                                        {{ Form::label('enabled_email', __('Section Enabled'), ['class' => 'form-label']) }}
                                                        <div class="form-check form-switch">
                                                            {{ Form::hidden('content_value[section_enabled]', 'deactive') }}
                                                            {{ Form::checkbox('content_value[section_enabled]', 'active', !empty($section->content_value['section_enabled']) && $section->content_value['section_enabled'] == 'active' ? true : false, ['class' => 'form-check-input', 'role' => 'switch', 'id' => 'section_enabled']) }}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        {{ Form::label('Sec7_title', __('Main Title'), ['class' => 'form-label']) }}
                                                        {{ Form::text('content_value[Sec7_title]', !empty($section->content_value['Sec7_title']) ? $section->content_value['Sec7_title'] : '', ['class' => 'form-control', 'placeholder' => __('Enter Data')]) }}
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        {{ Form::label('Sec7_info', __('Main Info'), ['class' => 'form-label']) }}
                                                        {{ Form::text('content_value[Sec7_info]', !empty($section->content_value['Sec7_info']) ? $section->content_value['Sec7_info'] : '', ['class' => 'form-control', 'placeholder' => __('Enter Data')]) }}
                                                    </div>
                                                    @for ($is7 = 1; $is7 <= 8; $is7++)
                                                        <div class="col-md-4 form-group">
                                                            {{ Form::label('Sec7_box' . $is7 . '_name', __('Name'), ['class' => 'form-label']) }}
                                                            {{ Form::text('content_value[Sec7_box' . $is7 . '_name]', !empty($section->content_value['Sec7_box' . $is7 . '_name']) ? $section->content_value['Sec7_box' . $is7 . '_name'] : '', ['class' => 'form-control', 'placeholder' => __('Enter Data')]) }}
                                                        </div>
                                                        <div class="col-md-4 form-group">
                                                            {{ Form::label('Sec7_box' . $is7 . '_tag', __('Tag'), ['class' => 'form-label']) }}
                                                            {{ Form::text('content_value[Sec7_box' . $is7 . '_tag]', !empty($section->content_value['Sec7_box' . $is7 . '_tag']) ? $section->content_value['Sec7_box' . $is7 . '_tag'] : '', ['class' => 'form-control', 'placeholder' => __('Enter Data')]) }}
                                                        </div>
                                                        <div class="col-md-3 form-group">
                                                            {{ Form::label('Sec7_box' . $is7 . '_info', __('Main Info'), ['class' => 'form-label']) }}
                                                            <a href="{{ asset(Storage::url($section->content_value['Sec7_box'.$is7.'_image_path'])) }}"
                                                                target="_blank"><i class="ti ti-eye ms-2 f-15"></i></a>
                                                            {{ Form::file('content_value[Sec7_box' . $is7 . '_image]', ['class' => 'form-control']) }}
                                                        </div>
                                                        <div class="col-md-1 form-group">
                                                            {{ Form::label('Sec7_box' . $is7 . '_Enabled', __('Enabled'), ['class' => 'form-label']) }}
                                                            <div class="form-check form-switch">
                                                                {{ Form::hidden('content_value[Sec7_box' . $is7 . '_Enabled]', 'deactive') }}
                                                                {{ Form::checkbox('content_value[Sec7_box' . $is7 . '_Enabled]', 'active', !empty($section->content_value['Sec7_box' . $is7 . '_Enabled']) && $section->content_value['Sec7_box' . $is7 . '_Enabled'] == 'active' ? true : false, ['class' => 'form-check-input', 'role' => 'switch', 'id' => 'section_enabled']) }}
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 form-group">
                                                            {{ Form::label('Sec7_box' . $is7 . '_review', __('Review'), ['class' => 'form-label']) }}
                                                            {{ Form::text('content_value[Sec7_box' . $is7 . '_review]', !empty($section->content_value['Sec7_box' . $is7 . '_review']) ? $section->content_value['Sec7_box' . $is7 . '_review'] : '', ['class' => 'form-control', 'placeholder' => __('Enter Data')]) }}
                                                        </div>
                                                    @endfor
                                                @endif
                                                @if ($section->section == 'Section 8')
                                                    <div class="col-md-6 form-group">
                                                        {{ Form::label('enabled_email', __('Section Enabled'), ['class' => 'form-label']) }}
                                                        <div class="form-check form-switch">
                                                            {{ Form::hidden('content_value[section_enabled]', 'deactive') }}
                                                            {{ Form::checkbox('content_value[section_enabled]', 'active', !empty($section->content_value['section_enabled']) && $section->content_value['section_enabled'] == 'active' ? true : false, ['class' => 'form-check-input', 'role' => 'switch', 'id' => 'section_enabled']) }}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 form-group">
                                                        {{ Form::label('Sec8_title', __('Main Title'), ['class' => 'form-label']) }}
                                                        {{ Form::text('content_value[Sec8_title]', !empty($section->content_value['Sec8_title']) ? $section->content_value['Sec8_title'] : '', ['class' => 'form-control', 'placeholder' => __('Enter Data')]) }}
                                                    </div>
                                                    @for ($is8 = 1; $is8 <= 8; $is8++)
                                                        <div class="col-md-6 form-group">
                                                            {{ Form::label('Sec8_box' . $is8 . '_info', __('Main Info'), ['class' => 'form-label']) }}
                                                            {{ Form::text('content_value[Sec8_box' . $is8 . '_info]', !empty($section->content_value['Sec8_box' . $is8 . '_info']) ? $section->content_value['Sec8_box' . $is8 . '_info'] : '', ['class' => 'form-control', 'placeholder' => __('Enter Data')]) }}
                                                        </div>
                                                    @endfor
                                                @endif
                                                @if ($section->section == 'Section 9')
                                                    <div class="col-md-6 form-group">
                                                        {{ Form::label('enabled_email', __('Section Enabled'), ['class' => 'form-label']) }}
                                                        <div class="form-check form-switch">
                                                            {{ Form::hidden('content_value[section_enabled]', 'deactive') }}
                                                            {{ Form::checkbox('content_value[section_enabled]', 'active', !empty($section->content_value['section_enabled']) && $section->content_value['section_enabled'] == 'active' ? true : false, ['class' => 'form-check-input', 'role' => 'switch', 'id' => 'section_enabled']) }}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        {{ Form::label('Sec9_title', __('Main Title'), ['class' => 'form-label']) }}
                                                        {{ Form::text('content_value[Sec9_title]', !empty($section->content_value['Sec9_title']) ? $section->content_value['Sec9_title'] : '', ['class' => 'form-control', 'placeholder' => __('Enter Data')]) }}
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        {{ Form::label('Sec9_info', __('Main Info'), ['class' => 'form-label']) }}
                                                        {{ Form::text('content_value[Sec9_info]', !empty($section->content_value['Sec9_info']) ? $section->content_value['Sec9_info'] : '', ['class' => 'form-control', 'placeholder' => __('Enter Data')]) }}
                                                    </div>
                                                @endif
                                                @if ($section->section == 'Section 10')
                                                    <div class="col-md-6 form-group">
                                                        {{ Form::label('enabled_email', __('Section Enabled'), ['class' => 'form-label']) }}
                                                        <div class="form-check form-switch">
                                                            {{ Form::hidden('content_value[section_enabled]', 'deactive') }}
                                                            {{ Form::checkbox('content_value[section_enabled]', 'active', !empty($section->content_value['section_enabled']) && $section->content_value['section_enabled'] == 'active' ? true : false, ['class' => 'form-check-input', 'role' => 'switch', 'id' => 'section_enabled']) }}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        {{ Form::label('Sec10_title', __('Main Title'), ['class' => 'form-label']) }}
                                                        {{ Form::text('content_value[Sec10_title]', !empty($section->content_value['Sec10_title']) ? $section->content_value['Sec10_title'] : '', ['class' => 'form-control', 'placeholder' => __('Enter Data')]) }}
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        {{ Form::label('Sec10_info', __('Main Info'), ['class' => 'form-label']) }}
                                                        {{ Form::text('content_value[Sec10_info]', !empty($section->content_value['Sec10_info']) ? $section->content_value['Sec10_info'] : '', ['class' => 'form-control', 'placeholder' => __('Enter Data')]) }}
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="row mt-3">
                                                <div class="col-6"></div>
                                                <div class="col-6 text-end">
                                                    <input type="hidden" name="tab"
                                                        value="profile_tab_{{ $section->id }}">
                                                    {{ Form::submit(__('Save'), ['class' => 'btn btn-secondary btn-rounded']) }}
                                                </div>
                                            </div>
                                            {{ Form::close() }}
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@php
    $DefaultCustomPage = DefaultCustomPage();
    $admin_logo = getSettingsValByName('company_logo');
    $lightLogo = getSettingsValByName('light_logo');
    $settings = settings();
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <meta name="author" content="{{ !empty($settings['app_name']) ? $settings['app_name'] : env('APP_NAME') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ !empty($settings['app_name']) ? $settings['app_name'] : env('APP_NAME') }} - @yield('page-title') </title>

    <meta name="title" content="{{ $settings['meta_seo_title'] }}">
    <meta name="keywords" content="{{ $settings['meta_seo_keyword'] }}">
    <meta name="description" content="{{ $settings['meta_seo_description'] }}">


    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ env('APP_URL') }}">
    <meta property="og:title" content="{{ $settings['meta_seo_title'] }}">
    <meta property="og:description" content="{{ $settings['meta_seo_description'] }}">
    <meta property="og:image" content="{{ asset(Storage::url('upload/seo')) . '/' . $settings['meta_seo_image'] }}">

    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ env('APP_URL') }}">
    <meta property="twitter:title" content="{{ $settings['meta_seo_title'] }}">
    <meta property="twitter:description" content="{{ $settings['meta_seo_description'] }}">
    <meta property="twitter:image"
        content="{{ asset(Storage::url('upload/seo')) . '/' . $settings['meta_seo_image'] }}">

    <!-- shortcut icon-->
    <link rel="icon" href="{{ asset(Storage::url('upload/logo')) . '/' . $settings['company_favicon'] }}"
        type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset(Storage::url('upload/logo')) . '/' . $settings['company_favicon'] }}"
        type="image/x-icon">

    <link rel="stylesheet" href="{{ asset('assets/css/plugins/notifier.css') }}" />
    <!-- [Page specific CSS] start -->
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/datepicker-bs5.min.css') }}" />
    <!-- [Page specific CSS] end -->

    <!-- data tables css -->
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/dataTables.bootstrap5.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/buttons.bootstrap5.min.css') }}" />

    <!-- [Google Font] Family -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap"
        id="main-font-link" />
    <link rel="stylesheet" href="{{ asset('assets/fonts/phosphor/duotone/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/fonts/feather.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/fonts/material.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" id="main-style-link" />
    @if (!empty($settings['custom_color']) && $settings['color_type'] == 'custom')
	<link rel="stylesheet" id="Pstylesheet" href="{{ asset('assets/css/custom-color.css') }}" />
<script src="{{ asset('js/theme-pre-color.js') }}"></script>
@else
	<link rel="stylesheet" id="Pstylesheet" href="{{ asset('assets/css/style-preset.css') }}" />
@endif

    @stack('css-page')
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">


</head>



<body data-pc-preset="{{ !empty($settings['color_type']) && $settings['color_type'] == 'custom' ? 'custom' : $settings['accent_color'] }}" data-pc-sidebar-theme="light"
    data-pc-sidebar-caption="{{ $settings['sidebar_caption'] }}" data-pc-direction="{{ $settings['theme_layout'] }}"
    data-pc-theme="{{ $settings['theme_mode'] }}">
    <!-- Login Start-->
    <div class="auth-main">
        <div class="auth-wrapper v3">
            <div class="auth-form">
                <div class="card my-5 pre-regi">
                    <div class="card-body">
                        <div class="row">
                            <div class="d-flex justify-content-center">
                                <div class="auth-header">
                                    {{-- <h2 class="text-secondary mt-5"><b>{{__('Visitor Pre Registration Form')}}</b></h2> --}}
                                    <img class="img-fluid dark-logo brand-logo" src="{{asset(Storage::url('upload/logo')).'/'.$settings['company_logo']}}" alt="">
                                    <p class="f-16 mt-10">{{__('Visitor Pre Registration Form')}}</p>
                                </div>
                            </div>
                        </div>

                        {{Form::open(array('route'=>array('pre-register.store',$id),'method'=>'post'))}}

                        <div class="row">
                            <div class="form-group  col-md-6">
                                {{Form::label('first_name',__('First Name'),array('class'=>'form-label'))}}
                                {{Form::text('first_name',null,array('class'=>'form-control','placeholder'=>__('Enter first name')))}}
                            </div>
                            <div class="form-group  col-md-6">
                                {{Form::label('last_name',__('Last Name'),array('class'=>'form-label'))}}
                                {{Form::text('last_name',null,array('class'=>'form-control','placeholder'=>__('Enter last name')))}}
                            </div>
                            <div class="form-group  col-md-6">
                                {{Form::label('email',__('Email'),array('class'=>'form-label'))}}
                                {{Form::text('email',null,array('class'=>'form-control','placeholder'=>__('Enter email')))}}
                            </div>
                            <div class="form-group  col-md-6">
                                {{Form::label('phone_number',__('Phone Number'),array('class'=>'form-label'))}}
                                {{Form::text('phone_number',null,array('class'=>'form-control','placeholder'=>__('Enter phone number')))}}
                            </div>
                            <div class="form-group col-md-6">
                                {{Form::label('gender',__('Gender'),array('class'=>'form-label'))}}
                                {{Form::select('gender',$gender,null,array('class'=>'form-control hidesearch'))}}
                            </div>
                            <div class="form-group col-md-6">
                                {{Form::label('category',__('Category'),array('class'=>'form-label'))}}
                                {{Form::select('category',$category,null,array('class'=>'form-control hidesearch'))}}
                            </div>
                            <div class="form-group  col-md-6">
                                {{Form::label('address',__('Address'),array('class'=>'form-label'))}}
                                {{Form::textarea('address',null,array('class'=>'form-control','rows'=>1))}}
                            </div>
                            <div class="form-group  col-md-6">
                                {{Form::label('date',__('Visit Date'),array('class'=>'form-label'))}}
                                {{Form::date('date',date('Y-m-d'),array('class'=>'form-control'))}}
                            </div>
                            <div class="form-group  col-md-6">
                                {{Form::label('entry_time',__('Entry Time'),array('class'=>'form-label'))}}
                                {{Form::time('entry_time',null,array('class'=>'form-control'))}}
                            </div>
                            <div class="form-group  col-md-6">
                                {{Form::label('exit_time',__('Exit Time'),array('class'=>'form-label'))}}
                                {{Form::time('exit_time',null,array('class'=>'form-control'))}}
                            </div>

                            <div class="form-group">
                                {{Form::label('notes',__('Notes'),array('class'=>'form-label'))}}
                                {{Form::textarea('notes',null,array('class'=>'form-control','rows'=>2))}}
                            </div>
                            <div class="form-group btn-pre-regi">
                                <button class="btn btn-secondary" type="submit">
                                    <i class="fa fa-paper-plane"></i> {{__('Submit')}}</button>
                            </div>


                        </div>

                        {{ Form::close() }}

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Login End-->
    <!-- main jquery-->

    <script src="{{ asset('js/jquery.js') }}"></script>
    <!-- Required Js -->
    <script src="{{ asset('assets/js/plugins/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/fonts/custom-font.js') }}"></script>
    <script>
        var lightLogo = "{{ asset(Storage::url('upload/logo')) . '/' . $lightLogo }}";
        var logo = "{{ asset(Storage::url('upload/logo')) . '/' . $admin_logo }}";
    </script>
    <script src="{{ asset('assets/js/pcoded.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/feather.min.js') }}"></script>


    <!-- datatable Js -->
    <script src="{{ asset('assets/js/plugins/dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/buttons.bootstrap5.min.js') }}"></script>
    <script>
        font_change("{{ $settings['layout_font'] }}");
    </script>

    <script>
        change_box_container("{{ $settings['layout_width'] }}");
    </script>


    <!-- [Page Specific JS] start -->
    <!-- bootstrap-datepicker -->
    <script src="{{ asset('assets/js/plugins/datepicker-full.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/peity-vanilla.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/notifier.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/choices.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/ckeditor/classic/ckeditor.js') }}"></script>

</body>

</html>

<!DOCTYPE html>
@php
    use App\Models\AuthPage;

    $settings = settings();
    $authPage = AuthPage::where('parent_id', 1)->first();
    $titles = $authPage && !empty($authPage->title) ? json_decode($authPage->title, true) : [];
    $descriptions = $authPage && !empty($authPage->description) ? json_decode($authPage->description, true) : [];
@endphp

<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ env('APP_NAME') }} - @yield('tab-title')</title>
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

    <link rel="icon" href="{{ asset(Storage::url('upload/logo')) . '/favicon.png' }}" type="image/x-icon" />
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
    <link href="{{ asset('css/custom.css') }} " rel="stylesheet">
</head>

<body data-pc-preset="{{ !empty($settings['color_type']) && $settings['color_type'] == 'custom' ? 'custom' : $settings['accent_color'] }}" data-pc-sidebar-theme="light"
    data-pc-sidebar-caption="{{ $settings['sidebar_caption'] }}" data-pc-direction="{{ $settings['theme_layout'] }}"
    data-pc-theme="{{ $settings['theme_mode'] }}">
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>
    <div class="auth-main">
        <div class="auth-wrapper v2">
            <div class="auth-form">
                <div class="logo">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset(Storage::url('upload/logo/')) . '/logo.png' }}" alt="image"
                            class="img-fluid brand-logo" />
                    </a>
                </div>
                @yield('content')
            </div>


            @if (!empty($authPage) && $authPage->section == 1 )
                <div class="auth-sidecontent">
                    <div class="p-3 px-lg-5 text-center">
                        <div id="carouselExampleIndicators" class="carousel slide carousel-dark"
                            data-bs-ride="carousel">
                            <div class="carousel-inner">
                                @foreach ($titles as $index => $title)
                                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                        <h1><b>{{ $title }}</b></h1>
                                        <p class="f-12 mt-4">{{ $descriptions[$index] ?? '' }}</p>
                                    </div>
                                @endforeach
                            </div>

                            <div class="carousel-indicators position-relative">
                                @foreach ($titles as $index => $title)
                                    <button type="button" data-bs-target="#carouselExampleIndicators"
                                        data-bs-slide-to="{{ $index }}"
                                        class="{{ $index == 0 ? 'active' : '' }}"
                                        aria-current="{{ $index == 0 ? 'true' : 'false' }}"
                                        aria-label="Slide {{ $index + 1 }}"></button>
                                @endforeach
                            </div>
                        </div>
                        <img src="{{ asset(Storage::url($authPage->image)) }}" alt="images"
                            class="img-fluid mt-3 w-75" />
                    </div>
                </div>
            @endif


        </div>
    </div>
    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/fonts/custom-font.js') }}"></script>
    <script src="{{ asset('assets/js/pcoded.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/feather.min.js') }}"></script>

    @stack('script-page')
    <script>
        font_change('Roboto');
    </script>
</body>

</html>

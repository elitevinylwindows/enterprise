@php
    $profile = asset(Storage::url('upload/profile'));
    $settings = settings();
    $user = \App\Models\User::find(1);
    \App::setLocale($user->lang);
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ env('APP_NAME') }}</title>

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


    <link rel="icon" href="{{ asset(Storage::url('upload/logo')) . '/' . $settings['company_favicon'] }}"
        type="image/x-icon" />
    <link href="{{ asset('assets/css/plugins/animate.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/plugins/swiper-bundle.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap"
        id="main-font-link" />
    <link rel="stylesheet" href="{{ asset('assets/fonts/phosphor/duotone/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/fonts/feather.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/fonts/material.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" id="main-style-link" />
    @if (!empty($settings['custom_color']) && $settings['color_type'] == 'custom')
	<link rel="stylesheet" id="Pstylesheet" href="{{ asset('assets/css/custom-color.css') }}" />
<script src="{{ asset('js/theme-pre-color.js') }}"></script>
@else
	<link rel="stylesheet" id="Pstylesheet" href="{{ asset('assets/css/style-preset.css') }}" />
@endif
    <link rel="stylesheet" href="{{ asset('assets/css/landing.css') }}" />
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
</head>

<body class="landing-page" data-pc-preset="{{ !empty($settings['color_type']) && $settings['color_type'] == 'custom' ? 'custom' : $settings['accent_color'] }}" data-pc-sidebar-theme="light"
    data-pc-sidebar-caption="{{ $settings['sidebar_caption'] }}" data-pc-direction="{{ $settings['theme_layout'] }}"
    data-pc-theme="{{ $settings['theme_mode'] }}">

    <nav class="navbar navbar-expand-md navbar-light default">
        <div class="container">
            <a class="navbar-brand landing-logo" href="{{ route('home') }}">
                <img src="{{ asset(Storage::url('upload/logo/landing_logo.png')) }}" alt="logo"
                    class="img-fluid " />
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" href="#home">{{ __('Home') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#pricing">{{ __('Pricing') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#features">{{ __('Features') }}</a>
                    </li>
                    @php
                        $HomePage = App\Models\HomePage::where('section', 'Section 0')->first();
                    @endphp
                    @if (!empty($HomePage->content_value))
                        @php
                            $HomePage = json_decode($HomePage->content_value, true);
                            $active_menus = !empty($HomePage['menu_pages']) ? $HomePage['menu_pages'] : [];
                        @endphp
                        @foreach ($menus as $menu)
                            @if (in_array($menu->id, $active_menus))
                                <li class="nav-item">
                                    <a class="nav-link mb-2"
                                        href="{{ route('page', $menu->slug) }}">{{ $menu->title }}</a>
                                </li>
                            @endif
                        @endforeach
                    @endif
                    <li class="nav-item">
                        <a class="nav-link me-2" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-secondary" href="{{ route('register') }}">
                            {{ __('Get Started') }}
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- [ Nav ] start -->
    <!-- [ Header ] start -->
    @php
        $Section_1 = App\Models\HomePage::where('section', 'Section 1')->first();
        $Section_1_content_value = !empty($Section_1->content_value)
            ? json_decode($Section_1->content_value, true)
            : [];
    @endphp
    @if (empty($Section_1_content_value['section_enabled']) || $Section_1_content_value['section_enabled'] == 'active')
        <header id="home">
            <div class="container">
                <div class="row align-items-center justify-content-between">
                    <div class="col-lg-6 col-xl-6">
                        <h1 class="mt-sm-3 mb-sm-4 f-w-600 wow fadeInUp" data-wow-delay="0.2s">
                            @if (!empty($Section_1_content_value['title']))
                                {{ $Section_1_content_value['title'] }}
                            @else
                                Smart Tenant - Property Management System
                            @endif
                        </h1>
                        <h4 class="mb-sm-4 text-muted wow fadeInUp" data-wow-delay="0.4s">
                            @if (!empty($Section_1_content_value['sub_title']))
                                {{ $Section_1_content_value['sub_title'] }}
                            @else
                                Property management refers to the administration, operation, and oversight of real
                                estate properties on behalf of property owners. It involves various tasks such as
                                marketing rental properties, finding tenants, collecting rent and ensuring legal
                                compliance.
                            @endif
                        </h4>
                        @php
                            $Section_1_btn_link = !empty($Section_1_content_value['btn_link'])
                                ? $Section_1_content_value['btn_link']
                                : '#';
                        @endphp
                        <div class="my-3 my-xl-5 wow fadeInUp" data-wow-delay="0.6s">
                            @php
                                $sec1_url = $Section_1_btn_link;
                                if (in_array($Section_1_btn_link, ['#', ''])) {
                                    $sec1_url = route('register');
                                }
                            @endphp
                            <a href="{{ $sec1_url }}" class="btn btn-secondary me-2">
                                @if (!empty($Section_1_content_value['btn_name']))
                                    {{ $Section_1_content_value['btn_name'] }}
                                @else
                                    {{ __('Get Started') }}
                                @endif
                            </a>

                        </div>
                        <div class="mb-4 mb-lg-0 d-inline-flex align-items-center wow fadeInUp" data-wow-delay="0.8s">
                            <div class="flex-shrink-0">
                                <div class="avtar avtar-l bg-light-secondary text-secondary">
                                    @if (!empty($Section_1_content_value['section_footer_image_path']))
                                        <img src="{{ asset(Storage::url($Section_1_content_value['section_footer_image_path'])) }}"
                                            alt="user-image" class="img-fluid wid-80" />
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="32"
                                            class="d-block" viewBox="0 0 118 94" role="img">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M24.509 0c-6.733 0-11.715 5.893-11.492 12.284.214 6.14-.064 14.092-2.066 20.577C8.943 39.365 5.547 43.485 0 44.014v5.972c5.547.529 8.943 4.649 10.951 11.153 2.002 6.485 2.28 14.437 2.066 20.577C12.794 88.106 17.776 94 24.51 94H93.5c6.733 0 11.714-5.893 11.491-12.284-.214-6.14.064-14.092 2.066-20.577 2.009-6.504 5.396-10.624 10.943-11.153v-5.972c-5.547-.529-8.934-4.649-10.943-11.153-2.002-6.484-2.28-14.437-2.066-20.577C105.214 5.894 100.233 0 93.5 0H24.508zM80 57.863C80 66.663 73.436 72 62.543 72H44a2 2 0 01-2-2V24a2 2 0 012-2h18.437c9.083 0 15.044 4.92 15.044 12.474 0 5.302-4.01 10.049-9.119 10.88v.277C75.317 46.394 80 51.21 80 57.863zM60.521 28.34H49.948v14.934h8.905c6.884 0 10.68-2.772 10.68-7.727 0-4.643-3.264-7.207-9.012-7.207zM49.948 49.2v16.458H60.91c7.167 0 10.964-2.876 10.964-8.281 0-5.406-3.903-8.178-11.425-8.178H49.948z"
                                                fill="currentColor"></path>
                                        </svg>
                                    @endif
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="mb-0 text-start">
                                    @if (!empty($Section_1_content_value['section_footer_text']))
                                        {{ $Section_1_content_value['section_footer_text'] }}
                                    @else
                                        Manage your business efficiently with our all-in-one solution designed for
                                        performance, security, and scalability.
                                    @endif
                                </h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="hero-image">
                            @if (!empty($Section_1_content_value['section_main_image_path']))
                                <img src="{{ asset(Storage::url($Section_1_content_value['section_main_image_path'])) }}"
                                    alt="user-image" class="img-fluid" />
                            @else
                                <img src="assets/images/landing/img-header-main.svg" alt="image"
                                    class="img-fluid img-bg wow fadeInUp" data-wow-delay="0.5s" />
                                <div class="img-widget-1">
                                    <img src="assets/images/landing/img-widget-1.svg" alt="image"
                                        class="img-fluid wow fadeInDown" data-wow-delay="0.6s" />
                                </div>
                                <div class="img-widget-2">
                                    <img src="assets/images/landing/img-widget-2.svg" alt="image"
                                        class="img-fluid wow fadeInDown" data-wow-delay="0.7s" />
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </header>
    @endif
    <!-- [ Header ] End -->
    <!-- [ section ] start -->
    @php
        $Section_2 = App\Models\HomePage::where('section', 'Section 2')->first();
        $Section_2_content_value = !empty($Section_2->content_value)
            ? json_decode($Section_2->content_value, true)
            : [];
    @endphp
    @if (empty($Section_2_content_value['section_enabled']) || $Section_2_content_value['section_enabled'] == 'active')
        <section>
            <div class="container">
                <div class="row g-4">
                    <div class="col-md-6 col-lg-4">
                        <div class="card feature-card mb-0 bg-secondary">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="avtar avtar-l">
                                            <img src="{{ !empty($Section_2_content_value['box_image_1_path']) ? asset(Storage::url($Section_2_content_value['box_image_1_path'])) : 'assets/images/landing/img-feature-1.svg' }}"
                                                alt="img" class="img-fluid" />
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3 text-end">
                                        <span
                                            class="h1 mb-0 d-block fw-semibold">{{ !empty($Section_2_content_value['Box1_number']) ? $Section_2_content_value['Box1_number'] : '500+' }}</span>
                                        <span
                                            class="h5 mb-0 d-block">{{ !empty($Section_2_content_value['Box1_title']) ? $Section_2_content_value['Box1_title'] : 'Customers' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="card feature-card mb-0 bg-blue-200">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="avtar avtar-l">
                                            <img src="{{ !empty($Section_2_content_value['box_image_2_path']) ? asset(Storage::url($Section_2_content_value['box_image_2_path'])) : 'assets/images/landing/img-feature-2.svg' }}"
                                                alt="img" class="img-fluid" />
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3 text-end">
                                        <span
                                            class="h1 mb-0 d-block fw-semibold">{{ !empty($Section_2_content_value['Box2_number']) ? $Section_2_content_value['Box2_number'] : '4+' }}</span>
                                        <span
                                            class="h5 mb-0 d-block">{{ !empty($Section_2_content_value['Box2_title']) ? $Section_2_content_value['Box2_title'] : 'Subscription Plan' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-4">
                        <div class="card feature-card mb-0 bg-purple-200">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="avtar avtar-l">
                                            <img src="{{ !empty($Section_2_content_value['box_image_3_path']) ? asset(Storage::url($Section_2_content_value['box_image_3_path'])) : 'assets/images/landing/img-feature-3.svg' }}"
                                                alt="img" class="img-fluid" />
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3 text-end">
                                        <span
                                            class="h1 mb-0 d-block fw-semibold">{{ !empty($Section_2_content_value['Box3_number']) ? $Section_2_content_value['Box3_number'] : '11+' }}</span>
                                        <span
                                            class="h5 mb-0 d-block">{{ !empty($Section_2_content_value['Box3_title']) ? $Section_2_content_value['Box3_title'] : 'Language' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
    <!-- [ section ] End -->
    <!-- [ section ] start -->
    @php
        $Section_3 = App\Models\HomePage::where('section', 'Section 3')->first();
        $Section_3_content_value = !empty($Section_3->content_value)
            ? json_decode($Section_3->content_value, true)
            : [];
    @endphp
    @if (empty($Section_3_content_value['section_enabled']) || $Section_3_content_value['section_enabled'] == 'active')
        <section class="bg-body">
            <div class="container">
                @for ($is3 = 1; $is3 <= 2; $is3++)
                    <div class="row align-items-center g-4">
                        @if ($is3 % 2 != 0)
                            <div class="col-md-6 text-center mb-md-5">
                                @if (!empty($Section_1_content_value['Box' . $is3 . '_image_path']))
                                    <img src="{{ asset(Storage::url($Section_1_content_value['Box' . $is3 . '_image_path'])) }}"
                                        alt="img" class="img-fluid w-75" />
                                @else
                                    <img src="assets/images/landing/img-customize-1.svg" alt="img"
                                        class="img-fluid w-75" />
                                @endif
                            </div>
                        @endif
                        <div class="col-md-6">
                            <h2 class="h1">
                                {{ !empty($Section_3_content_value['Box' . $is3 . '_title']) ? $Section_3_content_value['Box' . $is3 . '_title'] : 'Empower Your Business to Thrive with Us' }}
                            </h2>
                            <p class="text-lg w-75 my-3 my-md-4">
                                {{ !empty($Section_3_content_value['Box' . $is3 . '_title']) ? $Section_3_content_value['Box' . $is3 . '_info'] : 'Unlock growth, streamline operations, and achieve success with our innovative solutions.' }}
                            </p>
                            <ul class="list-unstyled customize-list">
                                @if (!empty($Section_3_content_value['Box' . $is3 . '_list']))
                                    @foreach ($Section_3_content_value['Box' . $is3 . '_list'] as $box_item)
                                        <li><i class="ti ti-circle-check f-20 text-secondary"></i> {{ $box_item }}
                                        </li>
                                    @endforeach
                                @else
                                    <li>
                                        <i class="ti ti-circle-check f-20 text-secondary"></i>
                                        Simplify and automate your business processes for maximum efficiency.
                                    </li>
                                    <li>
                                        <i class="ti ti-circle-check f-20 text-secondary"></i>
                                        Receive tailored strategies to meet business needs and unlock potential.
                                    </li>
                                    <li>
                                        <i class="ti ti-circle-check f-20 text-secondary"></i>
                                        Grow confidently with flexible solutions that adapt to your business needs.
                                    </li>
                                    <li>
                                        <i class="ti ti-circle-check f-20 text-secondary"></i>
                                        Make smarter decisions with real-time analytics and performance tracking.
                                    </li>
                                    <li>
                                        <i class="ti ti-circle-check f-20 text-secondary"></i>
                                        Rely on 24/7 expert assistance to keep your business running smoothly.
                                    </li>
                                @endif
                            </ul>
                        </div>
                        @if ($is3 % 2 == 0)
                            <div class="col-md-6 text-center mb-md-5">
                                @if (!empty($Section_1_content_value['Box' . $is3 . '_image_path']))
                                    <img src="{{ asset(Storage::url($Section_1_content_value['Box' . $is3 . '_image_path'])) }}"
                                        alt="img" class="img-fluid w-75" />
                                @else
                                    <img src="assets/images/landing/img-customize-2.svg" alt="img"
                                        class="img-fluid w-75" />
                                @endif
                            </div>
                        @endif
                    </div>
                @endfor
            </div>
        </section>
    @endif
    <!-- [ section ] End -->
    <!-- [ section ] start -->
    @php
        $Section_4 = App\Models\HomePage::where('section', 'Section 4')->first();
        $Section_4_content_value = !empty($Section_4->content_value)
            ? json_decode($Section_4->content_value, true)
            : [];
    @endphp
    @if (empty($Section_4_content_value['section_enabled']) || $Section_4_content_value['section_enabled'] == 'active')
        <section>
            <div class="container">
                <div class="row justify-content-center title">
                    <div class="col-md-9 col-lg-6 text-center">
                        <h2 class="h1">
                            {{ !empty($Section_4_content_value['Sec4_title']) ? $Section_4_content_value['Sec4_title'] : 'What does Smartweb offer?' }}
                        </h2>
                        <p class="text-lg">
                            {{ !empty($Section_4_content_value['Sec4_info']) ? $Section_4_content_value['Sec4_info'] : 'Smartweb is a reliable choice for your admin panel needs, offering a wide range of features to easily manage your backend panel' }}
                        </p>
                    </div>
                </div>
                <div class="row g-4 text-center">
                    @php
                        $is4_check = 0;
                    @endphp
                    @for ($is4 = 1; $is4 <= 6; $is4++)
                        @if (
                            !empty($Section_4_content_value['Sec4_box' . $is4 . '_enabled']) &&
                                $Section_4_content_value['Sec4_box' . $is4 . '_enabled'] == 'active')
                            @php
                                $is4_check++;
                            @endphp
                            <div class="col-md-6 col-xl-4">
                                @if (!empty($Section_4_content_value['Sec4_box' . $is4 . '_image_path']))
                                    <img src="{{ asset(Storage::url($Section_4_content_value['Sec4_box' . $is4 . '_image_path'])) }}"
                                        alt="img" class="img-fluid" />
                                @else
                                    <img src="assets/images/landing/img-design-1.svg" alt="img"
                                        class="img-fluid" />
                                @endif
                                <h3 class="my-4 fw-semibold">
                                    {{ !empty($Section_4_content_value['Sec4_box' . $is4 . '_title']) ? $Section_4_content_value['Sec4_box' . $is4 . '_title'] : 'What Our Software Offers' }}
                                </h3>
                                <p>
                                    {{ !empty($Section_4_content_value['Sec4_box' . $is4 . '_info']) ? $Section_4_content_value['Sec4_box' . $is4 . '_info'] : 'Our software provides powerful, scalable solutions designed to streamline your business operations.' }}
                                </p>
                            </div>
                        @endif
                    @endfor

                    @if ($is4_check == 0)
                        <div class="col-md-6 col-xl-4">
                            <img src="assets/images/landing/img-design-1.svg" alt="img" class="img-fluid" />
                            <h3 class="my-4 fw-semibold">User-Friendly Interface</h3>
                            <p>
                                Simplify operations with an intuitive and easy-to-use platform.
                            </p>
                        </div>
                        <div class="col-md-6 col-xl-4">
                            <img src="assets/images/landing/img-design-2.svg" alt="img" class="img-fluid" />
                            <h3 class="my-4 fw-semibold">End-to-End Automation</h3>
                            <p>
                                Automate repetitive tasks to save time and increase efficiency.
                            </p>
                        </div>
                        <div class="col-md-6 col-xl-4">
                            <img src="assets/images/landing/img-design-3.svg" alt="img" class="img-fluid" />
                            <h3 class="my-4 fw-semibold">Customizable Solutions</h3>
                            <p>
                                Tailor features to fit your unique business needs and workflows.
                            </p>
                        </div>
                        <div class="col-md-6 col-xl-4">
                            <img src="assets/images/landing/img-design-4.svg" alt="img" class="img-fluid" />
                            <h3 class="my-4 fw-semibold">Scalable Features</h3>
                            <p>
                                Grow your business with flexible solutions that scale with you.
                            </p>
                        </div>
                        <div class="col-md-6 col-xl-4">
                            <img src="assets/images/landing/img-design-5.svg" alt="img" class="img-fluid" />
                            <h3 class="my-4 fw-semibold">Enhanced Security</h3>
                            <p>
                                Protect your data with advanced encryption and security protocols.
                            </p>
                        </div>
                        <div class="col-md-6 col-xl-4">
                            <img src="assets/images/landing/img-design-6.svg" alt="img" class="img-fluid" />
                            <h3 class="my-4 fw-semibold">Real-Time Analytics</h3>
                            <p>
                                Gain actionable insights with live data tracking and reporting.
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    @endif

    <!-- [ section ] End -->
    @php
        $Section_5 = App\Models\HomePage::where('section', 'Section 5')->first();
        $Section_5_content_value = !empty($Section_5->content_value)
            ? json_decode($Section_5->content_value, true)
            : [];
    @endphp
    @if ($settings['pricing_feature'] == 'on')
        @if (empty($Section_5_content_value['section_enabled']) || $Section_5_content_value['section_enabled'] == 'active')
            <section class="bg-body pricingpricing" id="pricing">
                <div class="container">
                    <div class="row justify-content-center title">
                        <div class="col-md-9 col-lg-6 text-center">
                            <h2 class="h1">
                                {{ !empty($Section_5_content_value['Sec5_title']) ? $Section_5_content_value['Sec5_title'] : 'Flexible Pricing' }}
                            </h2>
                            <p class="text-lg">
                                {{ !empty($Section_5_content_value['Sec5_info']) ? $Section_5_content_value['Sec5_info'] : 'Get started for free, upgrade later in our application.' }}
                            </p>
                        </div>
                    </div>
                    <div class="row text-center justify-content-center">
                        <!-- [ sample-page ] start -->
                        @foreach ($subscriptions as $subscription)
                            <div class="col-md-6 col-lg-4">
                                <div class="card price-card ">
                                    <div class="card-body">
                                        <h2 class="">{{ $subscription->title }}</h2>
                                        <div class="price-price mt-4">
                                            <sup>{{ subscriptionPaymentSettings()['CURRENCY_SYMBOL'] }}</sup>
                                            {{ $subscription->package_amount }}
                                            <span>/{{ $subscription->interval }}</span>
                                        </div>
                                        <ul class="list-group list-group-flush product-list">
                                            <li class="list-group-item enable">{{ __('User Limit') }}
                                                {{ $subscription->user_limit }}</li>
                                            @if ($subscription->enabled_pre_register == 1)
                                                <li class="list-group-item enable">
                                                    {{ __('Enabled Visitor Pre Register') }}
                                                </li>
                                            @else
                                                <li class="list-group-item">{{ __('Disable Visitor Pre Register') }}
                                                </li>
                                            @endif
                                            @if ($subscription->enabled_logged_history)
                                                <li class="list-group-item enable">{{ __('Enabled Logged History') }}
                                                </li>
                                            @else
                                                <li class="list-group-item">{{ __('Disable Logged History') }}</li>
                                            @endif
                                            @if ($subscription->couponCheck() > 0)
                                                <li class="list-group-item enable">
                                                    {{ __('Enabled Coupon Applicable') }}
                                                </li>
                                            @else
                                                <li class="list-group-item">{{ __('Disable Coupon Applicable') }}</li>
                                            @endif
                                        </ul>
                                        <a class="btn btn-outline-primary bg-light text-primary mt-4"
                                            href="{{ route('register') }}" role="button">{{ __('Order Now') }}</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <!-- [ sample-page ] end -->
                    </div>

                </div>
            </section>
        @endif
    @endif
    <!-- [ section ] start -->

    @php
        $Section_6 = App\Models\HomePage::where('section', 'Section 6')->first();
        $Section_6_content_value = !empty($Section_6->content_value)
            ? json_decode($Section_6->content_value, true)
            : [];
    @endphp
    @if (empty($Section_6_content_value['section_enabled']) || $Section_6_content_value['section_enabled'] == 'active')
        <section class="application-slider" id="features">
            <div class="container">
                <div class="row justify-content-center title">
                    <div class="col-md-9 col-lg-6 text-center">
                        <h2 class="h1">
                            {{ !empty($Section_6_content_value['Sec6_title']) ? $Section_6_content_value['Sec6_title'] : 'Explore Concenputal Apps' }}
                        </h2>
                        <p class="text-lg">
                            {{ !empty($Section_6_content_value['Sec6_info']) ? $Section_6_content_value['Sec6_info'] : 'Smartweb has conceptul working apps like Chat, Inbox, E-commerce, Invoice, Kanban, and Calendar' }}
                        </p>
                    </div>
                </div>
                <div class="row text-center justify-content-center">
                    <div class="col-11 col-md-9 col-lg-7 position-relative">
                        <div class="swiper app-slider">
                            <div class="swiper-wrapper">
                                @if (!empty($Section_6_content_value['Sec6_Box_title']))
                                    @foreach ($Section_6_content_value['Sec6_Box_title'] as $s6_key => $s6_item)
                                        <div class="swiper-slide">
                                            @if (!empty($Section_6_content_value['Sec6_box' . $s6_key . '_image_path']))
                                                <img src="{{ asset(Storage::url($Section_6_content_value['Sec6_box' . $s6_key . '_image_path'])) }}"
                                                    alt="img" class="img-fluid" />
                                            @else
                                                <img src="assets/images/landing/slider-light-1.png" alt="images"
                                                    class="img-fluid" />
                                            @endif
                                            <h3> {{ $s6_item }} <i class="ti ti-link"></i> </h3>
                                            <p>{{ $Section_6_content_value['Sec6_Box_subtitle'][$s6_key] }}</p>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="swiper-slide">
                                        <img src="assets/images/landing/slider-light-1.png" alt="images"
                                            class="img-fluid" />
                                        <h3>
                                            Social Profile
                                            <i class="ti ti-link"></i>
                                        </h3>
                                        <p>Complete Social profile with all possible option</p>
                                    </div>
                                    <div class="swiper-slide">
                                        <img src="assets/images/landing/slider-light-2.png" alt="images"
                                            class="img-fluid" />
                                        <h3>
                                            Mail/Message App
                                            <i class="ti ti-link"></i>
                                        </h3>
                                        <p>Complete Mail/Message App with all possible option</p>
                                    </div>
                                    <div class="swiper-slide">
                                        <img src="assets/images/landing/slider-light-3.png" alt="images"
                                            class="img-fluid" />
                                        <h3>
                                            Mail/Message App
                                            <i class="ti ti-link"></i>
                                        </h3>
                                        <p>Complete Chat App with all possible option</p>
                                    </div>
                                    <div class="swiper-slide">
                                        <img src="assets/images/landing/slider-light-4.png" alt="images"
                                            class="img-fluid" />
                                        <h3>
                                            Kanban App
                                            <i class="ti ti-link"></i>
                                        </h3>
                                        <p>Complete Kanban App with all possible option</p>
                                    </div>
                                    <div class="swiper-slide">
                                        <img src="assets/images/landing/slider-light-5.png" alt="images"
                                            class="img-fluid" />
                                        <h3>
                                            Calendar App
                                            <i class="ti ti-link"></i>
                                        </h3>
                                        <p>Complete Calendar App with all possible option</p>
                                    </div>
                                    <div class="swiper-slide">
                                        <img src="assets/images/landing/slider-light-6.png" alt="images"
                                            class="img-fluid" />
                                        <h3>
                                            Ecommerce App
                                            <i class="ti ti-link"></i>
                                        </h3>
                                        <p>Complete Ecommerce App with all possible option</p>
                                    </div>
                                @endif
                            </div>
                            <div class="swiper-button-next avtar">
                                <i class="ti ti-chevron-right"></i>
                            </div>
                            <div class="swiper-button-prev avtar">
                                <i class="ti ti-chevron-left"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
    <!-- [ section ] End -->
    <!-- [ section ] start -->
    @php
        $Section_7 = App\Models\HomePage::where('section', 'Section 7')->first();
        $Section_7_content_value = !empty($Section_7->content_value)
            ? json_decode($Section_7->content_value, true)
            : [];
    @endphp

    @if (empty($Section_7_content_value['section_enabled']) || $Section_7_content_value['section_enabled'] == 'active')
        <section class="bg-body">
            <div class="container">
                <div class="row justify-content-center title">
                    <div class="col-md-9 col-lg-6 text-center">
                        <h2 class="h1">
                            {{ !empty($Section_7_content_value['Sec7_title']) ? $Section_7_content_value['Sec7_title'] : 'Testaments' }}
                        </h2>
                        <p class="text-lg">
                            {{ !empty($Section_7_content_value['Sec7_info']) ? $Section_7_content_value['Sec7_info'] : 'We are so grateful for your positive review and appreciate your support of our product' }}
                        </p>
                    </div>
                </div>
                <div class="testaments-cards">
                    @php
                        $is7_check = 0;
                    @endphp
                    @for ($is7 = 1; $is7 <= 8; $is7++)
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="flex-shrink-0">
                                        <div class="avtar avtar-l">
                                            @if (!empty($Section_7_content_value['Sec7_box' . $is7 . '_image_path']))
                                                <img src="{{ asset(Storage::url($Section_7_content_value['Sec7_box' . $is7 . '_image_path'])) }}"
                                                    alt="img" class="img-fluid rounded-circle wid-40" />
                                            @else
                                                <img src="assets/images/user/avatar-1.jpg" alt="img"
                                                    class="img-fluid rounded-circle wid-40" />
                                            @endif
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-2">
                                        <h4 class="mb-0">
                                            {{ !empty($Section_7_content_value['Sec7_box' . $is7 . '_name']) ? $Section_7_content_value['Sec7_box' . $is7 . '_name'] : 'Lenore Becker' }}
                                        </h4>
                                        <h6 class="mb-0 text-primary">
                                            {{ !empty($Section_7_content_value['Sec7_box' . $is7 . '_tag']) ? $Section_7_content_value['Sec7_box' . $is7 . '_tag'] : '' }}
                                        </h6>
                                    </div>
                                </div>
                                <p class="mb-0">
                                    {{ !empty($Section_7_content_value['Sec7_box' . $is7 . '_review'])
                                        ? $Section_7_content_value['Sec7_box' . $is7 . '_review']
                                        : 'Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Vestibulum rutrum, mi nec elementum vehicula, eros quam gravida nisl, id fringilla neque ante vel mi. Quisque ut nisi. Nulla porta dolor. Aenean tellus metus, bibendum sed, posuere ac, mattis non, nunc.' }}
                                </p>
                            </div>
                        </div>
                    @endfor
                </div>

            </div>
        </section>
    @endif
    <!-- [ section ] End -->
    <!-- [ section ] start -->
    @php
        $Section_8 = App\Models\HomePage::where('section', 'Section 8')->first();
        $Section_8_content_value = !empty($Section_8->content_value)
            ? json_decode($Section_8->content_value, true)
            : [];
    @endphp
    @if (empty($Section_8_content_value['section_enabled']) || $Section_8_content_value['section_enabled'] == 'active')
        <section class="bg-dark choose-section">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-9">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <h2 class="mb-0 text-white">
                                    {{ !empty($Section_8_content_value['Sec8_title']) ? $Section_8_content_value['Sec8_title'] : 'Choose Smartweb for' }}
                                </h2>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="swiper choose-slider">
                                    <div class="swiper-wrapper">
                                        @for ($is8 = 1; $is8 <= 8; $is8++)
                                            <div class="swiper-slide">
                                                <h2>{{ !empty($Section_8_content_value['Sec8_box' . $is8 . '_info']) ? $Section_8_content_value['Sec8_box' . $is8 . '_info'] : 'Highly Responsive' }}
                                                </h2>
                                            </div>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 d-none d-md-block">
                        <img src="assets/images/landing/img-bg-hand.png" alt="img" class="img-fluid hand-img" />
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- [ section ] End -->
    <!-- [ section ] start -->
    @php
        $Section_9 = App\Models\HomePage::where('section', 'Section 9')->first();
        $Section_9_content_value = !empty($Section_9->content_value)
            ? json_decode($Section_9->content_value, true)
            : [];
    @endphp
    @if (empty($Section_9_content_value['section_enabled']) || $Section_9_content_value['section_enabled'] == 'active')
        <section class="frameworks-section" id="faqs">
            <div class="container">
                <div class="row justify-content-center title">
                    <div class="col-md-9 col-lg-6 text-center">
                        <h2 class="h1">
                            {{ !empty($Section_9_content_value['Sec9_title']) ? $Section_9_content_value['Sec9_title'] : 'Frequently Asked Questions (FAQ)' }}
                        </h2>
                        <p class="text-lg">
                            {{ !empty($Section_9_content_value['Sec9_info']) ? $Section_9_content_value['Sec9_info'] : 'Please refer the Frequently ask question for your quick help' }}
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="accordion accordion-flush" id="accordionFlushExample">
                            @if (!empty($FAQs->toArray()))
                                @foreach ($FAQs as $FAQ_key => $FAQ)
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="flush-{{ $FAQ->id }}">
                                            <button
                                                class="accordion-button {{ $FAQ_key == 0 ? '' : 'collapsed' }} text-muted"
                                                type="button" data-bs-toggle="collapse"
                                                data-bs-target="#flush-collapse-{{ $FAQ->id }}"
                                                aria-expanded="false" aria-controls="flush-collapseThree">
                                                <b>{{ $FAQ->question }}</b>
                                            </button>
                                        </h2>
                                        <div id="flush-collapse-{{ $FAQ->id }}"
                                            class="accordion-collapse collapse {{ $FAQ_key == 0 ? 'collapse show' : '' }}"
                                            aria-labelledby="flush-{{ $FAQ->id }}"
                                            data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body text-muted">{!! $FAQ->description !!}</div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="flush-headingOne">
                                        <button class="accordion-button text-muted" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#flush-collapseOne"
                                            aria-expanded="false">
                                            <b>What features does your software offer?</b>
                                        </button>
                                    </h2>
                                    <div id="flush-collapseOne" class="accordion-collapse collapse show"
                                        aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body text-muted">
                                            Our software provides a range of features including automation tools,
                                            real-time analytics, cloud-based access, secure data storage, seamless
                                            integrations, and customizable solutions tailored to your business needs.
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="flush-headingTwo">
                                        <button class="accordion-button collapsed text-muted" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo"
                                            aria-expanded="false" aria-controls="flush-collapseTwo">
                                            <b>Is your software easy to use?</b>
                                        </button>
                                    </h2>
                                    <div id="flush-collapseTwo" class="accordion-collapse collapse"
                                        aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body text-muted">
                                            Yes! Our platform is designed to be user-friendly and intuitive, so your
                                            team can get started quickly without a steep learning curve.
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="flush-headingThree">
                                        <button class="accordion-button collapsed text-muted" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#flush-collapseThree"
                                            aria-expanded="false" aria-controls="flush-collapseThree">
                                            <b>Can I integrate your software with my existing systems?</b>
                                        </button>
                                    </h2>
                                    <div id="flush-collapseThree" class="accordion-collapse collapse"
                                        aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body text-muted">
                                            Absolutely! Our software is built to easily integrate with your current
                                            tools and systems, making the transition seamless and efficient.
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="flush-headingfour">
                                        <button class="accordion-button collapsed text-muted" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#flush-collapse-four"
                                            aria-expanded="false" aria-controls="flush-collapseThree">
                                            <b>Is customer support available?</b>
                                        </button>
                                    </h2>
                                    <div id="flush-collapse-four" class="accordion-collapse collapse"
                                        aria-labelledby="flush-headingfour" data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body text-muted">
                                            Yes! We offer 24/7 customer support. Our dedicated team is ready to assist
                                            you with any questions or issues you may have.
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
    <!-- [ section ] End -->
    <!-- [ footer ] start -->
    <footer class="bg-dark footer">
        @php
            $Section_10 = App\Models\HomePage::where('section', 'Section 10')->first();
            $Section_10_content_value = !empty($Section_10->content_value)
                ? json_decode($Section_10->content_value, true)
                : [];
        @endphp
        @if (empty($Section_10_content_value['section_enabled']) || $Section_10_content_value['section_enabled'] == 'active')
            <div class="container">
                <div class="row">
                    <div class="col-md-4 wow fadeInUp" data-wow-delay="0.2s">
                        <div class="landing-logo">
                            <img src="{{ asset(Storage::url('upload/logo/light_logo.png')) }}" alt="image"
                                class="img-fluid" />
                        </div>
                        <h4 class="my-3 text-white">
                            {{ !empty($Section_10_content_value['Sec10_title']) ? $Section_10_content_value['Sec10_title'] : 'About Smart Tenant' }}
                        </h4>
                        <p class="mb-4 text-white text-opacity-75">
                            {!! !empty($Section_10_content_value['Sec10_info'])
                                ? $Section_10_content_value['Sec10_info']
                                : 'Property management refers to the administration, operation, and oversight of real estate properties on behalf of property owners. It involves various tasks such as marketing rental properties, finding tenants, collecting rent and ensuring legal compliance.' !!}
                        </p>
                    </div>
                    <div class="col-md-8">
                        <div class="row g-4">
                            @php
                                $footer_col = 0;
                                if ($settings['footer_column_1_enabled'] == 'active') {
                                    $footer_col = 12;
                                }
                                if ($settings['footer_column_2_enabled'] == 'active') {
                                    $footer_col = 6;
                                }
                                if ($settings['footer_column_3_enabled'] == 'active') {
                                    $footer_col = 4;
                                }
                                if ($settings['footer_column_4_enabled'] == 'active') {
                                    $footer_col = 3;
                                }
                            @endphp
                            @if ($footer_col > 0)
                                @if ($settings['footer_column_1_enabled'] == 'active')
                                    <div class="col-6 col-md-{{ $footer_col }} wow fadeInUp"
                                        data-wow-delay="0.6s">
                                        <h5 class="mb-3 mb-sm-4 text-white">{{ $settings['footer_column_1'] }}</h5>
                                        @php
                                            $active_footer_menu1 = !empty($settings['footer_column_1_pages'])
                                                ? json_decode($settings['footer_column_1_pages'], true)
                                                : [];
                                        @endphp
                                        <ul class="list-unstyled footer-link">
                                            @if (!empty($active_footer_menu1))
                                                @foreach ($menus as $menu)
                                                    @if (in_array($menu->id, $active_footer_menu1))
                                                        <li>
                                                            <a target="_blank"
                                                                href="{{ route('page', $menu->slug) }}">{{ $menu->title }}</a>
                                                        </li>
                                                    @endif
                                                @endforeach
                                            @else
                                                <li><a href="#" target="_blank">Blog</a></li>
                                                <li><a href="#" target="_blank">Documentation</a></li>
                                                <li><a href="#" target="_blank">ChangeLog</a></li>
                                                <li><a href="#" target="_blank">Support</a></li>
                                            @endif
                                        </ul>
                                    </div>
                                @endif
                                @if ($settings['footer_column_2_enabled'] == 'active')
                                    <div class="col-6 col-md-{{ $footer_col }} wow fadeInUp"
                                        data-wow-delay="0.6s">
                                        <h5 class="mb-3 mb-sm-4 text-white">{{ $settings['footer_column_2'] }}</h5>
                                        @php
                                            $active_footer_menu2 = !empty($settings['footer_column_2_pages'])
                                                ? json_decode($settings['footer_column_2_pages'], true)
                                                : [];
                                        @endphp
                                        <ul class="list-unstyled footer-link">
                                            @if (!empty($active_footer_menu2))
                                                @foreach ($menus as $menu)
                                                    @if (in_array($menu->id, $active_footer_menu2))
                                                        <li>
                                                            <a target="_blank"
                                                                href="{{ route('page', $menu->slug) }}">{{ $menu->title }}</a>
                                                        </li>
                                                    @endif
                                                @endforeach
                                            @else
                                                <li><a href="#" target="_blank">Blog</a></li>
                                                <li><a href="#" target="_blank">Documentation</a></li>
                                                <li><a href="#" target="_blank">ChangeLog</a></li>
                                                <li><a href="#" target="_blank">Support</a></li>
                                            @endif
                                        </ul>
                                    </div>
                                @endif
                                @if ($settings['footer_column_3_enabled'] == 'active')
                                    <div class="col-6 col-md-{{ $footer_col }} wow fadeInUp"
                                        data-wow-delay="0.6s">
                                        <h5 class="mb-3 mb-sm-4 text-white">{{ $settings['footer_column_3'] }}</h5>
                                        @php
                                            $active_footer_menu3 = !empty($settings['footer_column_3_pages'])
                                                ? json_decode($settings['footer_column_3_pages'], true)
                                                : [];
                                        @endphp
                                        <ul class="list-unstyled footer-link">
                                            @if (!empty($active_footer_menu3))
                                                @foreach ($menus as $menu)
                                                    @if (in_array($menu->id, $active_footer_menu3))
                                                        <li>
                                                            <a target="_blank"
                                                                href="{{ route('page', $menu->slug) }}">{{ $menu->title }}</a>
                                                        </li>
                                                    @endif
                                                @endforeach
                                            @else
                                                <li><a href="#" target="_blank">Blog</a></li>
                                                <li><a href="#" target="_blank">Documentation</a></li>
                                                <li><a href="#" target="_blank">ChangeLog</a></li>
                                                <li><a href="#" target="_blank">Support</a></li>
                                            @endif
                                        </ul>
                                    </div>
                                @endif
                                @if ($settings['footer_column_4_enabled'] == 'active')
                                    <div class="col-6 col-md-{{ $footer_col }} wow fadeInUp"
                                        data-wow-delay="0.6s">
                                        <h5 class="mb-3 mb-sm-4 text-white">{{ $settings['footer_column_4'] }}</h5>
                                        @php
                                            $active_footer_menu4 = !empty($settings['footer_column_4_pages'])
                                                ? json_decode($settings['footer_column_4_pages'], true)
                                                : [];
                                        @endphp
                                        <ul class="list-unstyled footer-link">
                                            @if (!empty($active_footer_menu4))
                                                @foreach ($menus as $menu)
                                                    @if (in_array($menu->id, $active_footer_menu4))
                                                        <li>
                                                            <a target="_blank"
                                                                href="{{ route('page', $menu->slug) }}">{{ $menu->title }}</a>
                                                        </li>
                                                    @endif
                                                @endforeach
                                            @else
                                                <li><a href="#" target="_blank">Blog</a></li>
                                                <li><a href="#" target="_blank">Documentation</a></li>
                                                <li><a href="#" target="_blank">ChangeLog</a></li>
                                                <li><a href="#" target="_blank">Support</a></li>
                                            @endif
                                        </ul>
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="sub-footer">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col my-1 wow fadeInUp" data-wow-delay="0.4s">
                        <p class="mb-0 text-white text-opacity-75">
                            {{ __('Copyright') }} {{ date('Y') }} {{ env('APP_NAME') }}
                        </p>
                    </div>
                    <div class="col-auto my-1">
                        <ul class="list-inline footer-sos-link mb-0">
                            <li class="list-inline-item wow fadeInUp" data-wow-delay="0.4s">
                                <a href="#" class="link-primary">
                                    <svg class="pc-icon">
                                        <use xlink:href="#custom-facebook"></use>
                                    </svg>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- [ footer ] End -->
    <!-- Required Js -->
    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/fonts/custom-font.js') }}"></script>
    <script src="{{ asset('assets/js/pcoded.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/feather.min.js') }}"></script>

    <script>
        font_change('Roboto');
    </script>

    <!-- [Page Specific JS] start -->
    <script src="{{ asset('assets/js/plugins/wow.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/swiper-bundle.js') }}"></script>
    <script>
        // Start [ Menu hide/show on scroll ]
        let ost = 0;
        document.addEventListener('scroll', function() {
            let cOst = document.documentElement.scrollTop;
            if (cOst == 0) {
                document.querySelector('.navbar').classList.add('top-nav-collapse');
            } else if (cOst > ost) {
                document.querySelector('.navbar').classList.add('top-nav-collapse');
                document.querySelector('.navbar').classList.remove('default');
            } else {
                document.querySelector('.navbar').classList.add('default');
                document.querySelector('.navbar').classList.remove('top-nav-collapse');
            }
            ost = cOst;
        });
        // End [ Menu hide/show on scroll ]
        var wow = new WOW({
            animateClass: 'animated'
        });
        wow.init();
        const app_Swiper = new Swiper('.app-slider', {
            loop: true,
            slidesPerView: '1.2',
            centeredSlides: true,
            spaceBetween: 20,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev'
            }
        });
        const choose_Swiper = new Swiper('.choose-slider', {
            direction: 'vertical',
            loop: true,
            centeredSlides: true,
            slidesPerView: '4',
            autoplay: {
                delay: 2500,
                disableOnInteraction: false
            }
        });
        const frameworks_Swiper = new Swiper('.frameworks-slider', {
            loop: true,
            centeredSlides: true,
            spaceBetween: 24,
            slidesPerView: 2,
            pagination: {
                el: '.swiper-pagination',
                dynamicBullets: true,
                clickable: true
            },
            breakpoints: {
                640: {
                    slidesPerView: 2
                },
                768: {
                    slidesPerView: 4
                },
                1024: {
                    slidesPerView: 5
                }
            }
        });
    </script>
    <!-- [Page Specific JS] end -->
</body>

</html>

@php
    $routeName = \Request::route()->getName();
    $routeParameters = request()->route()->parameters;
    $settings = settings();
    $user = \App\Models\User::find(1);
    \App::setLocale($user->lang);
    $menus = \App\Models\Page::where('enabled', 1)->get();
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
    <style>
        .ck.ck-reset_all {
            display: none;
        }

        .ck .ck-widget:hover {
            outline-color: transparent;
        }

        .ck.ck-editor__main>.ck-editor__editable:not(.ck-focused) {
            border: 0;
            border-color: transparent;
            outline: 0;
        }

        .ck.ck-editor__main:focus-visible,
        .ck .ck-widget:hover {
            outline-color: transparent !important;
        }
    </style>
</head>

<body class="landing-page" data-pc-preset="{{ !empty($settings['color_type']) && $settings['color_type'] == 'custom' ? 'custom' : $settings['accent_color'] }}" data-pc-sidebar-theme="light"
    data-pc-sidebar-caption="{{ $settings['sidebar_caption'] }}" data-pc-direction="{{ $settings['theme_layout'] }}"
    data-pc-theme="{{ $settings['theme_mode'] }}">

    <!-- [ Pre-loader ] start -->
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>
    <!-- [ Pre-loader ] End -->

    <!-- [ Main Content ] start -->
    <nav class="navbar navbar-expand-lg navbar-light card rounded-0 fixed-top">
        <div class="container">
            <a class="navbar-brand landing-logo" href="{{ route('home') }}">
                <img src="{{ asset(Storage::url('upload/logo/logo.png')) }}" alt="logo" class="img-fluid " />
                {{-- <img src="{{ asset(Storage::url('upload/logo/logo.png')) }}"  alt="image" class="img-fluid brand-logo" /> --}}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto f-w-600">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">{{ __('Home') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}#pricing">{{ __('Pricing') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link me-2" href="{{ route('home') }}#features">{{ __('Features') }}</a>
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
                                   <a class="nav-link me-2 {{ !empty($routeParameters['slug']) && $menu->slug == $routeParameters['slug'] ? 'active' : '' }}"
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
    <div class="front-header-image">
        <div class="bg-img-overlay" style="background-image: url('../assets/images/pages/header-bg.jpg')"></div>
        <div class="privacy-details">
            <h1 class="text-center text-white pt-5 f-46">{{ $page->title }}</h1>
            <p class="text-center text-white pt-3 f-16">{{ __('Last updated on') }}
                {{ dateFormat($page->updated_at) }}</p>
        </div>
        <div class="container">
            <div class="row justify-content-center mt-5">
                <div class="col-sm-12">
                    <div class="card border">
                        <div class="card-body">
                            {!! $page->content !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- [ Main Content ] end -->

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
    <script src="{{ asset('assets/js/plugins/ckeditor/classic/ckeditor.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
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

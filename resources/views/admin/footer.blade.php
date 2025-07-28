@php
    $DefaultCustomPage = DefaultCustomPage();
    $admin_logo = getSettingsValByName('company_logo');
    $lightLogo = getSettingsValByName('light_logo');
@endphp
<footer class="pc-footer">
    <div class="footer-wrapper container-fluid">
        <div class="row">
            <div class="col-sm-6 my-1">
                <p class="m-0">
                    {{ __('Copyright') }} {{ date('Y') }} © {{ env('APP_NAME') }} {{ __('All rights reserved') }}.
                </p>
            </div>
            <div class="col-sm-6 ms-auto my-1">
                <ul class="list-inline footer-link mb-0 justify-content-sm-end d-flex">
                    @foreach ($DefaultCustomPage as $item)
                        <li class="list-inline-item"><a href="{{ route('page', $item->slug) }}" target="_blank">{{ $item->title }}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</footer>
<script src="{{ asset('js/jquery.js') }}"></script>
<!-- Required Js -->
<script src="{{ asset('assets/js/plugins/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/simplebar.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/fonts/custom-font.js') }}"></script>
<script>
    var lightLogo="{{ asset(Storage::url('upload/logo')).'/'.$lightLogo }}";
    var logo="{{ asset(Storage::url('upload/logo')).'/'.$admin_logo }}";
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

<!-- [Page Specific JS] end -->
<form method="post" action="{{ route('theme.settings') }}">
    {{ csrf_field() }}
    <input type="hidden" name="theme_mode" id="theme_mode" value="{{ $settings['theme_mode'] }}">
    <input type="hidden" name="layout_font" id="layout_font" value="{{ $settings['layout_font'] }}">
    <input type="hidden" name="accent_color" id="accent_color" value="{{ $settings['accent_color'] }}">
    <input type="hidden" name="sidebar_caption" id="sidebar_caption" value="{{ $settings['sidebar_caption'] }}">
    <input type="hidden" name="theme_layout" id="theme_layout" value="{{ $settings['theme_layout'] }}">
    <input type="hidden" name="layout_width" id="layout_width" value="{{ $settings['layout_width'] }}">

    <input type="hidden" name="custom_color" id="custom_color" value="{{ $settings['custom_color'] }}">
<input type="hidden" name="custom_color_code" id="custom_color_code" value="{{ $settings['custom_color_code'] }}">
<input type="hidden" name="color_type" id="color_type" value="{{ $settings['color_type'] ?? 'preset' }}">


    <div class="offcanvas border-0 pct-offcanvas offcanvas-end" tabindex="-1" id="offcanvas_pc_layout">
        <div class="offcanvas-header justify-content-between">
            <h5 class="offcanvas-title">{{ __('Theme Settings') }}</h5>
            <div class="d-inline-flex align-items-center gap-2">

                <a type="button" class="avtar avtar-s btn-link-danger btn-pc-default" data-bs-dismiss="offcanvas"
                    aria-label="Close">
                    <i class="ti ti-x f-20"></i>
                </a>
            </div>
        </div>
        <ul class="nav nav-tabs nav-fill pct-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation" data-bs-toggle="tooltip" title="Layout Settings">
                <button class="nav-link active" id="pct-1-tab" data-bs-toggle="tab" data-bs-target="#pct-1-tab-pane"
                    type="button" role="tab" aria-controls="pct-1-tab-pane" aria-selected="true">
                    <i class="ti ti-color-swatch"></i>
                </button>
            </li>
            <li class="nav-item" role="presentation" data-bs-toggle="tooltip" title="Font Settings">
                <button class="nav-link" id="pct-2-tab" data-bs-toggle="tab" data-bs-target="#pct-2-tab-pane"
                    type="button" role="tab" aria-controls="pct-2-tab-pane" aria-selected="false">
                    <i class="ti ti-typography"></i>
                </button>
            </li>
        </ul>
        <div class="pct-body customizer-body">
            <div class="offcanvas-body p-0">
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="pct-1-tab-pane" role="tabpanel"
                        aria-labelledby="pct-1-tab" tabindex="0">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <div class="pc-dark">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1 me-3">
                                            <h5 class="mb-1">{{ __('Theme Mode') }}</h5>
                                            <p class="text-muted text-sm mb-0">{{ __('Light / Dark / System') }}</p>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <div class="row g-2 theme-color theme-layout">
                                                <div class="col-4">
                                                    <div class="d-grid">
                                                        <button type="button"
                                                            class="preset-btn btn {{ $settings['theme_mode'] == 'light' ? 'active' : '' }}"
                                                            data-value="true" onclick="layout_change('light');"
                                                            data-bs-toggle="tooltip" title="Light">
                                                            <span class="pc-lay-icon">
                                                                <span></span>
                                                                <span></span>
                                                                <span></span>
                                                                <span></span>
                                                            </span>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="d-grid">
                                                        <button type="button"
                                                            class="preset-btn btn {{ $settings['theme_mode'] == 'dark' ? 'active' : '' }}"
                                                            data-value="false" onclick="layout_change('dark');"
                                                            data-bs-toggle="tooltip" title="Dark">
                                                            <span class="pc-lay-icon">
                                                                <span></span>
                                                                <span></span>
                                                                <span></span>
                                                                <span></span>
                                                            </span>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="d-grid">
                                                        <button type="button" class="preset-btn btn "
                                                            data-value="default" onclick="layout_change_default();"
                                                            data-bs-toggle="tooltip"
                                                            title="{{ __("Automatically sets the theme based on user's operating system's color scheme.") }}">
                                                            <span
                                                                class="pc-lay-icon d-flex align-items-center justify-content-center">
                                                                <i class="ph-duotone ph-cpu"></i>
                                                            </span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <h5 class="mb-1">{{ __('Accent color') }}</h5>
                                <p class="text-muted text-sm mb-2">{{ __('Choose your primary theme color') }}</p>
                                <div class="theme-color preset-color">
                                    <a href="#!"  data-color-type="preset"
                                        data-value="preset-1"
                                        class="color_type {{ $settings['color_type'] == 'preset' && $settings['accent_color'] == 'preset-1' ? 'active' : '' }}"><i
                                            class="ti ti-check"></i></a>
                                    <a href="#!"  data-color-type="preset"
                                        data-value="preset-2"
                                        class="color_type {{ $settings['color_type'] == 'preset' && $settings['accent_color'] == 'preset-2' ? 'active' : '' }}"><i
                                            class="ti ti-check"></i></a>
                                    <a href="#!"  data-color-type="preset"
                                        data-value="preset-3"
                                        class="color_type {{ $settings['color_type'] == 'preset' && $settings['accent_color'] == 'preset-3' ? 'active' : '' }}"><i
                                            class="ti ti-check"></i></a>
                                    <a href="#!"  data-color-type="preset"
                                        data-value="preset-4"
                                        class="color_type {{ $settings['color_type'] == 'preset' && $settings['accent_color'] == 'preset-4' ? 'active' : '' }}"><i
                                            class="ti ti-check"></i></a>
                                    <a href="#!"  data-color-type="preset"
                                        data-value="preset-5"
                                        class="color_type {{ $settings['color_type'] == 'preset' && $settings['accent_color'] == 'preset-5' ? 'active' : '' }}"><i
                                            class="ti ti-check"></i></a>
                                    <a href="#!"  data-color-type="preset"
                                        data-value="preset-6"
                                        class="color_type {{ $settings['color_type'] == 'preset' && $settings['accent_color'] == 'preset-6' ? 'active' : '' }}"><i
                                            class="ti ti-check"></i></a>
                                   <input class="color_type cutom_colorr {{ $settings['color_type'] == 'custom' ? 'active' : ''  }}" data-color-type="custom" data-value="preset-8"
                                        value="{{ $settings['custom_color'] }}" id="colorChange" type="color" style="border-color: {{ $settings['custom_color_code'] }}; padding:0">
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 me-3">
                                        <h5 class="mb-1">{{ __('Sidebar Caption') }}</h5>
                                        <p class="text-muted text-sm mb-0">{{ __('Caption Hide / Show') }}</p>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <div class="row g-2 theme-color theme-nav-caption">
                                            <div class="col-6">
                                                <div class="d-grid">
                                                    <button type="button"
                                                        class="preset-btn btn {{ $settings['sidebar_caption'] == 'true' ? 'active' : '' }}"
                                                        data-value="true" onclick="layout_caption_change('true');"
                                                        data-bs-toggle="tooltip" title="Caption Show">
                                                        <span class="pc-lay-icon">
                                                            <span></span>
                                                            <span></span>
                                                            <span>
                                                                <span></span>
                                                                <span></span>
                                                            </span>
                                                            <span></span>
                                                        </span>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="d-grid">
                                                    <button type="button"
                                                        class="preset-btn btn {{ $settings['sidebar_caption'] == 'false' ? 'active' : '' }}"
                                                        data-value="false" onclick="layout_caption_change('false');"
                                                        data-bs-toggle="tooltip" title="Caption Hide">
                                                        <span class="pc-lay-icon">
                                                            <span></span>
                                                            <span></span>
                                                            <span>
                                                                <span></span>
                                                                <span></span>
                                                            </span>
                                                            <span></span>
                                                        </span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="pc-rtl">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1 me-3">
                                            <h5 class="mb-1">{{ __('Theme Layout') }}</h5>
                                            <p class="text-muted text-sm">{{ __('LTR/RTL') }}</p>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <div class="row g-2 theme-color theme-direction">
                                                <div class="col-6">
                                                    <div class="d-grid">
                                                        <button type="button"
                                                            class="preset-btn btn {{ $settings['theme_layout'] == 'ltr' ? 'active' : '' }}"
                                                            data-value="false" onclick="layout_rtl_change('false');"
                                                            data-bs-toggle="tooltip" title="LTR">
                                                            <span class="pc-lay-icon">
                                                                <span></span>
                                                                <span></span>
                                                                <span></span>
                                                                <span></span>
                                                            </span>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="d-grid">
                                                        <button type="button"
                                                            class="preset-btn btn {{ $settings['theme_layout'] == 'rtl' ? 'active' : '' }}"
                                                            data-value="true" onclick="layout_rtl_change('true');"
                                                            data-bs-toggle="tooltip" title="RTL">
                                                            <span class="pc-lay-icon">
                                                                <span></span>
                                                                <span></span>
                                                                <span></span>
                                                                <span></span>
                                                            </span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="pc-container-width">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1 me-3">
                                            <h5 class="mb-1">{{ __('Layout Width') }}</h5>
                                            <p class="text-muted text-sm">{{ __('Full / Fixed width') }}</p>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <div class="row g-2 theme-color theme-container">
                                                <div class="col-6">
                                                    <div class="d-grid">
                                                        <button type="button"
                                                            class="preset-btn btn {{ $settings['layout_width'] == 'false' ? 'active' : '' }}"
                                                            data-value="false" onclick="change_box_container('false')"
                                                            data-bs-toggle="tooltip" title="Full Width">
                                                            <span class="pc-lay-icon">
                                                                <span></span>
                                                                <span></span>
                                                                <span></span>
                                                                <span><span></span></span>
                                                            </span>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="d-grid">
                                                        <button type="button"
                                                            class="preset-btn btn {{ $settings['layout_width'] == 'true' ? 'active' : '' }}"
                                                            data-value="true" onclick="change_box_container('true')"
                                                            data-bs-toggle="tooltip" title="Fixed Width">
                                                            <span class="pc-lay-icon">
                                                                <span></span>
                                                                <span></span>
                                                                <span></span>
                                                                <span>
                                                                    <span></span>
                                                                </span>
                                                            </span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-pane fade" id="pct-2-tab-pane" role="tabpanel" aria-labelledby="pct-2-tab"
                        tabindex="0">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <h5 class="mb-1">{{ __('Font Style') }}</h5>
                                <p class="text-muted text-sm">{{ __('Choose theme font') }}</p>
                                <div class="theme-color theme-font-style">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="layout_font"
                                            id="layoutfontRoboto"
                                            {{ $settings['layout_font'] == 'Roboto' ? 'checked' : '' }} value="Roboto"
                                            onclick="font_change('Roboto')" />
                                        <label class="form-check-label"
                                            for="layoutfontRoboto">{{ __('Roboto') }}</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="layout_font"
                                            id="layoutfontPoppins"
                                            {{ $settings['layout_font'] == 'Poppins' ? 'checked' : '' }} value="Poppins"
                                            onclick="font_change('Poppins')" />
                                        <label class="form-check-label"
                                            for="layoutfontPoppins">{{ __('Poppins') }}</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="layout_font"
                                            id="layoutfontInter" {{ $settings['layout_font'] == 'Inter' ? 'checked' : '' }}
                                            value="Inter" onclick="font_change('Inter')" />
                                        <label class="form-check-label"
                                            for="layoutfontInter">{{ __('Inter') }}</label>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
            <div class="d-grid">
                <button class="btn btn-secondary">{{ __('Save Settings') }}</button>
            </div>
        </div>
    </div>
</form>

@stack('script-page')


<script>
    $(document).on('click', ".copy_register_link", function() {
        let linkToCopy = $(this).data('url');

        var linkTextArea = document.createElement('textarea');
        linkTextArea.value = linkToCopy;

        document.body.appendChild(linkTextArea);
        linkTextArea.select();
        document.execCommand('copy');
        document.body.removeChild(linkTextArea);

        toastrs('Success', '{!! __('Visitor pre register link copied to the clipboard.') !!}', 'success')
    });
</script>


<script>
    var successImg='{{ asset("assets/images/notification/ok-48.png") }}';
    var errorImg='{{ asset("assets/images/notification/high_priority-48.png") }}';
    var custom_color='{{ asset("assets/css/custom-color.css") }}';
    		var style_preset='{{ asset("assets/css/style-preset.css") }}';
</script>
<script src="{{ asset('js/custom.js') }}"></script>
<script src="{{ asset('js/theme-color.js') }}"></script>
@if ($statusMessage = Session::get('success'))
    <script>
        notifier.show('Success!', '{!! $statusMessage !!}', 'success',
        successImg, 4000);
    </script>
@endif
@if ($statusMessage = Session::get('error'))
    <script>
         notifier.show('Error!', '{!! $statusMessage !!}', 'error',
         errorImg, 4000);
    </script>
@endif

<?php
    $DefaultCustomPage = DefaultCustomPage();
    $admin_logo = getSettingsValByName('company_logo');
    $lightLogo = getSettingsValByName('light_logo');
?>
<footer class="pc-footer">
    <div class="footer-wrapper container-fluid">
        <div class="row">
            <div class="col-sm-6 my-1">
                <p class="m-0">
                    <?php echo e(__('Copyright')); ?> <?php echo e(date('Y')); ?> © <?php echo e(env('APP_NAME')); ?> <?php echo e(__('All rights reserved')); ?>.
                </p>
            </div>
            <div class="col-sm-6 ms-auto my-1">
                <ul class="list-inline footer-link mb-0 justify-content-sm-end d-flex">
                    <?php $__currentLoopData = $DefaultCustomPage; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="list-inline-item"><a href="<?php echo e(route('page', $item->slug)); ?>" target="_blank"><?php echo e($item->title); ?></a></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        </div>
    </div>
</footer>
<script src="<?php echo e(asset('js/jquery.js')); ?>"></script>
<!-- Required Js -->
<script src="<?php echo e(asset('assets/js/plugins/popper.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/plugins/simplebar.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/plugins/bootstrap.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/fonts/custom-font.js')); ?>"></script>
<script>
    var lightLogo="<?php echo e(asset(Storage::url('upload/logo')).'/'.$lightLogo); ?>";
    var logo="<?php echo e(asset(Storage::url('upload/logo')).'/'.$admin_logo); ?>";
</script>
<script src="<?php echo e(asset('assets/js/pcoded.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/plugins/feather.min.js')); ?>"></script>


<!-- datatable Js -->
<script src="<?php echo e(asset('assets/js/plugins/dataTables.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/plugins/dataTables.bootstrap5.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/plugins/buttons.colVis.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/plugins/buttons.print.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/plugins/pdfmake.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/plugins/jszip.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/plugins/dataTables.buttons.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/plugins/vfs_fonts.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/plugins/buttons.html5.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/plugins/buttons.bootstrap5.min.js')); ?>"></script>
<script>
    font_change("<?php echo e($settings['layout_font']); ?>");
</script>

<script>
    change_box_container("<?php echo e($settings['layout_width']); ?>");
</script>


<!-- [Page Specific JS] start -->
<!-- bootstrap-datepicker -->
<script src="<?php echo e(asset('assets/js/plugins/datepicker-full.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/plugins/apexcharts.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/plugins/peity-vanilla.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/plugins/sweetalert2.all.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/plugins/notifier.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/plugins/choices.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/plugins/ckeditor/classic/ckeditor.js')); ?>"></script>

<!-- [Page Specific JS] end -->
<form method="post" action="<?php echo e(route('theme.settings')); ?>">
    <?php echo e(csrf_field()); ?>

    <input type="hidden" name="theme_mode" id="theme_mode" value="<?php echo e($settings['theme_mode']); ?>">
    <input type="hidden" name="layout_font" id="layout_font" value="<?php echo e($settings['layout_font']); ?>">
    <input type="hidden" name="accent_color" id="accent_color" value="<?php echo e($settings['accent_color']); ?>">
    <input type="hidden" name="sidebar_caption" id="sidebar_caption" value="<?php echo e($settings['sidebar_caption']); ?>">
    <input type="hidden" name="theme_layout" id="theme_layout" value="<?php echo e($settings['theme_layout']); ?>">
    <input type="hidden" name="layout_width" id="layout_width" value="<?php echo e($settings['layout_width']); ?>">

    <input type="hidden" name="custom_color" id="custom_color" value="<?php echo e($settings['custom_color']); ?>">
<input type="hidden" name="custom_color_code" id="custom_color_code" value="<?php echo e($settings['custom_color_code']); ?>">
<input type="hidden" name="color_type" id="color_type" value="<?php echo e($settings['color_type'] ?? 'preset'); ?>">


    <div class="offcanvas border-0 pct-offcanvas offcanvas-end" tabindex="-1" id="offcanvas_pc_layout">
        <div class="offcanvas-header justify-content-between">
            <h5 class="offcanvas-title"><?php echo e(__('Theme Settings')); ?></h5>
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
                                            <h5 class="mb-1"><?php echo e(__('Theme Mode')); ?></h5>
                                            <p class="text-muted text-sm mb-0"><?php echo e(__('Light / Dark / System')); ?></p>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <div class="row g-2 theme-color theme-layout">
                                                <div class="col-4">
                                                    <div class="d-grid">
                                                        <button type="button"
                                                            class="preset-btn btn <?php echo e($settings['theme_mode'] == 'light' ? 'active' : ''); ?>"
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
                                                            class="preset-btn btn <?php echo e($settings['theme_mode'] == 'dark' ? 'active' : ''); ?>"
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
                                                            title="<?php echo e(__("Automatically sets the theme based on user's operating system's color scheme.")); ?>">
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
                                <h5 class="mb-1"><?php echo e(__('Accent color')); ?></h5>
                                <p class="text-muted text-sm mb-2"><?php echo e(__('Choose your primary theme color')); ?></p>
                                <div class="theme-color preset-color">
                                    <a href="#!"  data-color-type="preset"
                                        data-value="preset-1"
                                        class="color_type <?php echo e($settings['color_type'] == 'preset' && $settings['accent_color'] == 'preset-1' ? 'active' : ''); ?>"><i
                                            class="ti ti-check"></i></a>
                                    <a href="#!"  data-color-type="preset"
                                        data-value="preset-2"
                                        class="color_type <?php echo e($settings['color_type'] == 'preset' && $settings['accent_color'] == 'preset-2' ? 'active' : ''); ?>"><i
                                            class="ti ti-check"></i></a>
                                    <a href="#!"  data-color-type="preset"
                                        data-value="preset-3"
                                        class="color_type <?php echo e($settings['color_type'] == 'preset' && $settings['accent_color'] == 'preset-3' ? 'active' : ''); ?>"><i
                                            class="ti ti-check"></i></a>
                                    <a href="#!"  data-color-type="preset"
                                        data-value="preset-4"
                                        class="color_type <?php echo e($settings['color_type'] == 'preset' && $settings['accent_color'] == 'preset-4' ? 'active' : ''); ?>"><i
                                            class="ti ti-check"></i></a>
                                    <a href="#!"  data-color-type="preset"
                                        data-value="preset-5"
                                        class="color_type <?php echo e($settings['color_type'] == 'preset' && $settings['accent_color'] == 'preset-5' ? 'active' : ''); ?>"><i
                                            class="ti ti-check"></i></a>
                                    <a href="#!"  data-color-type="preset"
                                        data-value="preset-6"
                                        class="color_type <?php echo e($settings['color_type'] == 'preset' && $settings['accent_color'] == 'preset-6' ? 'active' : ''); ?>"><i
                                            class="ti ti-check"></i></a>
                                   <input class="color_type cutom_colorr <?php echo e($settings['color_type'] == 'custom' ? 'active' : ''); ?>" data-color-type="custom" data-value="preset-8"
                                        value="<?php echo e($settings['custom_color']); ?>" id="colorChange" type="color" style="border-color: <?php echo e($settings['custom_color_code']); ?>; padding:0">
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 me-3">
                                        <h5 class="mb-1"><?php echo e(__('Sidebar Caption')); ?></h5>
                                        <p class="text-muted text-sm mb-0"><?php echo e(__('Caption Hide / Show')); ?></p>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <div class="row g-2 theme-color theme-nav-caption">
                                            <div class="col-6">
                                                <div class="d-grid">
                                                    <button type="button"
                                                        class="preset-btn btn <?php echo e($settings['sidebar_caption'] == 'true' ? 'active' : ''); ?>"
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
                                                        class="preset-btn btn <?php echo e($settings['sidebar_caption'] == 'false' ? 'active' : ''); ?>"
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
                                            <h5 class="mb-1"><?php echo e(__('Theme Layout')); ?></h5>
                                            <p class="text-muted text-sm"><?php echo e(__('LTR/RTL')); ?></p>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <div class="row g-2 theme-color theme-direction">
                                                <div class="col-6">
                                                    <div class="d-grid">
                                                        <button type="button"
                                                            class="preset-btn btn <?php echo e($settings['theme_layout'] == 'ltr' ? 'active' : ''); ?>"
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
                                                            class="preset-btn btn <?php echo e($settings['theme_layout'] == 'rtl' ? 'active' : ''); ?>"
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
                                            <h5 class="mb-1"><?php echo e(__('Layout Width')); ?></h5>
                                            <p class="text-muted text-sm"><?php echo e(__('Full / Fixed width')); ?></p>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <div class="row g-2 theme-color theme-container">
                                                <div class="col-6">
                                                    <div class="d-grid">
                                                        <button type="button"
                                                            class="preset-btn btn <?php echo e($settings['layout_width'] == 'false' ? 'active' : ''); ?>"
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
                                                            class="preset-btn btn <?php echo e($settings['layout_width'] == 'true' ? 'active' : ''); ?>"
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
                                <h5 class="mb-1"><?php echo e(__('Font Style')); ?></h5>
                                <p class="text-muted text-sm"><?php echo e(__('Choose theme font')); ?></p>
                                <div class="theme-color theme-font-style">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="layout_font"
                                            id="layoutfontRoboto"
                                            <?php echo e($settings['layout_font'] == 'Roboto' ? 'checked' : ''); ?> value="Roboto"
                                            onclick="font_change('Roboto')" />
                                        <label class="form-check-label"
                                            for="layoutfontRoboto"><?php echo e(__('Roboto')); ?></label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="layout_font"
                                            id="layoutfontPoppins"
                                            <?php echo e($settings['layout_font'] == 'Poppins' ? 'checked' : ''); ?> value="Poppins"
                                            onclick="font_change('Poppins')" />
                                        <label class="form-check-label"
                                            for="layoutfontPoppins"><?php echo e(__('Poppins')); ?></label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="layout_font"
                                            id="layoutfontInter" <?php echo e($settings['layout_font'] == 'Inter' ? 'checked' : ''); ?>

                                            value="Inter" onclick="font_change('Inter')" />
                                        <label class="form-check-label"
                                            for="layoutfontInter"><?php echo e(__('Inter')); ?></label>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
            <div class="d-grid">
                <button class="btn btn-secondary"><?php echo e(__('Save Settings')); ?></button>
            </div>
        </div>
    </div>
</form>

<?php echo $__env->yieldPushContent('script-page'); ?>


<script>
    $(document).on('click', ".copy_register_link", function() {
        let linkToCopy = $(this).data('url');

        var linkTextArea = document.createElement('textarea');
        linkTextArea.value = linkToCopy;

        document.body.appendChild(linkTextArea);
        linkTextArea.select();
        document.execCommand('copy');
        document.body.removeChild(linkTextArea);

        toastrs('Success', '<?php echo __('Visitor pre register link copied to the clipboard.'); ?>', 'success')
    });
</script>


<script>
    var successImg='<?php echo e(asset("assets/images/notification/ok-48.png")); ?>';
    var errorImg='<?php echo e(asset("assets/images/notification/high_priority-48.png")); ?>';
    var custom_color='<?php echo e(asset("assets/css/custom-color.css")); ?>';
    		var style_preset='<?php echo e(asset("assets/css/style-preset.css")); ?>';
</script>
<script src="<?php echo e(asset('js/custom.js')); ?>"></script>
<script src="<?php echo e(asset('js/theme-color.js')); ?>"></script>
<?php if($statusMessage = Session::get('success')): ?>
    <script>
        notifier.show('Success!', '<?php echo $statusMessage; ?>', 'success',
        successImg, 4000);
    </script>
<?php endif; ?>
<?php if($statusMessage = Session::get('error')): ?>
    <script>
         notifier.show('Error!', '<?php echo $statusMessage; ?>', 'error',
         errorImg, 4000);
    </script>
<?php endif; ?>
<?php /**PATH /home4/aizwmjte/sr.elitevinylwindows.com/resources/views/admin/footer.blade.php ENDPATH**/ ?>
<?php
    use App\Helper\ShortcodeHelper;
    $grouped = ShortcodeHelper::getShortcodeGroups();
?>

<?php echo e(Form::model($template, ['route' => ['template.update', $template->id], 'method' => 'PUT'])); ?>

<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-6">
           
<?php echo e(Form::label('name', __('Module Name'), ['class' => 'form-label'])); ?>

<?php echo Form::text('name', null, ['class' => 'form-control', 'required' => true]); ?>



<?php echo e(Form::label('module', __('Module Slug'), ['class' => 'form-label'])); ?>

<?php echo Form::text('module', null, ['class' => 'form-control', 'required' => true]); ?>


        </div>

        <div class="form-group col-md-6">
            <?php echo e(Form::label('subject', __('Subject'), ['class' => 'form-label'])); ?>

            <?php echo e(Form::text('subject', null, ['class' => 'form-control', 'placeholder' => __('Enter Subject'), 'required' => 'required'])); ?>

        </div>

        <div class="form-group col-md-12">
            <?php echo e(Form::label('message', __('User Message'), ['class' => 'form-label'])); ?>

            <?php echo Form::textarea('message', $template->message, [
                'class' => 'form-control',
                'rows' => 5,
                'id' => 'message',
            ]); ?>

        </div>

        <div class="form-group col-md-12">
            <?php echo e(Form::label('enabled_email', __('Enabled Email template'), ['class' => 'form-label'])); ?>

            <input type="hidden" name="enabled_email" value="0">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked"
                    name="enabled_email" value="1" <?php echo e($template->enabled_email == 1 ? 'checked' : ''); ?>>
                <label class="form-check-label" for="flexSwitchCheckChecked"></label>
            </div>
        </div>

        <div class="form-group col-md-12">
            <h4 class="mb-0"><?php echo e(__('Shortcodes')); ?></h4>
            <p><?php echo e(__('Click to add below shortcodes and insert in your Message')); ?></p>

            <div class="accordion" id="shortcodeAccordion">
                <?php $__currentLoopData = $grouped; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $groupTitle => $codes): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading-<?php echo e(Str::slug($groupTitle)); ?>">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse-<?php echo e(Str::slug($groupTitle)); ?>" aria-expanded="false"
                                aria-controls="collapse-<?php echo e(Str::slug($groupTitle)); ?>">
                                <?php echo e(__($groupTitle)); ?>

                            </button>
                        </h2>
                        <div id="collapse-<?php echo e(Str::slug($groupTitle)); ?>" class="accordion-collapse collapse"
                            aria-labelledby="heading-<?php echo e(Str::slug($groupTitle)); ?>" data-bs-parent="#shortcodeAccordion">
                            <div class="accordion-body">
                                <?php $__currentLoopData = $codes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <a href="javascript:void(0);">
                                        <span class="badge bg-light-primary rounded-pill f-14 px-2 sort_code_click m-2" data-val="<?php echo e($code); ?>">
                                            <?php echo e($code); ?>

                                        </span>
                                    </a>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
</div>

<div class="modal-footer">
    <?php echo e(Form::submit(__('Update'), ['class' => 'btn btn-secondary ml-10'])); ?>

</div>
<?php echo e(Form::close()); ?>




<script>
    $(document).ready(function() {
        $('.module').trigger('change');

    });


    $(document).on('change', '.module', function() {
        var modd = $('.module').val();
        $('.sortcode_var').hide();
        $('.sortcode_var.' + modd).show();

        var subject = $('.sortcode_tm.' + modd).attr('data-subject');
        $('.subject').val(subject);

        var templete = $('.sortcode_tm.' + modd).attr('data-templete');
        $('#message').html(templete);
    });



    var CKEDITORsd = ClassicEditor
        .create(document.querySelector('#message'), {}).then(editor => {
            window.editor = editor;
            editorInstance = editor;

            $(document).on('click', '.sort_code_click', function() {
                var val = $(this).attr('data-val');
                editor.model.change(writer => {
                    const viewFragment = editor.data.processor.toView(val);
                    const modelFragment = editor.data.toModel(viewFragment);
                    editor.model.insertContent(modelFragment);
                });
            });

            $(document).on('change', '.module', function() {
                var modd = $('.module').val();
                var templete = $('.sortcode_tm.' + modd).attr('data-templete');
                editorInstance.setData(templete);
            });
        })
        .catch(error => {
            console.log(error);
        });


</script>
<?php /**PATH /home4/aizwmjte/sr.elitevinylwindows.com/resources/views/template/edit.blade.php ENDPATH**/ ?>
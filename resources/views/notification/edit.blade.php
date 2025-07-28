{{ Form::model($notification, ['route' => ['notification.update', $notification->id], 'method' => 'PUT']) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-6">
            {{ Form::label('name', __('Module'), ['class' => 'form-label']) }}
            {!! Form::text('name', null,[
                'class' => 'form-control',
                'required' => 'required',
                'readonly' => 'readonly',
            ]) !!}
        </div>

        <div class="form-group col-md-6">
            {{ Form::label('subject', __('Subject'), ['class' => 'form-label']) }}
            {{ Form::text('subject', null, ['class' => 'form-control', 'placeholder' => __('Enter Subject'), 'required' => 'required']) }}
        </div>

        <div class="form-group col-md-12">
            {{ Form::label('message', __('User Message'), ['class' => 'form-label']) }}
            {!! Form::textarea('message', $notification->message, [
                'class' => 'form-control',
                'rows' => 5,
                'id' => 'message',
            ]) !!}

        </div>

        <div class="form-group col-md-12">
            {{ Form::label('enabled_email', __('Enabled Email Notification'), ['class' => 'form-label']) }}
            <input class="form-check-input" type="hidden" name="enabled_email" value="0">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked"
                    name="enabled_email" value="1" {{ $notification->enabled_email == 1 ? 'checked' : '' }}>
                <label class="form-check-label" for="flexSwitchCheckChecked"></label>
            </div>
        </div>


        <div class="form-group col-md-12">
            <h4 class="mb-0">{{ __('Shortcodes') }}</h4>
            <p>{{ __('Click to add below shortcodes and insert in your Message') }}</p>

            @php
                $i = 0; // Counter for determining the display state of sections
            @endphp

            @if (!empty($notification->short_code) && is_array($notification->short_code))
                <section class="sortcode_var" style="display: {{ $i == 0 ? 'block' : 'none' }};">
                    @foreach ($notification->short_code as $item)
                        <a href="javascript:void(0);">
                            <span class="badge bg-light-primary rounded-pill f-14 px-2 sort_code_click m-2" data-val="{{ $item }}">
                                {{ $item }}
                            </span>
                        </a>
                    @endforeach
                </section>
            @else
                <p>{{ __('No shortcodes available for this notification.') }}</p>
            @endif
        </div>


    </div>
</div>
<div class="modal-footer">
    {{ Form::submit(__('Update'), ['class' => 'btn btn-secondary ml-10']) }}
</div>
{{ Form::close() }}


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

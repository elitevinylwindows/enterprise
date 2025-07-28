@php
    use App\Helper\ShortcodeHelper;
    $grouped = ShortcodeHelper::getShortcodeGroups();
@endphp

{{ Form::open(['route' => 'template.store', 'method' => 'POST']) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-6">
        {{-- Human-readable label --}}
{{ Form::label('name', __('Module Name'), ['class' => 'form-label']) }}
{!! Form::text('name', null, ['class' => 'form-control', 'required' => true]) !!}

{{-- Internal slug/identifier --}}
{{ Form::label('module', __('Module Slug (for internal use)'), ['class' => 'form-label']) }}
{!! Form::text('module', null, ['class' => 'form-control', 'required' => true]) !!}

        </div>

        <div class="form-group col-md-6">
            {{ Form::label('subject', __('Subject'), ['class' => 'form-label']) }}
            {{ Form::text('subject', null, [
                'class' => 'form-control subject',
                'placeholder' => __('Enter Subject'),
                'required' => 'required',
            ]) }}
        </div>

        <div class="form-group col-md-12">
            {{ Form::label('message', __('User Message'), ['class' => 'form-label']) }}
            {{ Form::textarea('message', null, [
                'class' => 'form-control',
                'rows' => 5,
                'id' => 'message',
                'style' => 'min-height:200px;',
            ]) }}
        </div>

        <div class="form-group col-md-12">
            {{ Form::label('enabled_email', __('Enabled Email Template'), ['class' => 'form-label']) }}
            <input type="hidden" name="enabled_email" value="0">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch"
                       id="flexSwitchCheckChecked" name="enabled_email" value="1" checked>
                <label class="form-check-label" for="flexSwitchCheckChecked"></label>
            </div>
        </div>

        <div class="form-group col-md-12">
            <h4 class="mb-0">{{ __('Shortcodes') }}</h4>
            <p>{{ __('Click to add below shortcodes and insert in your Message') }}</p>

            <div class="accordion" id="shortcodeAccordion">
                @foreach ($grouped as $groupTitle => $codes)
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading-{{ Str::slug($groupTitle) }}">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse-{{ Str::slug($groupTitle) }}" aria-expanded="false"
                                    aria-controls="collapse-{{ Str::slug($groupTitle) }}">
                                {{ __($groupTitle) }}
                            </button>
                        </h2>
                        <div id="collapse-{{ Str::slug($groupTitle) }}" class="accordion-collapse collapse"
                             aria-labelledby="heading-{{ Str::slug($groupTitle) }}" data-bs-parent="#shortcodeAccordion">
                            <div class="accordion-body">
                                @foreach ($codes as $code)
                                    <a href="javascript:void(0);">
                                        <span class="badge bg-light-primary rounded-pill f-14 px-2 sort_code_click m-2"
                                              data-val="{{ $code }}">
                                            {{ $code }}
                                        </span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<div class="modal-footer">
    {{ Form::submit(__('Create'), ['class' => 'btn btn-secondary ml-10']) }}
</div>
{{ Form::close() }}

<script>
    var CKEDITORsd = ClassicEditor
        .create(document.querySelector('#message'), {})
        .then(editor => {
            window.editor = editor;
            editorInstance = editor;

            $(document).on('click', '.sort_code_click', function () {
                var val = $(this).data('val');
                editor.model.change(writer => {
                    const viewFragment = editor.data.processor.toView(val);
                    const modelFragment = editor.data.toModel(viewFragment);
                    editor.model.insertContent(modelFragment);
                });
            });
        })
        .catch(error => {
            console.log(error);
        });
</script>

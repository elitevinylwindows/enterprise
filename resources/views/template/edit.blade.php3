{{ Form::model($template, ['route' => ['template.update', $template->id], 'method' => 'PUT']) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-6">
            {{ Form::label('name', __('Module'), ['class' => 'form-label']) }}
            {!! Form::text('name', null, [
                'class' => 'form-control',
                'required' => 'required',
                'readonly' => 'readonly',
            ]) !!}
        </div>

        <div class="form-group col-md-6">
            {{ Form::label('subject', __('Subject'), ['class' => 'form-label']) }}
            {{ Form::text('subject', null, [
                'class' => 'form-control',
                'placeholder' => __('Enter Subject'),
                'required' => 'required'
            ]) }}
        </div>

        <div class="form-group col-md-12">
            {{ Form::label('message', __('Template Message'), ['class' => 'form-label']) }}
            {!! Form::textarea('message', $template->message, [
                'class' => 'form-control',
                'rows' => 5,
                'id' => 'classic-editor',
            ]) !!}
        </div>

        <div class="form-group col-md-12">
            {{ Form::label('enabled_email', __('Enable Email Notification'), ['class' => 'form-label']) }}
            <input class="form-check-input" type="hidden" name="enabled_email" value="0">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked"
                    name="enabled_email" value="1" {{ $template->enabled_email == 1 ? 'checked' : '' }}>
                <label class="form-check-label" for="flexSwitchCheckChecked"></label>
            </div>
        </div>

        <div class="accordion mt-3" id="shortcodeAccordion">
            @php
                use App\Helpers\ShortcodeHelper;
                $grouped = ShortcodeHelper::getShortcodeGroups();
            @endphp

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

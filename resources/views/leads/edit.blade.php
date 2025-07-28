{{ Form::model($lead, ['route' => ['leads.update', $lead->id], 'method' => 'PUT']) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-6">
            {{ Form::label('license_number', 'License #') }}
            {{ Form::text('license_number', null, ['class' => 'form-control']) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('name', 'Name') }}
            {{ Form::text('name', null, ['class' => 'form-control']) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('phone', 'Phone #') }}
            {{ Form::text('phone', null, ['class' => 'form-control']) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('address', 'Address') }}
            {{ Form::text('address', null, ['class' => 'form-control']) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('city', 'City') }}
            {{ Form::text('city', null, ['class' => 'form-control']) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('zip', 'ZIP') }}
            {{ Form::text('zip', null, ['class' => 'form-control']) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('email', 'Email') }}
            {{ Form::text('email', null, ['class' => 'form-control']) }}
        </div>
      
        <div class="form-group col-md-6">
            {{ Form::label('status', 'Call Outcome Status') }}
            {{ Form::select('status', [
                'pending' => 'Pending',
                'picked_up' => '✅ Picked Up',
                'call_back' => '🔁 Call Back Requested',
                'wrong_number' => '❌ Wrong Number',
                'voicemail' => '📴 Voicemail Left',
                'spoke' => '💬 Spoke with Contractor',
                'info_sent' => '📩 Info Sent (Email/Text)',
                'not_interested' => '🚫 Not Interested',
                'considering' => '⏳ Considering Us',
    'do_not_call' => '🚫 Do Not Call',
            ], null, ['class' => 'form-control', 'id' => 'status']) }}
        </div>
  
        {{-- These will toggle based on "Call Back Requested" --}}
 

<div id="call-back-fields" class="{{ $lead->status !== 'call_back' ? 'd-none' : '' }}">
    <div class="mb-3">
        <label>Call Back Date</label>
        <input type="date" name="call_back_date" value="{{ $lead->call_back_date }}" class="form-control">
    </div>
    <div class="mb-3">
        <label>Call Back Time</label>
        <input type="time" name="call_back_time" value="{{ $lead->call_back_time }}" class="form-control">
    </div>
</div>
<div class="form-group col-md-6">
            {{ Form::label('notes', 'Notes') }}
            {{ Form::textarea('notes', null, ['class' => 'form-control']) }}
               
        </div>

    </div>
</div>

<div class="modal-footer">
    {{ Form::submit('Update Lead', ['class' => 'btn btn-secondary']) }}
</div>
{{ Form::close() }}

{{-- JavaScript placed inside modal so it runs when modal is loaded --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const statusField = document.getElementById('status');

    function toggleCallbackFields() {
        const selected = statusField.value;
        const showFields = selected === 'call_back';

        document.querySelectorAll('.callback-fields').forEach(field => {
            field.classList.toggle('d-none', !showFields);
        });
    }

    if (statusField) {
        toggleCallbackFields();
        statusField.addEventListener('change', toggleCallbackFields);
    }
});
</script>
<script>
    $(document).on('change', '#status', function () {
        if ($(this).val() === 'call_back') {
            $('#call-back-fields').removeClass('d-none');
        } else {
            $('#call-back-fields').addClass('d-none');
        }
    });

    // Trigger it on load too, for edit mode
    $(document).ready(function () {
        $('#status').trigger('change');
    });
</script>


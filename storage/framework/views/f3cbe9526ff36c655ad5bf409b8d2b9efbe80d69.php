<?php echo e(Form::model($lead, ['route' => ['leads.update', $lead->id], 'method' => 'PUT'])); ?>

<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-6">
            <?php echo e(Form::label('license_number', 'License #')); ?>

            <?php echo e(Form::text('license_number', null, ['class' => 'form-control'])); ?>

        </div>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('name', 'Name')); ?>

            <?php echo e(Form::text('name', null, ['class' => 'form-control'])); ?>

        </div>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('phone', 'Phone #')); ?>

            <?php echo e(Form::text('phone', null, ['class' => 'form-control'])); ?>

        </div>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('address', 'Address')); ?>

            <?php echo e(Form::text('address', null, ['class' => 'form-control'])); ?>

        </div>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('city', 'City')); ?>

            <?php echo e(Form::text('city', null, ['class' => 'form-control'])); ?>

        </div>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('zip', 'ZIP')); ?>

            <?php echo e(Form::text('zip', null, ['class' => 'form-control'])); ?>

        </div>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('email', 'Email')); ?>

            <?php echo e(Form::text('email', null, ['class' => 'form-control'])); ?>

        </div>
      
        <div class="form-group col-md-6">
            <?php echo e(Form::label('status', 'Call Outcome Status')); ?>

            <?php echo e(Form::select('status', [
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
            ], null, ['class' => 'form-control', 'id' => 'status'])); ?>

        </div>
  
        
 

<div id="call-back-fields" class="<?php echo e($lead->status !== 'call_back' ? 'd-none' : ''); ?>">
    <div class="mb-3">
        <label>Call Back Date</label>
        <input type="date" name="call_back_date" value="<?php echo e($lead->call_back_date); ?>" class="form-control">
    </div>
    <div class="mb-3">
        <label>Call Back Time</label>
        <input type="time" name="call_back_time" value="<?php echo e($lead->call_back_time); ?>" class="form-control">
    </div>
</div>
<div class="form-group col-md-6">
            <?php echo e(Form::label('notes', 'Notes')); ?>

            <?php echo e(Form::textarea('notes', null, ['class' => 'form-control'])); ?>

               
        </div>

    </div>
</div>

<div class="modal-footer">
    <?php echo e(Form::submit('Update Lead', ['class' => 'btn btn-secondary'])); ?>

</div>
<?php echo e(Form::close()); ?>



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

<?php /**PATH /home4/aizwmjte/sr.elitevinylwindows.com/resources/views/leads/edit.blade.php ENDPATH**/ ?>
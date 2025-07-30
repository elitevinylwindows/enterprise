<!-- Create Event Modal -->
<div class="modal fade" id="createEventModal" tabindex="-1" aria-labelledby="createEventModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?php echo e(route('calendar.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createEventModalLabel">Add New Delivery Event</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="mb-3">
                        <label for="order_number" class="form-label">Order Number</label>
                        <input type="text" name="order_number" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="delivery_date" class="form-label">Delivery Date</label>
                        <input type="date" name="delivery_date" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="timeframe" class="form-label">Time Frame</label>
                        <input type="text" name="timeframe" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description / Comment</label>
                        <textarea name="comment" class="form-control"></textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Save Event</button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php /**PATH /home4/aizwmjte/sr.elitevinylwindows.com/resources/views/calendar/create.blade.php ENDPATH**/ ?>
<!-- Edit Cart Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form id="edit-cart-form" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Cart</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit-cart-barcode" class="form-label">Cart Barcode</label>
                        <input type="text" name="cart_barcode" id="edit-cart-barcode" class="form-control" readonly>
                    </div>

                    <div id="edit-item-list">
                        <!-- Dynamically inserted items go here -->
                    </div>

                    <button type="button" id="edit-add-more" class="btn btn-outline-primary mt-2">+ Add Another Item</button>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Update Cart</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    $(document).on('click', '.open-edit-modal', function () {
        let cartId = $(this).data('id');

        // Set the action dynamically
        $('#edit-cart-form').attr('action', '/cart/' + cartId);

        // Populate fields here as needed

        $('#editModal').modal('show');
    });
</script>

@endpush

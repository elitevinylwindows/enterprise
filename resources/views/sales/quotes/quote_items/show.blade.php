<div class="modal-header">
    <h5 class="modal-title">View Quote Item</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">
    <div class="mb-3">
        <label class="form-label fw-bold">Description:</label>
        <div>{{ $item->description }}</div>
    </div>

    <div class="row">
        <div class="col-md-4 mb-3">
            <label class="form-label fw-bold">Qty:</label>
            <div>{{ $item->qty }}</div>
        </div>
        <div class="col-md-4 mb-3">
            <label class="form-label fw-bold">Price:</label>
            <div>${{ number_format($item->price, 2) }}</div>
        </div>
        <div class="col-md-4 mb-3">
            <label class="form-label fw-bold">Total:</label>
            <div>${{ number_format($item->total, 2) }}</div>
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label fw-bold">Glass:</label>
        <div>{{ $item->glass }}</div>
    </div>

    <div class="mb-3">
        <label class="form-label fw-bold">Grid:</label>
        <div>{{ $item->grid }}</div>
    </div>

    <div class="mb-3">
        <label class="form-label fw-bold">Checked:</label>
        <div>{{ $item->checked ? 'Yes' : 'No' }}</div>
    </div>

    <div class="mb-3">
        <label class="form-label fw-bold">Line Item Comment:</label>
        <div>{{ $item->item_comment }}</div>
    </div>

    <div class="mb-3">
        <label class="form-label fw-bold">Internal Note:</label>
        <div>{{ $item->internal_note }}</div>
    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
</div>

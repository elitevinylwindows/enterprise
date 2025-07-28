<form action="{{ route('sales.quotes.items.update', [$quote->id, $item->id]) }}" method="POST" id="editQuoteItemForm">
    @csrf
    @method('PUT')
    <div class="modal-header">
        <h5 class="modal-title">Edit Quote Item</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>
    <div class="modal-body">
        <div class="row">
            <!-- Tabs -->
            <div class="col-md-3 border-end">
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist">
                    <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#metaTab" type="button">Meta Info</button>
                    <button class="nav-link" data-bs-toggle="pill" data-bs-target="#glassTab" type="button">Glass & Grid</button>
                    <button class="nav-link" data-bs-toggle="pill" data-bs-target="#notesTab" type="button">Notes</button>
                </div>
            </div>

            <!-- Tab Content -->
            <div class="col-md-9">
                <div class="tab-content">
                    <!-- Meta Info Tab -->
                    <div class="tab-pane fade show active" id="metaTab">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label>Description</label>
                                <input type="text" name="description" value="{{ $item->description }}" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label>Qty</label>
                                <input type="number" name="qty" value="{{ $item->qty }}" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label>Price</label>
                                <input type="text" name="price" value="{{ $item->price }}" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label>Total</label>
                                <input type="text" name="total" value="{{ $item->total }}" class="form-control">
                            </div>
                        </div>
                    </div>

                    <!-- Glass & Grid Tab -->
                    <div class="tab-pane fade" id="glassTab">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label>Glass</label>
                                <input type="text" name="glass" value="{{ $item->glass }}" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label>Grid</label>
                                <input type="text" name="grid" value="{{ $item->grid }}" class="form-control">
                            </div>
                            <div class="form-check mt-3">
                                <input class="form-check-input" type="checkbox" name="checked" id="checked" {{ $item->checked ? 'checked' : '' }}>
                                <label class="form-check-label" for="checked">Checked</label>
                            </div>
                        </div>
                    </div>

                    <!-- Notes Tab -->
                    <div class="tab-pane fade" id="notesTab">
                        <div class="mb-3">
                            <label>Line Item Comment</label>
                            <textarea name="item_comment" class="form-control" rows="2">{{ $item->item_comment }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label>Internal Notes</label>
                            <textarea name="internal_note" class="form-control" rows="3">{{ $item->internal_note }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-footer mt-3">
        <button type="submit" class="btn btn-primary">Save Changes</button>
    </div>
</form>

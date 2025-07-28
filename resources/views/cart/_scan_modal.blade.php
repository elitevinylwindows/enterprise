<!-- Start Scanning Modal -->
<div class="modal fade" id="startScanModal" tabindex="-1" aria-labelledby="startScanLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('cart.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="startScanLabel">Scan Cart & Items</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="mb-3">
                        <label for="cart_barcode" class="form-label">Cart Barcode</label>
                        <input type="text" name="cart_barcode" id="cart_barcode" class="form-control" required>
                    </div>

                    <div id="item-list">
                        <div class="item-group border rounded p-3 mb-2">
                            <label>Production Barcode</label>
                            <input type="text" name="production_barcode[]" class="form-control mb-2" required>

                            <label>Description</label>
                            <input type="text" name="description[]" class="form-control mb-2">

                            <label>Dimensions (W × H)</label>
                            <div class="d-flex gap-2">
                                <input type="number" name="width[]" placeholder="Width" class="form-control" required>
                                <input type="number" name="height[]" placeholder="Height" class="form-control" required>
                            </div>

                            <label>Order Number</label>
                            <input type="text" name="order_number[]" class="form-control mb-2">

                            <label>Comment</label>
                            <input type="text" name="comment[]" class="form-control mb-2">

                            <label>Customer Number</label>
                            <input type="text" name="customer_number[]" class="form-control mb-2">

                            <label>Customer Short Name</label>
                            <input type="text" name="customer_short_name[]" class="form-control mb-2">
                        </div>
                    </div>

                    <button type="button" id="add-more" class="btn btn-outline-primary mt-2">+ Add Another Item</button>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save and Close</button>
                    <button type="submit" name="create_another" value="1" class="btn btn-secondary">Save and Add Another</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    let itemIndex = 1;
    document.getElementById('add-more').addEventListener('click', function () {
        const itemList = document.getElementById('item-list');
        const newItem = itemList.children[0].cloneNode(true);
        newItem.querySelectorAll('input').forEach(input => {
            input.value = '';
        });
        itemList.appendChild(newItem);
        itemIndex++;
    });
</script>

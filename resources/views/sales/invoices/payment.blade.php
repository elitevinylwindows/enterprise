<div class="modal-header">
    <h5 class="modal-title">Manage Deposit & Payments</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">
    {{-- Total Display --}}
    <div class="d-flex justify-content-end mb-3">
        <h5>Total: <span id="totalAmount" data-total="{{ $total ?? 1000 }}">${{ number_format($total ?? 1000, 2) }}</span></h5>
    </div>

    {{-- Nav Tabs --}}
    <ul class="nav nav-tabs" id="paymentTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="deposit-tab" data-bs-toggle="tab" data-bs-target="#depositTab" type="button" role="tab">Deposit</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="payments-tab" data-bs-toggle="tab" data-bs-target="#paymentsTab" type="button" role="tab">Payments</button>
        </li>
    </ul>

    <div class="tab-content mt-3" id="paymentTabsContent">

        {{-- Deposit Tab --}}
        <div class="tab-pane fade show active" id="depositTab" role="tabpanel">

            {{-- Deposit Type --}}
            <div class="mb-3">
                <label class="form-label">Deposit Type</label><br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input deposit-type" type="radio" name="deposit_type" value="percentage" checked>
                    <label class="form-check-label">Percentage (%)</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input deposit-type" type="radio" name="deposit_type" value="amount">
                    <label class="form-check-label">Amount ($)</label>
                </div>
            </div>

            {{-- Value Input --}}
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Enter Value</label>
                    <input type="number" class="form-control" id="depositValue" step="0.01">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Calculated Amount</label>
                    <input type="text" class="form-control" id="depositCalculated" readonly>
                </div>
            </div>

            {{-- Payment Method --}}
            <div class="mb-3">
                <label class="form-label">Payment Method</label><br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input payment-method" type="radio" name="deposit_method" value="card" checked>
                    <label class="form-check-label">Card</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input payment-method" type="radio" name="deposit_method" value="check">
                    <label class="form-check-label">Check</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input payment-method" type="radio" name="deposit_method" value="account">
                    <label class="form-check-label">Account Transfer</label>
                </div>
            </div>

            {{-- Dynamic Payment Fields --}}
            <div id="depositPaymentFields">
                {{-- Default Card Fields --}}
                <div class="mb-3">
                    <label class="form-label">Card Number</label>
                    <input type="text" class="form-control" placeholder="XXXX XXXX XXXX XXXX">
                </div>
                <div class="mb-3">
                    <label class="form-label">CVV</label>
                    <input type="text" class="form-control" placeholder="123">
                </div>
            </div>
        </div>

        {{-- Payments Tab --}}
        <div class="tab-pane fade" id="paymentsTab" role="tabpanel">
            <div id="paymentsList">
                <div class="payment-entry border rounded p-3 mb-3">
                    <div class="row">
                        <div class="col-md-4">
                            <label class="form-label">Payment Amount</label>
                            <input type="number" class="form-control" step="0.01">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Payment Method</label>
                            <select class="form-control">
                                <option value="card">Card</option>
                                <option value="check">Check</option>
                                <option value="account">Account Transfer</option>
                            </select>
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button type="button" class="btn btn-danger removePayment w-100">Remove</button>
                        </div>
                    </div>
                </div>
            </div>

            <button type="button" class="btn btn-secondary" id="addPayment">+ Add Payment</button>
        </div>

    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-primary">Save</button>
    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const total = parseFloat(document.getElementById('totalAmount').dataset.total);
    const depositValue = document.getElementById('depositValue');
    const depositCalculated = document.getElementById('depositCalculated');

    // Calculate deposit
    depositValue.addEventListener('input', function () {
        const type = document.querySelector('input[name="deposit_type"]:checked').value;
        if (type === 'percentage') {
            depositCalculated.value = '$' + ((this.value / 100) * total).toFixed(2);
        } else {
            depositCalculated.value = '$' + parseFloat(this.value || 0).toFixed(2);
        }
    });

    // Change deposit type
    document.querySelectorAll('.deposit-type').forEach(radio => {
        radio.addEventListener('change', function () {
            depositValue.dispatchEvent(new Event('input'));
        });
    });

    // Payment method change
    document.querySelectorAll('.payment-method').forEach(method => {
        method.addEventListener('change', function () {
            const container = document.getElementById('depositPaymentFields');
            container.innerHTML = ''; // clear

            if (this.value === 'card') {
                container.innerHTML = `
                    <div class="mb-3">
                        <label class="form-label">Card Number</label>
                        <input type="text" class="form-control" placeholder="XXXX XXXX XXXX XXXX">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">CVV</label>
                        <input type="text" class="form-control" placeholder="123">
                    </div>
                `;
            } else if (this.value === 'check') {
                container.innerHTML = `
                    <div class="mb-3">
                        <label class="form-label">Check Number</label>
                        <input type="text" class="form-control">
                    </div>
                `;
            } else {
                container.innerHTML = `
                    <div class="mb-3">
                        <label class="form-label">Account Number</label>
                        <input type="text" class="form-control">
                    </div>
                `;
            }
        });
    });

    // Add payment row
    document.getElementById('addPayment').addEventListener('click', function () {
        const newPayment = document.createElement('div');
        newPayment.classList.add('payment-entry', 'border', 'rounded', 'p-3', 'mb-3');
        newPayment.innerHTML = `
            <div class="row">
                <div class="col-md-4">
                    <label class="form-label">Payment Amount</label>
                    <input type="number" class="form-control" step="0.01">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Payment Method</label>
                    <select class="form-control">
                        <option value="card">Card</option>
                        <option value="check">Check</option>
                        <option value="account">Account Transfer</option>
                    </select>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="button" class="btn btn-danger removePayment w-100">Remove</button>
                </div>
            </div>
        `;
        document.getElementById('paymentsList').appendChild(newPayment);
    });

    // Remove payment row
    document.getElementById('paymentsList').addEventListener('click', function (e) {
        if (e.target.classList.contains('removePayment')) {
            e.target.closest('.payment-entry').remove();
        }
    });
});
</script>
@endpush

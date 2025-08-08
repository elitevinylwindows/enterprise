{{-- resources/views/sales/invoices/payment.blade.php --}}
<div class="modal-header">
    <h5 class="modal-title">Invoice Payment</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">
    @php
        $totalAmount = $invoice->total ?? 0; // pass $invoice from controller
    @endphp

    <div class="text-end mb-3">
        <strong>Total:</strong> $<span id="invoiceTotal">{{ number_format($totalAmount, 2) }}</span>
    </div>

    {{-- Nav Tabs --}}
    <ul class="nav nav-tabs" id="paymentTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="deposit-tab" data-bs-toggle="tab" data-bs-target="#deposit" type="button" role="tab">Deposit</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="payments-tab" data-bs-toggle="tab" data-bs-target="#payments" type="button" role="tab">Payments</button>
        </li>
    </ul>

    <div class="tab-content mt-3">
        {{-- Deposit Tab --}}
        <div class="tab-pane fade show active" id="deposit" role="tabpanel">
            <form id="depositForm">
                {{-- Percentage or Amount --}}
                <label class="form-label">Deposit Type</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="deposit_type" value="percentage" checked>
                    <label class="form-check-label">Percentage</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="deposit_type" value="amount">
                    <label class="form-check-label">Amount</label>
                </div>

                {{-- Value input --}}
                <div class="mt-3">
                    <label class="form-label" id="depositValueLabel">Percentage Value (%)</label>
                    <input type="number" class="form-control" name="deposit_value" id="depositValue" placeholder="Enter value">
                </div>

                {{-- Calculated Amount (only for %) --}}
                <div class="mt-3" id="calculatedAmountGroup">
                    <label class="form-label">Calculated Amount</label>
                    <input type="text" class="form-control" id="calculatedAmount" readonly>
                </div>

                {{-- Payment Method --}}
                <div class="mt-4">
                    <label class="form-label">Payment Method</label><br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="deposit_payment_method" value="card" checked>
                        <label class="form-check-label">Card</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="deposit_payment_method" value="echeck">
                        <label class="form-check-label">E-Check</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="deposit_payment_method" value="cash">
                        <label class="form-check-label">Cash</label>
                    </div>
                </div>

                {{-- Method Fields --}}
                <div id="depositMethodFields" class="mt-3"></div>
            </form>
        </div>

        {{-- Payments Tab --}}
        <div class="tab-pane fade" id="payments" role="tabpanel">
            <div id="paymentsList">
                {{-- Single Payment Row Template --}}
                <div class="payment-row border rounded p-3 mb-3">
                    <div class="mb-2">
                        <label class="form-label">Payment Amount</label>
                        <input type="number" class="form-control" name="payment_amount[]" placeholder="Enter amount">
                    </div>

                    {{-- Payment Method --}}
                    <div class="mb-2">
                        <label class="form-label">Payment Method</label><br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input payment-method-radio" type="radio" name="payment_method_row0" value="card" checked>
                            <label class="form-check-label">Card</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input payment-method-radio" type="radio" name="payment_method_row0" value="echeck">
                            <label class="form-check-label">E-Check</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input payment-method-radio" type="radio" name="payment_method_row0" value="cash">
                            <label class="form-check-label">Cash</label>
                        </div>
                    </div>

                    <div class="payment-method-fields"></div>
                </div>
            </div>

            <button type="button" id="addPaymentRow" class="btn btn-sm btn-secondary">Add Payment</button>
        </div>
    </div>
</div>

<div class="modal-footer">
    <button type="submit" class="btn btn-primary">Save Payment</button>
    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
</div>

@push('scripts')
<script>
(function(){
    const total = parseFloat(document.getElementById('invoiceTotal').textContent.replace(/,/g, ''));

    // ===== Deposit tab logic =====
    const depositTypeRadios = document.querySelectorAll('input[name="deposit_type"]');
    const depositValue = document.getElementById('depositValue');
    const depositValueLabel = document.getElementById('depositValueLabel');
    const calculatedAmountGroup = document.getElementById('calculatedAmountGroup');
    const calculatedAmount = document.getElementById('calculatedAmount');

    function updateDepositFields(){
        const type = document.querySelector('input[name="deposit_type"]:checked').value;
        if(type === 'percentage'){
            depositValueLabel.textContent = 'Percentage Value (%)';
            calculatedAmountGroup.style.display = 'block';
            calculateAmount();
        } else {
            depositValueLabel.textContent = 'Amount ($)';
            calculatedAmountGroup.style.display = 'none';
        }
    }
    function calculateAmount(){
        const val = parseFloat(depositValue.value) || 0;
        const amt = (val / 100) * total;
        calculatedAmount.value = amt.toFixed(2);
    }
    depositTypeRadios.forEach(r => r.addEventListener('change', updateDepositFields));
    depositValue.addEventListener('input', calculateAmount);
    updateDepositFields();

    // ===== Payment Method logic for Deposit =====
    const depositMethodRadios = document.querySelectorAll('input[name="deposit_payment_method"]');
    const depositMethodFields = document.getElementById('depositMethodFields');

    function renderDepositMethodFields(method){
        if(method === 'card'){
            depositMethodFields.innerHTML = `
                <div class="row g-2">
                    <div class="col-md-6">
                        <label class="form-label">Card Number</label>
                        <input type="text" class="form-control" name="deposit_card_number">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">CVV</label>
                        <input type="text" class="form-control" name="deposit_card_cvv">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Expiry</label>
                        <input type="text" class="form-control" name="deposit_card_expiry">
                    </div>
                    <div class="col-md-4 mt-2">
                        <label class="form-label">ZIP</label>
                        <input type="text" class="form-control" name="deposit_card_zip">
                    </div>
                </div>
            `;
        } else if(method === 'echeck'){
            depositMethodFields.innerHTML = `
                <div class="row g-2">
                    <div class="col-md-6">
                        <label class="form-label">Account Number</label>
                        <input type="text" class="form-control" name="deposit_bank_account">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Routing Number</label>
                        <input type="text" class="form-control" name="deposit_bank_routing">
                    </div>
                </div>
            `;
        } else {
            depositMethodFields.innerHTML = `<div class="alert alert-secondary mb-0">No additional fields for Cash</div>`;
        }
    }
    depositMethodRadios.forEach(r => r.addEventListener('change', e => renderDepositMethodFields(e.target.value)));
    renderDepositMethodFields('card');

    // ===== Payments tab logic =====
    const paymentsList = document.getElementById('paymentsList');
    const addPaymentRowBtn = document.getElementById('addPaymentRow');

    function renderPaymentMethodFields(container, method){
        if(method === 'card'){
            container.innerHTML = `
                <div class="row g-2">
                    <div class="col-md-6">
                        <label class="form-label">Card Number</label>
                        <input type="text" class="form-control" name="payment_card_number[]">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">CVV</label>
                        <input type="text" class="form-control" name="payment_card_cvv[]">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Expiry</label>
                        <input type="text" class="form-control" name="payment_card_expiry[]">
                    </div>
                    <div class="col-md-4 mt-2">
                        <label class="form-label">ZIP</label>
                        <input type="text" class="form-control" name="payment_card_zip[]">
                    </div>
                </div>
            `;
        } else if(method === 'echeck'){
            container.innerHTML = `
                <div class="row g-2">
                    <div class="col-md-6">
                        <label class="form-label">Account Number</label>
                        <input type="text" class="form-control" name="payment_bank_account[]">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Routing Number</label>
                        <input type="text" class="form-control" name="payment_bank_routing[]">
                    </div>
                </div>
            `;
        } else {
            container.innerHTML = `<div class="alert alert-secondary mb-0">No additional fields for Cash</div>`;
        }
    }

    function bindPaymentRow(row, index){
        const radios = row.querySelectorAll('.payment-method-radio');
        const methodFields = row.querySelector('.payment-method-fields');
        radios.forEach(r => r.addEventListener('change', e => renderPaymentMethodFields(methodFields, e.target.value)));
        renderPaymentMethodFields(methodFields, 'card');
    }

    addPaymentRowBtn.addEventListener('click', () => {
        const index = paymentsList.querySelectorAll('.payment-row').length;
        const clone = paymentsList.querySelector('.payment-row').cloneNode(true);
        // Update radio names for uniqueness
        clone.querySelectorAll('.payment-method-radio').forEach(r => {
            r.name = `payment_method_row${index}`;
        });
        paymentsList.appendChild(clone);
        bindPaymentRow(clone, index);
    });

    bindPaymentRow(paymentsList.querySelector('.payment-row'), 0);
})();
</script>
@endpush

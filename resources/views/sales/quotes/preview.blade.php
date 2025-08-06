<div class="modal-header">
    <h5 class="modal-title">Quote: {{ $quote->quote_number }}</h5>
    <a href="{{route('sales.quotes.pdf.preview', $quote->id)}}" target="_blank" class="btn btn-sm btn-primary ms-auto">
        <i class="fa fa-download"></i> Download PDF
    </a>
    <a href="{{route('sales.quotes.send', $quote->id)}}" class="btn btn-sm btn-primary ms-2">
        <i class="fa fa-envelope"></i> Send Email
    </a>
</div>

<div class="modal-body">
    <div class="row">
        <div class="col-md-6">
            <p><strong>Quoted By:</strong> {{ $quote->entered_by }}</p>
        </div>
        <div class="col-md-6">
            <p><strong>Customer:</strong> {{ $quote->customer_name }}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <p><strong>Measurement Type:</strong> {{ $quote->measurement_type }}</p>
        </div>
        <div class="col-md-6">
            <p><strong>Quote Date:</strong> {{ \Carbon\Carbon::parse($quote->entry_date)->format('M d, Y') }}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <p><strong>Expected Date:</strong> {{ \Carbon\Carbon::parse($quote->expected_delivery)->format('M d, Y') }}</p>
        </div>
        <div class="col-md-6">
            <p><strong>Valid Until:</strong> {{ \Carbon\Carbon::parse($quote->valid_until)->format('M d, Y') }}</p>
        </div>
    </div>

    <div class="table-responsive mt-4">
        <table class="table table-bordered table-striped">
            <thead class="table-light">
                <tr>
                    <th style="width: 0%;">Item</th>
                    <th style="width: 0%;">Glass</th>
                    <th style="width: 0%;">Grid</th>
                    <th>Qty</th>
                    <th>Size</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($quote->items as $index => $item)
                <tr>
                    <td style="width: 0%;">{{ $item->description ?? 'N/A' }}</td>
                    <td style="width: 0%;">{{ $item->glass ?? 'N/A' }}</td>
                    <td style="width: 0%;">{{ $item->grid ?? 'N/A' }}</td>
                    <td>{{ $item->qty }}</td>
                    <td>{{ $item->width }}" x {{ $item->height }}"</td>
                    <td>${{ number_format($item->price, 2) }}</td>
                    <td>${{ number_format($item->total, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="row mt-4">
            <div class="col-md-6 offset-md-6">
                <table class="table">
                    <tr>
                        <th>Surcharge:</th>
                        <td id="surcharge-amount">${{ number_format(0, 2) }}</td>
                    </tr>
                    <tr>
                        <th>Subtotal:</th>
                        <td id="subtotal-amount">
                            ${{ number_format($quote->items->sum('total'), 2) }}
                        </td>
                    </tr>
                    <tr>
                        <th>Tax:</th>
                        @php
                        $subtotal = $quote->items->sum('total');
                        $surcharge = 0;
                        $taxRate = 0.08;
                        $tax = $subtotal * $taxRate;
                        @endphp
                        <td id="tax-amount">${{ number_format($tax, 2) }}</td>
                    </tr>
                    <tr>
                        <th>Total:</th>
                        <td><strong id="total-amount">${{ number_format($subtotal + $surcharge + $tax, 2) }}</strong></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal-footer">
    <button class="btn btn-primary" type="button" id="saveQuoteButton">Save Quote</button>
</div>

<script>
    document.getElementById('saveQuoteButton').addEventListener('click', function() {
        const formData = new FormData();
        formData.append('surcharge', document.getElementById('surcharge').value);
        formData.append('subtotal', document.getElementById('subtotal').value);
        formData.append('tax', document.getElementById('tax').value);
        formData.append('total', document.getElementById('total').value);

        fetch('{{ route('sales.quotes.save.draft', $quote->id) }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Quote saved successfully!');
                // Optionally, you can redirect or update the UI
                window.location.href = '{{ route('sales.quotes.index') }}';
            } else {
                alert('Error saving draft.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
</script>
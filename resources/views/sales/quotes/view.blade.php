<div class="modal-header">
    <h5 class="modal-title">Quote: {{ $quote->quote_number }}</h5>
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
                    <th>Qty</th>
                    <th>Size</th>
                    <th style="width: 0%;">Glass</th>
                    <th style="width: 0%;">Grid</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($quote->items as $index => $item)
                <tr>
                    <td style="width: 0%;">{{ $item->description ?? 'N/A' }}</td>
                    <td>{{ $item->qty }}</td>
                    <td>{{ $item->width }}" x {{ $item->height }}"</td>
                    <td style="width: 0%;">{{ $item->glass ?? 'N/A' }}</td>
                    <td style="width: 0%;">{{ $item->grid ?? 'N/A' }}</td>
                    <td>${{ number_format($item->price, 2) }}</td>
                    <td>${{ number_format($item->total, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
            @if(!$modificationsByDate->isEmpty())
                @foreach ($modificationsByDate as $date => $modifications)
                    <table class="table table-bordered table-striped mt-4 modificationsTable" data-mod-date="{{ $date }}">
                        <thead class="table-light">
                            <tr>
                                <th colspan="9" class="text-center">Modifications ({{ $date }})</th>
                            </tr>
                            <tr>
                                <th>Item</th>
                                <th>Qty</th>
                                <th>Size</th>
                                <th>Glass</th>
                                <th>Grid</th>
                                <th>Price</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($modifications as $modification)
                                <tr data-id="{{ $modification->id }}" data-type="modification">
                                    <td style="text-wrap:auto">{{ $modification->description }}</td>
                                    <td>{{ $modification->qty }}</td>
                                    <td>{{ $modification->width }}" x {{ $modification->height }}"</td>
                                    <td>{{ $modification->glass }}</td>
                                    <td>{{ $modification->grid }}</td>
                                    <td>${{ number_format($modification->price, 2) }}</td>
                                    <td>${{ number_format($modification->total, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endforeach
            @endif
        <div class="row mt-4">
            <div class="col-md-6 offset-md-6">
                <table class="table">
                    <tr>
                        <th>Discount:</th>
                        <td id="discount">${{ number_format($quote->discount, 2) }}</td>
                    </tr>
                    <tr>
                        <th>Shipping:</th>
                        <td id="shipping">${{ number_format($quote->shipping, 2) }}</td>
                    </tr>
                    <tr>
                        <th>Subtotal:</th>
                        <td id="subtotal-amount">
                            ${{ number_format($quote->items->sum('total') + $quote->shipping, 2) }}
                        </td>
                    </tr>
                    <tr>
                        <th>Tax:</th>
                        <td id="tax-amount">${{ number_format($quote->tax, 2) }}</td>
                    </tr>
                    <tr>
                        <th>Total:</th>
                        <td><strong id="total-amount">${{ number_format(($quote->items->sum('total') - $quote->discount) + $quote->shipping + $quote->tax, 2) }}</strong></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal-footer">
    <button class="btn btn-primary" type="button" data-bs-dismiss="modal">Close</button>
</div>

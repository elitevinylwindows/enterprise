<div class="modal-header">
    <h5 class="modal-title">Purchase quote: {{ $quote->purchase_quote_id }}</h5>
    <a href="" class="btn btn-sm btn-primary ms-auto">
        <i class="fa fa-download"></i> Download PDF
    </a>
</div>

<div class="modal-body">
    <p><strong>quoteed By:</strong> {{ $quote->quoteed_by }}</p>
    <p><strong>Department:</strong> {{ $quote->department }}</p>

    @php
        $firstProduct = $quote->items->first()->product ?? null;
    @endphp
    <p><strong>Supplier:</strong> {{ $firstProduct?->supplier->name ?? 'N/A' }}</p>

    <p><strong>quote Date:</strong> {{ \Carbon\Carbon::parse($quote->quote_date)->format('M d, Y') }}</p>
    <p><strong>Expected Date:</strong> {{ \Carbon\Carbon::parse($quote->expected_date)->format('M d, Y') }}</p>

    <div class="table-responsive mt-4">
        <table class="table table-bordered table-striped">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Product</th>
                    <th>Description</th>
                    <th>Qty</th>
                    <th>Unit Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($quote->items as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->product->name ?? 'N/A' }}</td>
                        <td>{{ $item->product->description ?? '-' }}</td>
                        <td>{{ $item->qty }}</td>
                        <td>${{ number_format($item->price, 2) }}</td>
                        <td>${{ number_format($item->total, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="modal-header">
    <h5 class="modal-title">Purchase Request: {{ $request->purchase_request_id }}</h5>
    <a href="{{ route('purchasing.purchase-requests.download', $request->id) }}" class="btn btn-sm btn-primary ms-auto">
        <i class="fa fa-download"></i> Download PDF
    </a>
</div>

<div class="modal-body">
    <p><strong>Requested By:</strong> {{ $request->requested_by }}</p>
    <p><strong>Department:</strong> {{ $request->department }}</p>

    @php
        $firstProduct = $request->items->first()->product ?? null;
    @endphp
    <p><strong>Supplier:</strong> {{ $firstProduct?->supplier->name ?? 'N/A' }}</p>

    <p><strong>Request Date:</strong> {{ \Carbon\Carbon::parse($request->request_date)->format('M d, Y') }}</p>
    <p><strong>Expected Date:</strong> {{ \Carbon\Carbon::parse($request->expected_date)->format('M d, Y') }}</p>

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
                @foreach($request->items as $index => $item)
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

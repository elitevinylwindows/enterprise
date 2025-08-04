@extends('layouts.public')

@section('page-title', 'Purchase Request - Supplier View')

@section('content')
<div class="container">
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5>Purchase Request #{{ $quote->purchaseRequest->purchase_request_id }}</h5>
            <span class="badge bg-warning text-dark">{{ ucfirst($quote->status) }}</span>
        </div>

        <div class="card-body">
            <p><strong>Supplier:</strong> {{ $quote->supplier->name }}</p>
            <p><strong>Request Date:</strong> {{ \Carbon\Carbon::parse($quote->purchaseRequest->request_date)->format('F d, Y') }}</p>
            <p><strong>Expected Date:</strong> {{ \Carbon\Carbon::parse($quote->purchaseRequest->expected_date)->format('F d, Y') }}</p>
            <p><strong>Requested By:</strong> {{ $quote->purchaseRequest->requested_by }}</p>
            <p><strong>Priority:</strong> {{ $quote->purchaseRequest->priority }}</p>
            <p><strong>Notes:</strong> {{ $quote->purchaseRequest->notes ?? '-' }}</p>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header"><strong>Requested Items</strong></div>
        <div class="card-body table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Description</th>
                        <th>Qty</th>
                        <th>Unit Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($quote->purchaseRequest->items as $item)
                    <tr>
                        <td>{{ $item->product->name ?? '-' }}</td>
                        <td>{{ $item->description }}</td>
                        <td>{{ $item->qty }}</td>
                        <td>${{ number_format($item->price, 2) }}</td>
                        <td>${{ number_format($item->total, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Upload PDF --}}
    <form method="POST" action="{{ route('purchasing.supplier.quote.approve', $quote->id) }}" enctype="multipart/form-data" id="approveForm" class="d-none">
        @csrf
        <div class="mb-3">
            <label>Attach Quote (PDF)</label>
            <input type="file" name="attachment" class="form-control" accept="application/pdf">
        </div>
    </form>

    <form method="POST" action="{{ route('purchasing.supplier.quote.modify', $quote->id) }}" enctype="multipart/form-data" id="modifyForm" class="d-none">
        @csrf
        <div class="mb-3">
            <label>Edit Prices and Upload PDF</label>
            <input type="file" name="attachment" class="form-control" accept="application/pdf">
            {{-- Optional: Dynamic pricing update fields here --}}
        </div>
    </form>

    <form method="POST" action="{{ route('purchasing.supplier.quote.cancel', $quote->id) }}" id="cancelForm" class="d-none">
        @csrf
    </form>

    {{-- Action Buttons --}}
    <div class="card">
        <div class="card-body d-flex gap-2 justify-content-end">
            <button type="submit" form="approveForm" class="btn btn-success">Approve & Upload</button>
            <button type="submit" form="modifyForm" class="btn btn-warning">Modify & Upload</button>
            <button type="submit" form="cancelForm" class="btn btn-danger" onclick="return confirm('Are you sure you want to cancel this request?')">Cancel</button>
        </div>
    </div>
</div>
@endsection

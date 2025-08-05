@extends('layouts.public')

@section('page-title', 'Purchase Request - Supplier View')

@section('content')
<div class="container">
    {{-- Header Card --}}
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

    {{-- Item Table --}}
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

    {{-- Modify and Approve --}}
    <form action="{{ route('supplier.quote.modify', $quote->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <h5 class="mt-4 mb-2">Modify Prices (Optional)</h5>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Qty</th>
                    <th>Current Price</th>
                    <th>New Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach($quote->purchaseRequest->items as $item)
                <tr>
                    <td>{{ $item->description }}</td>
                    <td>{{ $item->qty }}</td>
                    <td>${{ number_format($item->price, 2) }}</td>
                    <td>
                        <input type="number" name="price[{{ $item->id }}]" step="0.01" class="form-control" value="{{ $item->price }}">
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mb-3">
            <label>Attach Quote File (PDF or Image)</label>
            <input type="file" name="quote_file" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
        </div>

        <button type="submit" class="btn btn-warning">Modify & Approve</button>
    </form>

    {{-- Approve Only --}}
    <form method="POST" action="{{ route('supplier.quote.approve', $quote->id) }}" enctype="multipart/form-data" class="mt-4">
        @csrf
        <div class="mb-3">
            <label>Upload Quote File (PDF)</label>
            <input type="file" name="attachment" class="form-control" accept="application/pdf">
        </div>
        <button type="submit" class="btn btn-success">Approve & Upload</button>
    </form>

    {{-- Cancel --}}
    <form method="POST" action="{{ route('supplier.quote.cancel', $quote->id) }}" class="mt-4">
        @csrf
        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to cancel this request?')">Cancel</button>
    </form>
</div>
@endsection

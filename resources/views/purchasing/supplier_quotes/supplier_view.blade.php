@extends('layouts.supplier')

@section('content')
<div class="container mt-5">
    <h3>Purchase Request #{{ $quote->purchaseRequest->request_number }}</h3>

    <div class="card mb-4">
        <div class="card-header">Items</div>
        <div class="card-body table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr><th>Product</th><th>Quantity</th><th>Unit Price</th><th>Total</th></tr>
                </thead>
                <tbody>
                    @foreach ($quote->purchaseRequest->items as $item)
                    <tr>
                        <td>{{ $item->product_name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>
                            @if ($quote->status === 'approved')
                                ${{ number_format($item->unit_price, 2) }}
                            @else
                                <input type="number" step="0.01" name="prices[{{ $item->id }}]" value="{{ $item->unit_price }}" class="form-control">
                            @endif
                        </td>
                        <td>${{ number_format($item->quantity * $item->unit_price, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <form method="POST" action="{{ route('supplier.purchase-request.respond') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="quote_id" value="{{ $quote->id }}">

        <div class="mb-3">
            <label>Attach Quote (optional)</label>
            <input type="file" name="attachment" class="form-control">
        </div>

        <div class="text-end mt-3">
            <button name="response_action" value="approve" class="btn btn-success">Approve</button>
            <button name="response_action" value="modify" class="btn btn-warning">Modify & Approve</button>
            <button name="response_action" value="cancel" class="btn btn-danger">Cancel</button>
        </div>
    </form>
</div>
@endsection

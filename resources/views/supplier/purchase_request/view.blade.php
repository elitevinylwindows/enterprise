@extends('layouts.supplier')

@section('content')
<div class="container mt-5">
    <h3>Elite Vinyl Windows — Purchase Request #{{ $request->request_no }}</h3>
    <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($request->created_at)->format('F j, Y') }}</p>
    <p><strong>Supplier:</strong> {{ $request->supplier->name }}</p>

    <table class="table table-bordered mt-4">
        <thead class="table-light">
            <tr>
                <th>Product</th>
                <th>UOM</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Total Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($request->items as $item)
            <tr>
                <td>{{ $item->product->name ?? '-' }}</td>
                <td>{{ $item->product->unit ?? '-' }}</td>
                <td>{{ $item->quantity }}</td>
                <td>${{ number_format($item->unit_price ?? 0, 2) }}</td>
                <td>${{ number_format(($item->unit_price ?? 0) * $item->quantity, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <hr>
    <h5>Actions</h5>
    <form action="{{ route('supplier.purchase_request.response', $request->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label>Upload Quote (PDF)</label>
            <input type="file" name="quote_file" class="form-control" accept="application/pdf" required>
        </div>

        <div class="mb-3">
            <label>Choose Action</label>
            <select name="response_action" class="form-control" required>
                <option value="approve">Approve</option>
                <option value="modify_and_approve">Modify & Approve</option>
                <option value="cancel">Cancel</option>
            </select>
        </div>

        <div id="priceEditSection" style="display: none;">
            <h6>Edit Prices</h6>
            @foreach ($request->items as $item)
                <div class="mb-2">
                    <label>{{ $item->product->name }}</label>
                    <input type="number" step="0.01" name="prices[{{ $item->id }}]" value="{{ $item->unit_price ?? 0 }}" class="form-control">
                </div>
            @endforeach
        </div>

        <button type="submit" class="btn btn-success mt-3">Submit Response</button>
    </form>
</div>

<script>
    document.querySelector('[name="response_action"]').addEventListener('change', function () {
        const priceSection = document.getElementById('priceEditSection');
        priceSection.style.display = this.value === 'modify_and_approve' ? 'block' : 'none';
    });
</script>
@endsection

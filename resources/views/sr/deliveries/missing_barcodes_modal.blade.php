<div>
    <h5>Missing Barcodes for Order #{{ $orderNumber }}</h5>
    @if ($missingBarcodes->count())
        <ul class="list-group">
            @foreach ($missingBarcodes as $barcode)
                <li class="list-group-item">{{ $barcode }}</li>
            @endforeach
        </ul>
    @else
        <p>No missing barcodes found.</p>
    @endif
</div>

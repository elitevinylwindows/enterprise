@extends('layouts.public')
@section('page-title')
{{ __('Secure Quote View') }}
@endsection

@section('breadcrumb')

@endsection

@section('card-action-btn')
@endsection

@section('content')

<div class="row">
    <div class="col-md-12 mt-4">
        <div class="card">
            <div class="card-header">
                <h5>{{ __('Quote Details') }}</h5>
            </div>
            <div class="card-body">
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
                            @foreach($quote->items as $item)
                            <tr>
                                <td>{{ $item->description ?? 'N/A' }}</td>
                                <td>{{ $item->qty }}</td>
                                <td>{{ $item->width }}" x {{ $item->height }}"</td>
                                <td>{{ $item->glass ?? 'N/A' }}</td>
                                <td>{{ $item->grid ?? 'N/A' }}</td>
                                <td>${{ number_format($item->price, 2) }}</td>
                                <td>${{ number_format($item->total, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">
                        <div class="col-md-6 offset-md-6">
                            <table class="table">
                                <tr>
                                    <th>Discount:</th>
                                    <td id="discount-amount">${{ number_format(0, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>Shipping:</th>
                                    <input type="hidden" id="shipping" value="{{ $quote->shipping }}">
                                    <td id="shipping-amount">${{ number_format(0, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>Subtotal:</th>
                                    <td id="subtotal-amount">
                                        $0.00
                                    </td>
                                </tr>
                                <tr>
                                    <th>Tax:</th>
                                    <td id="tax-amount">$0.00</td>
                                </tr>
                                <tr>
                                    <th>Total:</th>
                                    <td><strong id="total-amount">$0.00</strong></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <a href="{{ route('sales.quotes.update.status', ['id' => $quote->id, 'status' => 'approved']) }}" target="_blank" class="btn btn-primary">
                        <i class="fa fa-check"></i> Approve Quote
                    </a>
                    <a href="{{ route('sales.quotes.update.status', ['id' => $quote->id, 'status' => 'rejected']) }}" class="btn btn-primary ms-2">
                        <i class="fa fa-times"></i> Reject Quote
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Calculate totals on page load
            calculateTotals();
        });

        function calculateTotals(shipping = 0, modalOpen = false) {

         fetch('{{ route('calculate.total', ['quote_id' => $quote->id]) }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                shipping: parseFloat(document.getElementById('shipping').value) || 0
            })
        }).then(response => response.json()).then(data => {
            if (data.success) {
                if(modalOpen) {
                    var shipping = $('#shipping').val();
                    // If modal is open, update the totals in the modal
                    $('#discount-amount').text("$" + data.data.total_discount);

                    document.getElementById('sub-total-amount').textContent = '$' + data.data.sub_total;
                    document.getElementById('tax-amount-preview').textContent = '$' + data.data.tax + ' (' + data.data.tax_rate + '%)';
                    document.getElementById('shipping-amount').textContent = '$' + data.data.shipping;
                    document.getElementById('grand-total-amount').textContent = '$' + data.data.grand_total;
                } else {
                    // Update the UI with the new totals
                    $('#subtotal-amount').text('$' + data.data.sub_total);
                    $('#discount-amount').text("$" + data.data.total_discount);
                    $('#tax-amount').text('$' + data.data.tax + ' (' + data.data.tax_rate + '%)');
                    $('#total-amount').text('$' + data.data.grand_total);
                    document.getElementById('shipping-amount').textContent = '$' + data.data.shipping;
                    document.getElementById('tax').value = data.data.tax;
                    document.getElementById('subtotal').value = data.data.sub_total;
                    document.getElementById('tax').value = data.data.tax;
                    document.getElementById('total').value = data.data.grand_total;
                }
            } else {
                alert('Error calculating totals.');
            }
        }).catch(error => {
            console.error('Error fetching total:', error);
        });
    }
    </script>
@endpush
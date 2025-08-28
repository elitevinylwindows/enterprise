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
                    <th>Qty</th>
                    <th>Size</th>
                    <th style="width: 0%;">Glass</th>
                    <th style="width: 0%;">Grid</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($quote->items->where('is_modification', 0) as $index => $item)
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
                        <td id="discount-amount">-${{ number_format($quote->discount, 2) }}</td>
                    </tr>
                    <tr>
                        <th>Shipping:</th>
                        <td id="shipping-amount">${{ number_format($quote->shipping, 2) }}</td>
                    </tr>
                    <tr>
                        <th>Subtotal:</th>
                        <td id="sub-total-amount">
                            ${{ number_format($quote->sub_total, 2) }}
                        </td>
                    </tr>
                    <tr>
                        <th>Tax:</th>
                        <td id="tax-amount-preview">${{ number_format($quote->tax, 2) }}</td>
                    </tr>

                    <tr>
                        <th>Total:</th>
                        <td><strong id="grand-total-amount">${{ number_format($quote->total, 2) }}</strong></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal-footer">
  <button class="btn btn-primary" type="button" id="saveQuoteButton">Submit Quote</button>
</div>

<script>
document.getElementById('saveQuoteButton').addEventListener('click', async function () {
  const button = this;
  const originalText = button.innerHTML;
  button.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Submitting...';
  button.disabled = true;

  const formData = new FormData();
  formData.append('discount', document.getElementById('discount-amount').innerText.replace(/[$,]/g, ''));
  formData.append('subtotal', document.getElementById('sub-total-amount').innerText.replace(/[$,]/g, ''));
  formData.append('tax', document.getElementById('tax-amount-preview').innerText.replace(/[$,]/g, '').replace(/\s*\(.*\)/, ''));
  formData.append('shipping', document.getElementById('shipping-amount').innerText.replace(/[$,]/g, ''));
  formData.append('total', document.getElementById('grand-total-amount').innerText.replace(/[$,]/g, ''));
  formData.append('status', 'Quote Submitted');

  try {
    const resp = await fetch('{{ route('sales.quotes.save.draft', $quote->id) }}', {
      method: 'POST',
      body: formData,
      headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}',
        'Accept': 'application/json' // helps Laravel return JSON on errors
      }
    });
    const data = await resp.json();

    if (data.success) {
      // hide the modal
      const modalEl = button.closest('.modal');
      if (modalEl) {
        if (window.bootstrap?.Modal) {
          const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
          modal.hide();
        } else if (window.$ && typeof $(modalEl).modal === 'function') {
          $(modalEl).modal('hide'); // Bootstrap 4
        } else {
          // vanilla fallback
          modalEl.classList.remove('show');
          modalEl.style.display = 'none';
          document.body.classList.remove('modal-open');
          document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
        }
      }

      toastr.success('Draft saved successfully!', 'Success', { timeOut: 3000, progressBar: true, closeButton: true });

      // then navigate away if that's what you want
      window.location.href = '{{ route('sales.quotes.index') }}';
    } else {
      throw new Error('Save failed');
    }
  } catch (error) {
    console.error('Error:', error);
    button.innerHTML = originalText;
    button.disabled = false;
    toastr.error('Failed to save draft. Please try again.', 'Error', { timeOut: 3000, progressBar: true, closeButton: true });
  }
});
</script>

@extends('layouts.app')

@section('page-title')
{{ __('Quotes') }}
@endsection

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
<li class="breadcrumb-item active" aria-current="page">{{ __('Quotes') }}</li>
@endsection

@section('content')
<div class="mb-4"></div> {{-- Space after title --}}


<div class="mb-4"></div> {{-- Space --}}



<div class="row">
    {{-- Taskbar Card --}}
    <div class="col-md-2">
        <div class="card">
    <div class="list-group list-group-flush">
    <a href="{{ route('sales.quotes.index', ['status' => 'all']) }}" 
       class="list-group-item {{ $status === 'all' ? 'active' : '' }}">
       All Quotes
    </a>
    <a href="{{ route('sales.quotes.index', ['status' => 'draft']) }}" 
       class="list-group-item {{ $status === 'draft' ? 'active' : '' }}">
       Draft Quotes
    </a>
    <a href="{{ route('sales.quotes.index', ['status' => 'approved']) }}" 
       class="list-group-item {{ $status === 'approved' ? 'active' : '' }}">
       Approved Quotes
    </a>
    <a href="{{ route('sales.quotes.index', ['status' => 'deleted']) }}" 
       class="list-group-item text-danger {{ $status === 'deleted' ? 'active' : '' }}">
       Deleted
    </a>
</div>
        </div>
    </div>

    {{-- Main Content Card --}}
    <div class="col-sm-10">
        <div class="card table-card">
            <div class="card-header">
                <div class="row align-items-center g-2">
                    <div class="col">
                        <h5>{{ __('Quote List') }}</h5>
                    </div>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="dt-responsive table-responsive">
                    <table class="table table-hover advance-datatable" id="quotesTable">
                        <thead class="table-light">
                            <tr>
                                <th>Quote #</th>
                                <th>Customer</th>
                                <th>Entry Date</th>
                                <th>PO #</th>
                                <th>Reference</th>
                                <th>Total</th>
                                <th>Expires By</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
    @foreach ($quotes as $quote)
    <tr>
        <td>{{ $quote->quote_number }}</td>
        <td>{{ $quote->customer_name }}</td>
        <td>{{ $quote->entry_date }}</td>
        <td>{{ $quote->order?->order_number }}</td>
        <td>{{ $quote->reference }}</td>
        <td>${{ number_format($quote->total ?? 0, 2) }}</td>
        <td>{{ $quote->valid_until }}</td>
        <td>
            @if($quote->status === 'approved')
            <span class="badge bg-success">Approved</span>
            @elseif($quote->status === 'rejected')
            <span class="badge bg-danger">Rejected</span>
            @elseif($quote->status === 'sent')
            <span class="badge bg-success">Sent</span>
            @elseif($quote->status === 'draft')
            <span class="badge bg-secondary">Draft</span>
            @else
            <span class="badge bg-light text-muted">{{ ucfirst($quote->status) }}</span>
            @endif
        </td>
        <td class="text-nowrap">
            @if($status === 'deleted')
                {{-- Restore Button --}}
                <form action="{{ route('sales.quotes.restore', $quote->id) }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="avtar avtar-xs btn-link-success text-success border-0 bg-transparent p-0" data-bs-toggle="tooltip" data-bs-original-title="Restore">
                        <i data-feather="rotate-ccw"></i>
                    </button>
                </form>
                
                {{-- Permanent Delete Button --}}
                <form action="{{ route('sales.quotes.force-delete', $quote->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="avtar avtar-xs btn-link-danger text-danger border-0 bg-transparent p-0" 
                            data-bs-toggle="tooltip" data-bs-original-title="Delete Permanently"
                            onclick="return confirm('Permanently delete this quote?')">
                        <i data-feather="trash-2"></i>
                    </button>
                </form>
            @else
                {{-- Original Action Buttons --}}
                <a class="avtar avtar-xs btn-link-success text-success customModal" data-bs-toggle="tooltip" data-bs-original-title="View Summary" href="#" data-size="xl" data-url="{{ route('sales.quotes.view', $quote->id) }}" data-title="Quote Summary">
                    <i data-feather="eye"></i>
                </a>

                @if($quote->status !== 'approved')
                {{-- Edit --}}
                <a class="avtar avtar-xs btn-link-primary text-primary" data-bs-toggle="tooltip" data-bs-original-title="Edit" href="{{ route('sales.quotes.edit', $quote->id) }}" data-title="Edit Quote">
                    <i data-feather="edit"></i>
                </a>
                @endif
                {{-- View --}}

                {{-- Email --}}
                <a class="avtar avtar-xs btn-link-warning text-warning emailButton" data-bs-toggle="tooltip" data-bs-original-title="Email" href="#" data-size="md" data-url="{{ route('sales.quotes.email', $quote->id) }}" data-title="Send Email">
                    <i data-feather="mail" id="emailIcon"></i>
                    <span class="spinner-border spinner-border-sm d-none" id="emailSpinner"></span>
                </a>

                {{-- Orders --}}
                @if(!$quote->order)
                <a href="{{ route('sales.quotes.convertToOrder', ['id' => $quote->id]) }}" class="avtar avtar-xs btn-link-info text-info" data-bs-toggle="tooltip" data-bs-original-title="Convert to Order">
                    <i data-feather="shopping-cart"></i>
                </a>
                @endif

                {{-- Delete --}}
                <form action="{{ route('sales.quotes.destroy', $quote->id) }}" method="POST" style="display:inline;" class="delete-quote-form">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="avtar avtar-xs btn-link-danger text-danger border-0 bg-transparent p-0 delete-quote-btn" data-bs-toggle="tooltip" data-bs-original-title="Delete">
                        <i data-feather="trash-2"></i>
                    </button>
                </form>
            @endif
        </td>
    </tr>
    @endforeach
</tbody>



                    </table>
                </div> <!-- table-responsive -->
            </div> <!-- card-body -->
        </div> <!-- card -->
    </div> <!-- col -->


</div>
@endsection

@push('scripts')

<script>
    $(document).ready(function() {

        // Add click handler for the email button
        $('.emailButton').on('click', function(e) {
            e.preventDefault();

            const $button = $(this);
            const $icon = $button.find('#emailIcon');
            const $spinner = $button.find('.spinner-border');
            const url = $button.data('url');

            // Show spinner and hide icon
            $icon.addClass('d-none');
            $spinner.removeClass('d-none');
            $button.prop('disabled', true);

            $.ajax({
                url: url
                , type: 'GET'
                , data: {
                    _token: '{{ csrf_token() }}'
                }
                , success: function(response) {
                    toastr.success('Email sent successfully!', 'Success', {
                        timeOut: 3000
                        , progressBar: true
                        , closeButton: true
                    });
                }
                , error: function(xhr) {
                    toastr.error('Failed to send email. Please try again.', 'Error', {
                        timeOut: 3000
                        , progressBar: true
                        , closeButton: true
                    });
                }
                , complete: function() {
                    // Always hide spinner and show icon when request is complete
                    $spinner.addClass('d-none');
                    $icon.removeClass('d-none');
                    $button.prop('disabled', false);
                }
            });
        });

        // Delete quote with confirmation
        $('.delete-quote-btn').on('click', function(e) {
            e.preventDefault();
            const $form = $(this).closest('form');
            if (confirm('Are you sure you want to delete this quote?')) {
            $form.submit();
            }
        });
    });

</script>
@endpush

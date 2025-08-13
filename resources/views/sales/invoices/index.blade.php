@extends('layouts.app')

@section('page-title')
{{ __('Invoices') }}
@endsection

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
<li class="breadcrumb-item active" aria-current="page">{{ __('Orders') }}</li>
@endsection

@section('content')
<div class="mb-4"></div> {{-- Space after title --}}


<div class="mb-4"></div> {{-- Space --}}



<div class="row">
    {{-- Taskbar Card --}}
    <div class="col-md-2">
        <div class="card">
            <div class="list-group list-group-flush">
                <a href="{{ route('sales.invoices.index', ['status' => 'all']) }}" class="list-group-item {{ $status === 'all' ? 'active' : '' }}">
                    All Invoices
                </a>
                <a href="{{ route('sales.invoices.index', ['status' => 'pending']) }}" class="list-group-item {{ $status === 'pending' ? 'active' : '' }}">
                    Pending Invoices
                </a>
                <a href="{{ route('sales.invoices.index', ['status' => 'partially_paid']) }}" class="list-group-item {{ $status === 'partially_paid' ? 'active' : '' }}">
                    Partially Paid Invoices
                </a>
                <a href="{{ route('sales.invoices.index', ['status' => 'fully_paid']) }}" class="list-group-item {{ $status === 'fully_paid' ? 'active' : '' }}">
                    Fully Paid Invoices
                </a>
                <a href="{{ route('sales.invoices.index', ['status' => 'deleted']) }}" class="list-group-item text-danger {{ $status === 'deleted' ? 'active' : '' }}">
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
                        <h5>{{ __('Invoices List') }}</h5>
                    </div>
                    <div class="col-auto ms-auto">
                        <a href="javascript:void(0);" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createOrderModal">
                            <i class="fa-solid fa-paper-plane"></i> Send to Quickbooks
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="dt-responsive table-responsive">
                    <table class="table table-hover advance-datatable" id="invoicesTable">
                        <thead class="table-light">
                            <tr>
                                <th>{{ __('Invoice #') }}</th>
                                <th>{{ __('Order #') }}</th>
                                <th>{{ __('Quote #') }}</th>
                                <th>{{ __('Customer #') }}</th>
                                <th>{{ __('Customer Name') }}</th>
                                <th>{{ __('Invoice Date') }}</th>
                                <th>{{ __('Total') }}</th>
                                <th>{{ __('Paid Amount') }}</th>
                                <th>{{ __('Balance') }}</th>
                                <th>{{ __('Payment Type') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($invoices as $invoice)
                            <tr>
                                <td>{{ $invoice->invoice_number }}</td>
                                <td>{{ $invoice->order->order_number ?? 'N/A' }}</td>
                                <td>{{ $invoice->quote->quote_number ?? 'N/A' }}</td>
                                <td>{{ $invoice->customer->customer_number ?? 'N/A' }}</td>
                                <td>{{ $invoice->customer->customer_name ?? 'N/A' }}</td>
                                <td>{{ $invoice->invoice_date }}</td>
                                <td>${{ number_format($invoice->total ?? 0, 2) }}</td>
                                <td>${{ number_format($invoice->paid_amount ?? 0, 2) }}</td>
                                <td>${{ number_format($invoice->remaining_amount ?? 0, 2) }}</td>
                                <td>{{ ucfirst($invoice->payment_method)}}</td>
                                <td>
                                    @if($status === 'deleted')
                                    <span class="badge bg-danger">Deleted</span>
                                    @else
                                    @if($invoice->paid === 'paid')
                                    <span class="badge bg-success">Active</span>
                                    @elseif($invoice->status === 'warning')
                                    <span class="badge bg-warning">error</span>
                                    @elseif($invoice->status === 'declined')
                                    <span class="badge bg-danger">declined</span>
                                    @else
                                    <span class="badge bg-light text-muted">{{ ucfirst($invoice->status) }}</span>
                                    @endif
                                    @endif
                                </td>
                                <td class="text-nowrap">
                                    @if($status === 'deleted')
                                    {{-- Restore Button --}}
                                    <form action="{{ route('sales.invoices.restore', $invoice->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="avtar avtar-xs btn-link-success text-success border-0 bg-transparent p-0" data-bs-toggle="tooltip" data-bs-original-title="Restore">
                                            <i data-feather="rotate-ccw"></i>
                                        </button>
                                    </form>

                                    {{-- Permanent Delete Button --}}
                                    <form action="{{ route('sales.invoices.force-delete', $invoice->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="avtar avtar-xs btn-link-danger text-danger border-0 bg-transparent p-0" data-bs-toggle="tooltip" data-bs-original-title="Delete Permanently" onclick="return confirm('Permanently delete this invoice?')">
                                            <i data-feather="trash-2"></i>
                                        </button>
                                    </form>
                                    @else
                                    {{-- Original Action Buttons --}}
                                    {{-- View --}}
                                    <a class="avtar avtar-xs btn-link-success text-success customModal" data-bs-toggle="tooltip" data-bs-original-title="View Invoice" href="#" data-size="xl" data-url="{{ route('sales.invoices.show', $invoice->id) }}" data-title="Invoice Summary">
                                        <i data-feather="eye"></i>
                                    </a>

                                    {{-- Send to QB --}}
                                    <a class="avtar avtar-xs btn-link-success text-success" data-bs-toggle="tooltip" data-bs-original-title="Send to QuickBooks" href="{{ route('sales.invoices.sendToQuickBooks', $invoice->id) }}" data-title="Send to Quickbooks">
                                        <i data-feather="share"></i>
                                    </a>

                                    {{-- Email --}}
                                    <a class="avtar avtar-xs btn-link-warning text-warning" data-bs-toggle="tooltip" data-bs-original-title="Email" href="{{route('sales.invoices.email', $invoice->id)}}" data-title="Send Email">
                                        <i data-feather="mail"></i>
                                    </a>

                                    {{-- Take Payment --}}
                                    <a class="avtar avtar-xs btn-link-success text-success customModal" data-bs-toggle="tooltip" title="Request Payment" href="#" data-size="lg" data-url="{{ route('sales.invoices.payment', $invoice->id) }}" data-title="Invoice Payment">
                                        <i data-feather="credit-card"></i>
                                    </a>

                                    {{-- Edit --}}
                                    <a class="avtar avtar-xs btn-link-primary text-primary customModal" data-bs-toggle="tooltip" data-bs-original-title="Edit" href="#" data-size="xl" data-url="{{ route('sales.invoices.edit', $invoice->id) }}" data-title="Edit Invoice">
                                        <i data-feather="edit"></i>
                                    </a>
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

        @if($errors->any())
        @foreach($errors->all() as $error)
        toastr.error('{{ $error }}', 'Error', {
            timeOut: 3000
            , progressBar: true
            , closeButton: true
        });
        @endforeach
        @endif


        @if(session('error'))
        toastr.error('{{ session('
            error ') }}', 'Error', {
                timeOut: 3000
                , progressBar: true
                , closeButton: true
            });
        @endif
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

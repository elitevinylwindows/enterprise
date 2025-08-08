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
                <a href="{{ route('sales.invoices.index', ['status' => 'all']) }}" class="list-group-item">All Invoices</a>
                <a href="{{ route('sales.invoices.index', ['status' => 'paid']) }}" class="list-group-item">Paid Invoices</a>
                <a href="{{ route('sales.invoices.index', ['status' => 'deleted']) }}" class="list-group-item text-danger">Deleted</a>

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
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="dt-responsive table-responsive">
                    <table class="table table-hover advance-datatable" id="quotesTable">
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
                                <th>{{ __('Remaining Amount') }}</th>
                                <th>{{ __('Required Payment Type') }}</th>
                                <th>{{ __('Required Payment') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Notes') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($invoices as $invoice)
                            <tr>
                                <td>{{ $invoice->invoice_number }}</td>
                                <td>{{ $invoice->order->order_number }}</td>
                                <td>{{ $invoice->quote->quote_number }}</td>
                                <td>{{ $invoice->customer->customer_number }}</td>
                                <td>{{ $invoice->customer->customer_name }}</td>
                                <td>{{ $invoice->invoice_date }}</td>
                                <td>${{ number_format($invoice->total ?? 0, 2) }}</td>
                                <td>{{ $invoice->paid_amount }}</td>
                                <td>{{ $invoice->remaining_amount }}</td>
                                <td>{{ $invoice->required_payment_type }}</td>
                                <td>{{ $invoice->required_payment_type === 'percentage' ? "%".$invoice->required_payment_percentage. ' ($'.$invoice->required_payment.')' : "$".number_format($invoice->required_payment, 2) }}</td>
                                <td>
                                    @if($invoice->status === 'active')
                                    <span class="badge bg-success">Active</span>
                                    @elseif($invoice->status === 'draft')
                                    <span class="badge bg-secondary">Draft</span>
                                    @else
                                    <span class="badge bg-light text-muted">{{ ucfirst($invoice->status) }}</span>
                                    @endif
                                </td>
                                <td>{{ $invoice->quote->notes }}</td>
                                <td class="text-nowrap">
                                    {{-- View --}}
                                    <a class="avtar avtar-xs btn-link-success text-success customModal"
                                           data-bs-toggle="tooltip"
                                           data-bs-original-title="View Invoice"
                                           href="#"
                                           data-size="xl"
                                           data-url="{{ route('sales.invoices.show', $invoice->id) }}"
                                           data-title="Invoice Summary">
                                            <i data-feather="eye"></i>
</a>

                                    {{-- Send to QB --}}
                                    <a class="avtar avtar-xs btn-link-success text-success "
                                        data-bs-toggle="tooltip" data-bs-original-title="Send to QuickBooks" href="{{route('sales.invoices.sendToQuickBooks', $invoice->id)}}"
                                        data-title="Send to Quickbooks">
                                        <i data-feather="share"></i>
                                    </a>


                                    {{-- Email --}}
                                    <a class="avtar avtar-xs btn-link-warning text-warning customModal"
                                        data-bs-toggle="tooltip" data-bs-original-title="Email" href="#" data-size="md"
                                        data-url="" data-title="Send Email">
                                        <i data-feather="mail"></i>
                                    </a>

                                        {{-- Take Payment --}}
                                    <a class="avtar avtar-xs btn-link-success text-success customModal"
                                        data-bs-toggle="tooltip"
                                        title="Make Payment"
                                        href="#"
                                        data-size="lg"
                                        data-url="{{ route('sales.invoices.payment', $invoice->id) }}"
                                        data-title="Invoice Payment">
                                        <i data-feather="credit-card"></i>
                                    </a>


                                    {{-- Edit --}}
                                        <a class="avtar avtar-xs btn-link-primary text-primary customModal"
                                           data-bs-toggle="tooltip"
                                           data-bs-original-title="Edit"
                                           href="#"
                                           data-size="xl"
                                           data-url="{{ route('sales.invoices.edit', $invoice->id) }}"
                                           data-title="Edit Invoice">
                                            <i data-feather="edit"></i>
                                        </a>
                                        <!--
                                        {{-- Billing --}}
                                        <a class="avtar avtar-xs btn-link-info text-info"
                                           data-bs-toggle="tooltip"
                                           data-bs-original-title="Billing"
                                           href="{{ route('sales.invoices.index', ['billing' => $invoice->id]) }}">
                                            <i data-feather="shopping-cart"></i>
                                        </a>

                                        {{-- Delete --}}
                                        <a class="avtar avtar-xs btn-link-danger text-danger customModal"
                                           data-bs-toggle="tooltip"
                                           data-bs-original-title="Delete"
                                           href="#"
                                           data-size="md"
                                           data-url="{{ route('sales.invoices.destroy', $invoice->id) }}"
                                           data-title="Delete Invoice">
                                            <i data-feather="trash-2"></i>
                                        </a>-->
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






























@extends('layouts.app')

@section('page-title')
    {{ __('Orders') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item" aria-current="page"> {{ __('Orders') }}</li>
@endsection

@section('card-action-btn')
<form action="{{ route('orders.import') }}" method="POST" enctype="multipart/form-data" class="d-inline-block">
    @csrf
    <input type="file" name="import_file" accept=".csv, .xls, .xlsx" required class="form-control d-inline-block w-auto">
    <button type="submit" class="btn btn-sm btn-primary">
        <i data-feather="upload"></i> Import Orders
    </button>
</form>

     <!-- <a class="btn btn-outline-primary btn-sm" href="{{ route('orders.import') }}">
        <i class="ti ti-upload"></i> {{ __('Import Orders') }}
    </a>
  <a class="btn btn-outline-success btn-sm" href="{{ route('orders.create') }}">
        <i class="ti ti-plus"></i> {{ __('Add Order') }}
    </a>-->
@endsection

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card table-card">
            <div class="card-header">
                <div class="row align-items-center g-2">
                    <div class="col">
                        <h5>{{ __('Orders') }}</h5>
                    </div>
                </div>
            </div>

            <div class="card-body pt-0">
                <div class="dt-responsive table-responsive">
                    <table class="table table-hover advance-datatable" id="ordersTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Order #</th>
                                <th>Srt Name</th>
                                <th>Customer</th>
                                <th>Customer Name</th>
                                <th>City</th>
                                <th>Units</th>
                                <th>Comment</th>
                                <th>Commission</th>
                                <th>Delivery Date</th>
                                <th>Area</th>
                                <th>Total</th>
                                <th># of Fields</th>
                                <th>Archived</th>
                                <th>Arrival Date</th>
                                <th>Arrival Variation</th>
                                <th>Canceled</th>
                                <th>Classification</th>
                                <th>Commercial Site</th>
                                <th>Complete Receipt</th>
                                <th>Completed</th>
                                <th>Completely Invoiced</th>
                                <th>Created At</th>
                                <th>Credit Limit Block</th>
                                <th>Credit Note Exists</th>
                                <th>Currency</th>
                                <th>CW</th>
                                <th>Dealer #</th>
                                <th>Delivery Condition</th>
                                <th>Delivery Date Calc. Mode</th>
                                <th>Delivery Note Exists</th>
                                <th>Delivery Note Printed</th>
                                <th>Deposit Invoice Exists</th>
                                <th>Dispatch Planned</th>
                                <th>Edit Status</th>
                                <th>End of Appeal Period</th>
                                <th>Entered By</th>
                                <th>Entry Date</th>
                                <th>Entry Date (Original)</th>
                                <th>External Manufacturing</th>
                                <th>External Reference Order</th>
                                <th>Factory Assignment Undefined</th>
                                <th>ID</th>
                                <th>Import Assignment</th>
                                <th>In-house Manufacturing</th>
                                <th>Input Type</th>
                                <th>Inside Sales</th>
                                <th>Installation/Service Scheduled</th>
                                <th>Installation Area</th>
                                <th>Internal Invoice Exists</th>
                                <th>Internal Order #</th>
                                <th>Internal Order Number</th>
                                <th>Invoice Exists</th>
                                <th>Invoice Has Been Paid</th>
                                <th>Invoice Printed</th>
                                <th>Is Delivery</th>
                                <th>Manual Lock</th>
                                <th>Max. Arrival Date (Delivery Note)</th>
                                <th>Min. Arrival Date (Delivery Note)</th>
                                <th>Name</th>
                                <th>Name 2</th>
                                <th>Net Price</th>
                                <th>Net Price In Own Currency</th>
                                <th>Number Of Fields</th>
                                <th>Object Type</th>
                                <th>Order # (Commercial Site)</th>
                                <th>Order Complete</th>
                                <th>Order Confirmation Printed</th>
                                <th>Order Type</th>
                                <th>Origin</th>
                                <th>Outside Sales</th>
                                <th>Payment Method</th>
                                <th>Print Date</th>
                                <th>Prod. Status (Color)</th>
                                <th>Production</th>
                                <th>Production Site</th>
                                <th>Production Status</th>
                                <th>Production Status Color</th>
                                <th>Project #</th>
                                <th>Project Number</th>
                                <th>Purchase Order Date</th>
                                <th>Reference</th>
                                <th>Required Date</th>
                                <th>Required Date (CW)</th>
                                <th>Schedule Status</th>
                                <th>Scheduling</th>
                                <th>Shipping Stages</th>
                                <th>Status</th>
                                <th>Status Code</th>
                                <th>Tax</th>
                                <th>Tax Rule</th>
                                <th>Tech. Handling</th>
                                <th>Total In Own Currency</th>
                                <th>Total In Row</th>
                                <th>Total Including</th>
                                <th>Total Including Tax</th>
                                <th>Updated At</th>
                                <th>Validity Date</th>
                                <th>Waiting For Change Order</th>
                                <th>Waiting For Secondary Plant</th>
                                <th>Window Order Printed/Exported</th>
                                <th>ZIP</th>
                            <!--    <th>Action</th>-->
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $order->order_number }}</td>
                                    <td>{{ $order->short_name }}</td>
                                    <td>{{ $order->customer }}</td>
                                    <td>{{ $order->customer_name }}</td>
                                    <td>{{ $order->city }}</td>
                                    <td>{{ $order->units }}</td>
                                    <td>{{ $order->comment }}</td>
                                    <td>{{ $order->commission }}</td>
                                    <td>{{ $order->delivery_date }}</td>
                                    <td>{{ $order->area }}</td>
                                    <td>{{ $order->total }}</td>
                                    <td>{{ $order->of_fields }}</td>
                                    <td>{{ $order->archived }}</td>
                                    <td>{{ $order->arrival_date }}</td>
                                    <td>{{ $order->arrival_variation }}</td>
                                    <td>{{ $order->canceled }}</td>
                                    <td>{{ $order->classification }}</td>
                                    <td>{{ $order->commercial_site }}</td>
                                    <td>{{ $order->complete_receipt }}</td>
                                    <td>{{ $order->completed }}</td>
                                    <td>{{ $order->completely_invoiced }}</td>
                                    <td>{{ $order->created_at }}</td>
                                    <td>{{ $order->credit_limit_block }}</td>
                                    <td>{{ $order->credit_note_exists }}</td>
                                    <td>{{ $order->currency }}</td>
                                    <td>{{ $order->cw }}</td>
                                    <td>{{ $order->dealer }}</td>
                                    <td>{{ $order->delivery_condition }}</td>
                                    <td>{{ $order->delivery_date_calc_mode }}</td>
                                    <td>{{ $order->delivery_note_exists }}</td>
                                    <td>{{ $order->delivery_note_printed }}</td>
                                    <td>{{ $order->deposit_invoice_exists }}</td>
                                    <td>{{ $order->dispatch_planned }}</td>
                                    <td>{{ $order->edit_status }}</td>
                                    <td>{{ $order->end_of_appeal_period }}</td>
                                    <td>{{ $order->entered_by }}</td>
                                    <td>{{ $order->entry_date }}</td>
                                    <td>{{ $order->entry_date_original }}</td>
                                    <td>{{ $order->external_manufacturing }}</td>
                                    <td>{{ $order->external_reference_order }}</td>
                                    <td>{{ $order->factory_assignment_undefined }}</td>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->import_assignment }}</td>
                                    <td>{{ $order->in_house_manufacturing }}</td>
                                    <td>{{ $order->input_type }}</td>
                                    <td>{{ $order->inside_sales }}</td>
                                    <td>{{ $order->installation_service_scheduled }}</td>
                                    <td>{{ $order->installation_area }}</td>
                                    <td>{{ $order->internal_invoice_exists }}</td>
                                    <td>{{ $order->internal_order }}</td>
                                    <td>{{ $order->internal_order_number }}</td>
                                    <td>{{ $order->invoice_exists }}</td>
                                    <td>{{ $order->invoice_has_been_paid }}</td>
                                    <td>{{ $order->invoice_printed }}</td>
                                    <td>{{ $order->is_delivery }}</td>
                                    <td>{{ $order->manual_lock }}</td>
                                    <td>{{ $order->max_arrival_date_delivery_note }}</td>
                                    <td>{{ $order->min_arrival_date_delivery_note }}</td>
                                    <td>{{ $order->name }}</td>
                                    <td>{{ $order->name_2 }}</td>
                                    <td>{{ $order->net_price }}</td>
                                    <td>{{ $order->net_price_in_own_currency }}</td>
                                    <td>{{ $order->number_of_fields }}</td>
                                    <td>{{ $order->object_type }}</td>
                                    <td>{{ $order->order_commercial_site }}</td>
                                    <td>{{ $order->order_complete }}</td>
                                    <td>{{ $order->order_confirmation_printed }}</td>
                                    <td>{{ $order->order_type }}</td>
                                    <td>{{ $order->origin }}</td>
                                    <td>{{ $order->outside_sales }}</td>
                                    <td>{{ $order->payment_method }}</td>
                                    <td>{{ $order->print_date }}</td>
                                    <td>{{ $order->prod_status_color }}</td>
                                    <td>{{ $order->production }}</td>
                                    <td>{{ $order->production_site }}</td>
                                    <td>{{ $order->production_status }}</td>
                                    <td>{{ $order->production_status_color }}</td>
                                    <td>{{ $order->project }}</td>
                                    <td>{{ $order->project_number }}</td>
                                    <td>{{ $order->purchase_order_date }}</td>
                                    <td>{{ $order->reference }}</td>
                                    <td>{{ $order->required_date }}</td>
                                    <td>{{ $order->required_date_cw }}</td>
                                    <td>{{ $order->schedule_status }}</td>
                                    <td>{{ $order->scheduling }}</td>
                                    <td>{{ $order->shipping_stages }}</td>
                                    <td>{{ $order->status }}</td>
                                    <td>{{ $order->status_code }}</td>
                                    <td>{{ $order->tax }}</td>
                                    <td>{{ $order->tax_rule }}</td>
                                    <td>{{ $order->tech_handling }}</td>
                                    <td>{{ $order->total_in_own_currency }}</td>
                                    <td>{{ $order->total_in_row }}</td>
                                    <td>{{ $order->total_including }}</td>
                                    <td>{{ $order->total_including_tax }}</td>
                                    <td>{{ $order->updated_at }}</td>
                                    <td>{{ $order->validity_date }}</td>
                                    <td>{{ $order->waiting_for_change_order }}</td>
                                    <td>{{ $order->waiting_for_secondary_plant }}</td>
                                    <td>{{ $order->window_order_printed_exported }}</td>
                                    <td>{{ $order->zip }}</td>
                                <!--    <td>
                                        <div class="cart-action">
                                            <a class="avtar avtar-xs btn-link-warning text-warning customModal"
                                                data-bs-toggle="tooltip" title="{{ __('Details') }}" href="#"
                                                data-size="lg" data-url="{{ route('orders.show', $order->id) }}"
                                                data-title="{{ __('Order Details') }}">
                                                <i data-feather="eye"></i>
                                            </a>
                                            <a class="avtar avtar-xs btn-link-secondary text-secondary customModal"
                                                data-bs-toggle="tooltip" title="{{ __('Edit') }}" href="#"
                                                data-size="lg" data-url="{{ route('orders.edit', $order->id) }}"
                                                data-title="{{ __('Edit Order') }}">
                                                <i data-feather="edit"></i>
                                            </a>
                                            <a class="avtar avtar-xs btn-link-danger text-danger confirm_dialog"
                                                data-bs-toggle="tooltip" title="{{ __('Delete') }}"
                                                data-url="{{ route('orders.destroy', $order->id) }}"
                                                data-confirm="{{ __('Are you sure?') }}">
                                                <i data-feather="trash-2"></i>
                                            </a>
                                        </div>
                                    </td>-->
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


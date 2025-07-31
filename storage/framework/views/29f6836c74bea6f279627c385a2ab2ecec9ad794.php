<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Orders')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item" aria-current="page"> <?php echo e(__('Orders')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('card-action-btn'); ?>
<form action="<?php echo e(route('orders.import')); ?>" method="POST" enctype="multipart/form-data" class="d-inline-block">
    <?php echo csrf_field(); ?>
    <input type="file" name="import_file" accept=".csv, .xls, .xlsx" required class="form-control d-inline-block w-auto">
    <button type="submit" class="btn btn-sm btn-primary">
        <i data-feather="upload"></i> Import Orders
    </button>
</form>

     <!-- <a class="btn btn-outline-primary btn-sm" href="<?php echo e(route('orders.import')); ?>">
        <i class="ti ti-upload"></i> <?php echo e(__('Import Orders')); ?>

    </a>
  <a class="btn btn-outline-success btn-sm" href="<?php echo e(route('orders.create')); ?>">
        <i class="ti ti-plus"></i> <?php echo e(__('Add Order')); ?>

    </a>-->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-sm-12">
        <div class="card table-card">
            <div class="card-header">
                <div class="row align-items-center g-2">
                    <div class="col">
                        <h5><?php echo e(__('Orders')); ?></h5>
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
                            <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($loop->iteration); ?></td>
                                    <td><?php echo e($order->order_number); ?></td>
                                    <td><?php echo e($order->short_name); ?></td>
                                    <td><?php echo e($order->customer); ?></td>
                                    <td><?php echo e($order->customer_name); ?></td>
                                    <td><?php echo e($order->city); ?></td>
                                    <td><?php echo e($order->units); ?></td>
                                    <td><?php echo e($order->comment); ?></td>
                                    <td><?php echo e($order->commission); ?></td>
                                    <td><?php echo e($order->delivery_date); ?></td>
                                    <td><?php echo e($order->area); ?></td>
                                    <td><?php echo e($order->total); ?></td>
                                    <td><?php echo e($order->of_fields); ?></td>
                                    <td><?php echo e($order->archived); ?></td>
                                    <td><?php echo e($order->arrival_date); ?></td>
                                    <td><?php echo e($order->arrival_variation); ?></td>
                                    <td><?php echo e($order->canceled); ?></td>
                                    <td><?php echo e($order->classification); ?></td>
                                    <td><?php echo e($order->commercial_site); ?></td>
                                    <td><?php echo e($order->complete_receipt); ?></td>
                                    <td><?php echo e($order->completed); ?></td>
                                    <td><?php echo e($order->completely_invoiced); ?></td>
                                    <td><?php echo e($order->created_at); ?></td>
                                    <td><?php echo e($order->credit_limit_block); ?></td>
                                    <td><?php echo e($order->credit_note_exists); ?></td>
                                    <td><?php echo e($order->currency); ?></td>
                                    <td><?php echo e($order->cw); ?></td>
                                    <td><?php echo e($order->dealer); ?></td>
                                    <td><?php echo e($order->delivery_condition); ?></td>
                                    <td><?php echo e($order->delivery_date_calc_mode); ?></td>
                                    <td><?php echo e($order->delivery_note_exists); ?></td>
                                    <td><?php echo e($order->delivery_note_printed); ?></td>
                                    <td><?php echo e($order->deposit_invoice_exists); ?></td>
                                    <td><?php echo e($order->dispatch_planned); ?></td>
                                    <td><?php echo e($order->edit_status); ?></td>
                                    <td><?php echo e($order->end_of_appeal_period); ?></td>
                                    <td><?php echo e($order->entered_by); ?></td>
                                    <td><?php echo e($order->entry_date); ?></td>
                                    <td><?php echo e($order->entry_date_original); ?></td>
                                    <td><?php echo e($order->external_manufacturing); ?></td>
                                    <td><?php echo e($order->external_reference_order); ?></td>
                                    <td><?php echo e($order->factory_assignment_undefined); ?></td>
                                    <td><?php echo e($order->id); ?></td>
                                    <td><?php echo e($order->import_assignment); ?></td>
                                    <td><?php echo e($order->in_house_manufacturing); ?></td>
                                    <td><?php echo e($order->input_type); ?></td>
                                    <td><?php echo e($order->inside_sales); ?></td>
                                    <td><?php echo e($order->installation_service_scheduled); ?></td>
                                    <td><?php echo e($order->installation_area); ?></td>
                                    <td><?php echo e($order->internal_invoice_exists); ?></td>
                                    <td><?php echo e($order->internal_order); ?></td>
                                    <td><?php echo e($order->internal_order_number); ?></td>
                                    <td><?php echo e($order->invoice_exists); ?></td>
                                    <td><?php echo e($order->invoice_has_been_paid); ?></td>
                                    <td><?php echo e($order->invoice_printed); ?></td>
                                    <td><?php echo e($order->is_delivery); ?></td>
                                    <td><?php echo e($order->manual_lock); ?></td>
                                    <td><?php echo e($order->max_arrival_date_delivery_note); ?></td>
                                    <td><?php echo e($order->min_arrival_date_delivery_note); ?></td>
                                    <td><?php echo e($order->name); ?></td>
                                    <td><?php echo e($order->name_2); ?></td>
                                    <td><?php echo e($order->net_price); ?></td>
                                    <td><?php echo e($order->net_price_in_own_currency); ?></td>
                                    <td><?php echo e($order->number_of_fields); ?></td>
                                    <td><?php echo e($order->object_type); ?></td>
                                    <td><?php echo e($order->order_commercial_site); ?></td>
                                    <td><?php echo e($order->order_complete); ?></td>
                                    <td><?php echo e($order->order_confirmation_printed); ?></td>
                                    <td><?php echo e($order->order_type); ?></td>
                                    <td><?php echo e($order->origin); ?></td>
                                    <td><?php echo e($order->outside_sales); ?></td>
                                    <td><?php echo e($order->payment_method); ?></td>
                                    <td><?php echo e($order->print_date); ?></td>
                                    <td><?php echo e($order->prod_status_color); ?></td>
                                    <td><?php echo e($order->production); ?></td>
                                    <td><?php echo e($order->production_site); ?></td>
                                    <td><?php echo e($order->production_status); ?></td>
                                    <td><?php echo e($order->production_status_color); ?></td>
                                    <td><?php echo e($order->project); ?></td>
                                    <td><?php echo e($order->project_number); ?></td>
                                    <td><?php echo e($order->purchase_order_date); ?></td>
                                    <td><?php echo e($order->reference); ?></td>
                                    <td><?php echo e($order->required_date); ?></td>
                                    <td><?php echo e($order->required_date_cw); ?></td>
                                    <td><?php echo e($order->schedule_status); ?></td>
                                    <td><?php echo e($order->scheduling); ?></td>
                                    <td><?php echo e($order->shipping_stages); ?></td>
                                    <td><?php echo e($order->status); ?></td>
                                    <td><?php echo e($order->status_code); ?></td>
                                    <td><?php echo e($order->tax); ?></td>
                                    <td><?php echo e($order->tax_rule); ?></td>
                                    <td><?php echo e($order->tech_handling); ?></td>
                                    <td><?php echo e($order->total_in_own_currency); ?></td>
                                    <td><?php echo e($order->total_in_row); ?></td>
                                    <td><?php echo e($order->total_including); ?></td>
                                    <td><?php echo e($order->total_including_tax); ?></td>
                                    <td><?php echo e($order->updated_at); ?></td>
                                    <td><?php echo e($order->validity_date); ?></td>
                                    <td><?php echo e($order->waiting_for_change_order); ?></td>
                                    <td><?php echo e($order->waiting_for_secondary_plant); ?></td>
                                    <td><?php echo e($order->window_order_printed_exported); ?></td>
                                    <td><?php echo e($order->zip); ?></td>
                                <!--    <td>
                                        <div class="cart-action">
                                            <a class="avtar avtar-xs btn-link-warning text-warning customModal"
                                                data-bs-toggle="tooltip" title="<?php echo e(__('Details')); ?>" href="#"
                                                data-size="lg" data-url="<?php echo e(route('orders.show', $order->id)); ?>"
                                                data-title="<?php echo e(__('Order Details')); ?>">
                                                <i data-feather="eye"></i>
                                            </a>
                                            <a class="avtar avtar-xs btn-link-secondary text-secondary customModal"
                                                data-bs-toggle="tooltip" title="<?php echo e(__('Edit')); ?>" href="#"
                                                data-size="lg" data-url="<?php echo e(route('orders.edit', $order->id)); ?>"
                                                data-title="<?php echo e(__('Edit Order')); ?>">
                                                <i data-feather="edit"></i>
                                            </a>
                                            <a class="avtar avtar-xs btn-link-danger text-danger confirm_dialog"
                                                data-bs-toggle="tooltip" title="<?php echo e(__('Delete')); ?>"
                                                data-url="<?php echo e(route('orders.destroy', $order->id)); ?>"
                                                data-confirm="<?php echo e(__('Are you sure?')); ?>">
                                                <i data-feather="trash-2"></i>
                                            </a>
                                        </div>
                                    </td>-->
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home4/aizwmjte/sr.elitevinylwindows.com/resources/views/orders/index.blade.php ENDPATH**/ ?>
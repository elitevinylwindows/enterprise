

<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Orders')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item active" aria-current="page"><?php echo e(__('Orders')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-4"></div> 


<div class="card shadow mb-4">
            <div class="card-body p-3">
                <!-- Ribbon Tabs -->
                <ul class="nav nav-tabs mb-3 small" id="ribbonTabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="orders-tab" data-bs-toggle="tab" href="#orders" role="tab">Orders</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="production-tab" data-bs-toggle="tab" href="#production" role="tab">Production</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="crm-tab" data-bs-toggle="tab" href="#crm" role="tab">CRM</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="setup-tab" data-bs-toggle="tab" href="#setup" role="tab">Setup</a>
                    </li>
                </ul>

                <!-- Tab Contents -->
                <div class="tab-content" id="ribbonTabsContent">
                    <!-- Orders Tab -->
                    <div class="tab-pane fade show active" id="orders" role="tabpanel">
                        <div class="d-flex flex-wrap gap-2">
                            <a href="#" class="btn text-center p-2" style="min-width: 100px; background-color: #f8f9fa !important; color: #212529 !important; border: 1px solid #dee2e6;">
                                <i class="fas fa-users fa-2x d-block mb-1"></i>
                                <small>Customers</small>
                            </a>
                            <a href="#" class="btn text-center p-2" style="min-width: 100px; background-color: #f8f9fa !important; color: #212529 !important; border: 1px solid #dee2e6;">
                                <i class="fas fa-truck fa-2x d-block mb-1"></i>
                                <small>Shipping</small>
                            </a>
                            <a href="#" class="btn text-center p-2" style="min-width: 100px; background-color: #f8f9fa !important; color: #212529 !important; border: 1px solid #dee2e6;">
                                <i class="fas fa-coins fa-2x d-block mb-1"></i>
                                <small>Pricing</small>
                            </a>
                        </div>
                    </div>

                    <!-- Production Tab -->
                    <div class="tab-pane fade" id="production" role="tabpanel">
                        <div class="d-flex flex-wrap gap-2">
                            <a href="#" class="btn text-center p-2" style="min-width: 100px; background-color: #f8f9fa !important; color: #212529 !important; border: 1px solid #dee2e6;">
                                <i class="fas fa-cube fa-2x d-block mb-1"></i>
                                <small>Products</small>
                            </a>
                            <a href="#" class="btn text-center p-2" style="min-width: 100px; background-color: #f8f9fa !important; color: #212529 !important; border: 1px solid #dee2e6;">
                                <i class="fas fa-pencil-ruler fa-2x d-block mb-1"></i>
                                <small>Designers</small>
                            </a>
                        </div>
                    </div>

                    <!-- CRM Tab -->
                    <div class="tab-pane fade" id="crm" role="tabpanel">
                        <div class="d-flex flex-wrap gap-2">
                            <a href="#" class="btn text-center p-2" style="min-width: 100px; background-color: #f8f9fa !important; color: #212529 !important; border: 1px solid #dee2e6;">
                                <i class="fas fa-address-book fa-2x d-block mb-1"></i>
                                <small>Contacts</small>
                            </a>
                        </div>
                    </div>

                    <!-- Setup Tab -->
                    <div class="tab-pane fade" id="setup" role="tabpanel">
                        <div class="d-flex flex-wrap gap-2">
                            <a href="#" class="btn text-center p-2" style="min-width: 100px; background-color: #f8f9fa !important; color: #212529 !important; border: 1px solid #dee2e6;">
                                <i class="fas fa-cogs fa-2x d-block mb-1"></i>
                                <small>System</small>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>



<div class="container-fluid mt-4">
    <div class="card shadow">
        <div class="card-header bg-white">
            <h5 class="mb-0 text-dark">Order Entry</h5>
        </div>
        <div class="card-body">
            <form action="<?php echo e(route('sales.orders.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>



       <div class="d-flex justify-content-start align-items-center gap-2 mb-2">
    
    <a href="#"
       class="avtar avtar-xs btn-link-primary text-primary customModal"
       data-bs-toggle="tooltip"
       data-bs-original-title="Add"
       data-size="lg"
       data-url="<?php echo e(route('sales.orders.create')); ?>"
       data-title="Add Order">
        <i data-feather="plus"></i>
    </a>

    
    <a href="#"
       class="avtar avtar-xs btn-link-primary text-primary customModal"
       data-bs-toggle="tooltip"
       data-bs-original-title="Edit"
       data-size="lg"
       data-url="<?php echo e(route('sales.orders.edit', $order->id ?? 1)); ?>"
       data-title="Edit Order">
        <i data-feather="edit"></i>
    </a>

    
    <a href="#"
       class="avtar avtar-xs btn-link-primary text-primary customModal"
       data-bs-toggle="tooltip"
       data-bs-original-title="Delete"
       data-size="lg"
       data-url="<?php echo e(route('sales.orders.destroy', $order->id ?? 1)); ?>"
       data-title="Delete Order">
        <i data-feather="trash-2"></i>
    </a>

    
    <a href="#"
       class="avtar avtar-xs btn-link-primary text-primary customModal"
       data-bs-toggle="tooltip"
       data-bs-original-title="Email"
       data-size="lg"
       data-url="<?php echo e(route('sales.orders.email', $order->id ?? 1)); ?>"
       data-title="Email Order">
        <i data-feather="mail"></i>
    </a>

    
    <a href="#"
       class="avtar avtar-xs btn-link-primary text-primary customModal"
       data-bs-toggle="tooltip"
       data-bs-original-title="Print"
       data-size="lg"
       data-url="<?php echo e(route('sales.orders.print', $order->id ?? 1)); ?>"
       data-title="Print Order">
        <i data-feather="printer"></i>
    </a>
</div>

<div class="mb-4"></div> 


        <!-- Tab Navigation -->
        <ul class="nav nav-tabs card-header-tabs mt-2" id="orderTabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="order-tab" data-bs-toggle="tab" href="#order" role="tab">Order</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="shipping-tab" data-bs-toggle="tab" href="#shipping" role="tab">Shipping</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="financial-tab" data-bs-toggle="tab" href="#financial" role="tab">Financial</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="general-tab" data-bs-toggle="tab" href="#general" role="tab">General</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="project-tab" data-bs-toggle="tab" href="#project" role="tab">Project</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="notes-tab" data-bs-toggle="tab" href="#notes" role="tab">Notes</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="userdefined-tab" data-bs-toggle="tab" href="#userdefined" role="tab">User Defined</a>
            </li>
        </ul>
    </div>

    <!-- Tab Content + Form Fields -->
    <div class="card-body tab-content" id="orderTabsContent">
        <div class="tab-pane fade show active" id="order" role="tabpanel">
                
                <div class="row mb-3">
                    <div class="col-md-2">
                        <label>Order Number</label>
                        <input type="text" name="order_number" class="form-control">
                    </div>
                    <div class="col-md-2">
                        <label>PO Number</label>
                        <input type="text" name="po_number" class="form-control">
                    </div>
                    <div class="col-md-2">
                        <label>Order Type</label>
                        <select name="order_type" class="form-control">
                            <option value="Order">Order</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label>Customer #</label>
                        <input type="text" name="po_number" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label>Customer</label>
                        <input type="text" name="customer" class="form-control" value="Atlantic Installers - 28">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-2">
                        <label>Order Date</label>
                        <input type="date" name="order_date" class="form-control">
                    </div>
                    <div class="col-md-2">
                        <label>Required Date</label>
                        <input type="date" name="required_date" class="form-control">
                    </div>
                    <div class="col-md-2">
                        <label>Ack Date</label>
                        <input type="date" name="ask_date" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label>Invoice Date</label>
                        <input type="date" name="invoice_date" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label>Ship Date</label>
                        <input type="date" name="ship_date" class="form-control">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-3">
                        <label>Ship To</label>
                        <input type="text" name="ship_to" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label>Order Contact</label>
                        <input type="text" name="order_contact" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label>Customer Ref #</label>
                        <input type="text" name="customer_ref" class="form-control">
                    </div>
                </div>

                <div class="row mb-3">
                    
                    <div class="col-md-3">
                        <label>Salesperson</label>
                        <input type="text" name="salesperson" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label>Sales Code</label>
                        <input type="text" name="sales_code" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label>Terms</label>
                        <input type="text" name="terms" class="form-control">
                    </div>
                </div>

                
<div class="table-responsive my-3 small">
    <table class="table table-bordered table-striped table-sm">
        <thead class="table-light">
            <tr>
                <th>Qty</th>
                <th>Category</th>
                <th>Part</th>
                <th>Call Size</th>
                <th>Width</th>
                <th>Height</th>
                <th>Thickness</th>
                <th>Price</th>
                <th>SqFt Price</th>
                <th>Discount</th>
                <th>Total</th>
                <th>Configure</th>
                <th>Commands</th>
                <th>Customer Ref</th>
                <th>Group</th>
                <th>Image</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><input type="number" class="form-control form-control-sm" name="items[0][qty]"></td>
                <td><input type="text" class="form-control form-control-sm" name="items[0][category]"></td>
                <td><input type="text" class="form-control form-control-sm" name="items[0][part]"></td>
                <td><input type="text" class="form-control form-control-sm" name="items[0][call_size]"></td>
                <td><input type="text" class="form-control form-control-sm" name="items[0][width]"></td>
                <td><input type="text" class="form-control form-control-sm" name="items[0][height]"></td>
                <td><input type="text" class="form-control form-control-sm" name="items[0][thickness]"></td>
                <td><input type="text" class="form-control form-control-sm" name="items[0][price]"></td>
                <td><input type="text" class="form-control form-control-sm" name="items[0][sqft_price]"></td>
                <td><input type="text" class="form-control form-control-sm" name="items[0][discount]"></td>
                <td><input type="text" class="form-control form-control-sm" name="items[0][total]"></td>
                <td><input type="text" class="form-control form-control-sm" name="items[0][commands]"></td>
                <td><input type="text" class="form-control form-control-sm" name="items[0][commands]"></td>
                <td><input type="text" class="form-control form-control-sm" name="items[0][customer_ref]"></td>
                <td><input type="text" class="form-control form-control-sm" name="items[0][group]"></td>
                <td><input type="file" class="form-control form-control-sm" name="items[0][image]"></td>
            </tr>
        </tbody>
    </table>
</div>


                
                <div class="row mb-3">
                    <div class="col-md-8 mb-2">
                        <label>Item Comment</label>
                        <textarea name="item_comment" rows="2" class="form-control"></textarea>
                    </div>
                    <div class="col-md-8">
                        <label>Order Comment</label>
                        <textarea name="order_comment" rows="2" class="form-control"></textarea>
                    </div>
                </div>

                
                <div class="row justify-content-end">
                    <div class="col-md-4">
                        <table class="table table-sm table-bordered">
                            <tr><th>Total Quantity</th><td>0</td></tr>
                            <tr><th>Total SqFt</th><td>0.00</td></tr>
                            <tr><th>Total Weight</th><td>0.00</td></tr>
                            <tr><th>Surcharge</th><td>$0.00</td></tr>
                            <tr><th>Subtotal</th><td>$0.00</td></tr>
                            <tr><th>Tax</th><td>$0.00</td></tr>
                            <tr><th>Non-Taxable Misc</th><td>$0.00</td></tr>
                            <tr><th>Total</th><td><strong>$0.00</strong></td></tr>
                            <tr><th>Amount Received</th><td>$0.00</td></tr>
                            <tr><th>Balance</th><td>$0.00</td></tr>
                        </table>
                    </div>
                </div>

                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-check"></i> Submit Order
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
        </div>

<?php $__env->stopSection(); ?>


<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home4/aizwmjte/sr.elitevinylwindows.com/resources/views/sales/orders/create.blade.php ENDPATH**/ ?>
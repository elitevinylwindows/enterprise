

<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Quotes')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item active" aria-current="page"><?php echo e(__('Quotes')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-4"></div> 

    
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


<div class="row">
    
    <div class="col-md-2">
        <div class="card">
            <div class="list-group list-group-flush">
<a href="<?php echo e(route('sales.quotes.index', ['status' => 'all'])); ?>" class="list-group-item">All Quotes</a>
<a href="<?php echo e(route('sales.quotes.index', ['status' => 'draft'])); ?>" class="list-group-item">Draft Quotes</a>
<a href="<?php echo e(route('sales.quotes.index', ['status' => 'deleted'])); ?>" class="list-group-item text-danger">Deleted</a>

            </div>
        </div>
    </div>

  
 <div class="col-sm-10">
        <div class="card table-card">
            <div class="card-header">
                <div class="row align-items-center g-2">
                    <div class="col">
                        <h5><?php echo e(__('Quote List')); ?></h5>
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
                            <?php $__currentLoopData = $quotes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $quote): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($quote->quote_number); ?></td>
                                    <td><?php echo e($quote->customer_name); ?></td>
                                    <td><?php echo e($quote->entry_date); ?></td>
                                    <td><?php echo e($quote->po_number); ?></td>
                                    <td><?php echo e($quote->reference); ?></td>
                                    <td>$<?php echo e(number_format($quote->total ?? 0, 2)); ?></td>
                                    <td><?php echo e($quote->valid_until); ?></td>
                                    <td>
                                        <?php if($quote->status === 'active'): ?>
                                            <span class="badge bg-success">Active</span>
                                        <?php elseif($quote->status === 'draft'): ?>
                                            <span class="badge bg-secondary">Draft</span>
                                        <?php else: ?>
                                            <span class="badge bg-light text-muted"><?php echo e(ucfirst($quote->status)); ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-nowrap">
                                        
                                        <a class="avtar avtar-xs btn-link-success text-success customModal"
                                           data-bs-toggle="tooltip"
                                           data-bs-original-title="View Summary"
                                           href="#"
                                           data-size="xl"
                                           data-url=""
                                           data-title="Quote Summary">
                                            <i data-feather="eye"></i>
                                        </a>

                                        
                                        <a class="avtar avtar-xs btn-link-primary text-primary customModal"
                                           data-bs-toggle="tooltip"
                                           data-bs-original-title="Edit"
                                           href="#"
                                           data-size="xl"
                                           data-url="<?php echo e(route('sales.quotes.edit', $quote->id)); ?>"
                                           data-title="Edit Quote">
                                            <i data-feather="edit"></i>
                                        </a>

                                        
                                        <a class="avtar avtar-xs btn-link-warning text-warning customModal"
                                           data-bs-toggle="tooltip"
                                           data-bs-original-title="Email"
                                           href="#"
                                           data-size="md"
                                           data-url="<?php echo e(route('sales.quotes.email', $quote->id)); ?>"
                                           data-title="Send Email">
                                            <i data-feather="mail"></i>
                                        </a>

                                        
                                        <a class="avtar avtar-xs btn-link-info text-info"
                                           data-bs-toggle="tooltip"
                                           data-bs-original-title="Orders"
                                           href="<?php echo e(route('sales.orders.index', ['quote' => $quote->id])); ?>">
                                            <i data-feather="shopping-cart"></i>
                                        </a>

                                        
                                        <a class="avtar avtar-xs btn-link-danger text-danger customModal"
                                           data-bs-toggle="tooltip"
                                           data-bs-original-title="Delete"
                                           href="#"
                                           data-size="md"
                                           data-url="<?php echo e(route('sales.quotes.destroy', $quote->id)); ?>"
                                           data-title="Delete Quote">
                                            <i data-feather="trash-2"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div> <!-- table-responsive -->
            </div> <!-- card-body -->
        </div> <!-- card -->
    </div> <!-- col -->


</div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home4/aizwmjte/app.elitevinylwindows.com/resources/views/sales/quotes/index.blade.php ENDPATH**/ ?>
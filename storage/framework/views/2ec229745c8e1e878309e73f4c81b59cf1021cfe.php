<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Customers')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Executives')); ?></li>
    <li class="breadcrumb-item active" aria-current="page"><?php echo e(__('Customers')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('card-action-btn'); ?>
    <form action="<?php echo e(route('executives.customers.import')); ?>" method="POST" enctype="multipart/form-data" class="d-inline-block me-2">
        <?php echo csrf_field(); ?>
        <input type="file" name="import_file" accept=".csv,.xls,.xlsx" required class="form-control d-inline-block w-auto">
        <button type="submit" class="btn btn-md btn-primary">
            <i data-feather="upload"></i> Import Customers
        </button>
    </form>

    <button type="button" class="btn btn-md btn-primary me-2" data-bs-toggle="modal" data-bs-target="#addCustomerModal">
        <i class="ti ti-plus"></i> Add Customer
    </button>

    <a href="<?php echo e(route('executives.customers.index', ['status' => 'active'])); ?>" class="btn btn-primary btn-md me-2">
        Show Only Active Users
    </a>

    <?php if(request()->get('status') === 'active'): ?>
        <a href="<?php echo e(route('executives.customers.index')); ?>" class="btn btn-primary btn-md">
            Show All Users
        </a>
    <?php endif; ?>
<?php $__env->stopSection(); ?>





<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-sm-12">
        <div class="card table-card">
            <div class="card-header">
 <div class="row align-items-center g-2">
                    <div class="col">
                        <h5><?php echo e(__('Customers')); ?></h5>
                    </div>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="dt-responsive table-responsive">
                    <table class="table table-hover advance-datatable" id="customersTable">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="select-all"></th>
                                <th>Customer #</th>
                                <th>Customer Name</th>
                                <th>Street</th>
                                <th>City</th>
                                <th>ZIP</th>
                                <th>Status</th>
                                <th>Tier</th>
                                <th>Loyalty Credit</th>
                                <th>Total Spent</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><input type="checkbox" class="customer-checkbox" value="<?php echo e($customer['id']); ?>

"></td>
                                   <td><?php echo e($customer['customer_number']); ?></td>
<td><?php echo e($customer->name); ?></td>
<td><?php echo e($customer->street); ?></td>
<td><?php echo e($customer->city); ?></td>
<td><?php echo e($customer->zip); ?></td>
<td>
  <span class="badge bg-<?php echo e($customer->status === 'active' ? 'success' : 'secondary'); ?>">
    <?php echo e(ucfirst($customer->status)); ?>

  </span>
</td>
<td><?php echo e($customer->tier); ?></td>
<td>$<?php echo e(number_format($customer->loyalty_credit, 2)); ?></td>
<td>$<?php echo e(number_format($customer->total_spent, 2)); ?></td>
                                    <td>
                                        <a href="<?php echo e(route('executives.customers.edit', $customer->id)); ?>" class="btn btn-sm btn-primary">Edit</a>
                                        <form action="<?php echo e(route('executives.customers.destroy', $customer->id)); ?>" method="POST" class="d-inline">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button class="btn btn-sm btn-primary" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </td>
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

<!-- Add Customer Modal -->
<div class="modal fade" id="addCustomerModal" tabindex="-1" aria-labelledby="addCustomerLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <?php echo $__env->make('executives.customers.create', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> 
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    document.getElementById('select-all').addEventListener('click', function () {
        const checked = this.checked;
        document.querySelectorAll('.customer-checkbox').forEach(cb => cb.checked = checked);
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home4/aizwmjte/sr.elitevinylwindows.com/resources/views/master/customers/index.blade.php ENDPATH**/ ?>
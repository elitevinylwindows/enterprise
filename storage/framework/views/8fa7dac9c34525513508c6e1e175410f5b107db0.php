
<?php $__env->startSection('page-title', __('Purchase Requests')); ?>

<?php $__env->startSection('breadcrumb'); ?>
<li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
<li class="breadcrumb-item active" aria-current="page"><?php echo e(__('Purchase Requests')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-sm-12">
        <div class="card table-card">
            <div class="card-header">
                <div class="row align-items-center g-2">
                    <div class="col"><h5><?php echo e(__('Purchase Requests')); ?></h5></div>
                    <div class="col-auto">
                        <a href="#" class="btn btn-primary customModal"
                           data-size="lg"
                           data-url="<?php echo e(route('purchasing.purchase-requests.create')); ?>"
                           data-title="<?php echo e(__('Create Request')); ?>">
                           <i class="fa-solid fa-circle-plus"></i> <?php echo e(__('Create')); ?>

                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body pt-0">
                <div class="dt-responsive table-responsive">
                    <table class="table table-hover advance-datatable">
                        <thead>
                            <tr>
                                <th><?php echo e(__('Request No')); ?></th>
                                <th><?php echo e(__('Requested By')); ?></th>
                                <th><?php echo e(__('Department')); ?></th>
                                <th><?php echo e(__('Request Date')); ?></th>
                                <th><?php echo e(__('Expected Date')); ?></th>
                                <th><?php echo e(__('Priority')); ?></th>
                                <th><?php echo e(__('Status')); ?></th>
                                <th><?php echo e(__('Notes')); ?></th>
                                <th><?php echo e(__('Action')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $purchaseRequests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $request): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($request->purchase_request_id); ?></td>
                                <td><?php echo e($request->requested_by); ?></td>
                                <td><?php echo e($request->department); ?></td>
                                <td><?php echo e(\Carbon\Carbon::parse($request->request_date)->format('M d, Y')); ?></td>
                                <td><?php echo e(\Carbon\Carbon::parse($request->expected_date)->format('M d, Y')); ?></td>
                                <td><span class="badge bg-warning"><?php echo e(ucfirst($request->priority)); ?></span></td>
                                <td><span class="badge bg-<?php echo e($request->status === 'approved' ? 'success' : ($request->status === 'rejected' ? 'danger' : 'secondary')); ?>">
                                    <?php echo e(ucfirst($request->status)); ?></span>
                                </td>
                                <td><?php echo e(Str::limit($request->notes, 30)); ?></td>
                                <td>
                                 
<a class="avtar avtar-xs btn-link-success text-success customModal"
   data-bs-toggle="tooltip"
   data-bs-original-title="Edit Request"
   href="#"
   data-size="lg"
   data-url="<?php echo e(route('purchasing.purchase-requests.edit', $request->id)); ?>"
   data-title="Edit Request">
    <i data-feather="edit"></i>
</a>





<a class="avtar avtar-xs btn-link-warning text-warning customModal"
   data-size="lg"
   data-url="<?php echo e(route('purchasing.purchase-requests.show', $request->id)); ?>"
   data-title="Purchase Request Items">
    <i data-feather="eye"></i>
</a>





<a class="avtar avtar-xs btn-link-danger text-danger"
   data-bs-toggle="tooltip"
   data-bs-original-title="Delete Request"
   href="<?php echo e(route('purchasing.purchase-requests.destroy', $request->id)); ?>"
   onclick="event.preventDefault(); if(confirm('Are you sure you want to delete this request?')) document.getElementById('delete-form-<?php echo e($request->id); ?>').submit();">
    <i data-feather="trash-2"></i>
</a>

<form id="delete-form-<?php echo e($request->id); ?>" action="<?php echo e(route('purchasing.purchase-requests.destroy', $request->id)); ?>" method="POST" class="d-none">
    <?php echo csrf_field(); ?>
    <?php echo method_field('DELETE'); ?>
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home4/aizwmjte/app.elitevinylwindows.com/resources/views/purchasing/purchase_requests/index.blade.php ENDPATH**/ ?>
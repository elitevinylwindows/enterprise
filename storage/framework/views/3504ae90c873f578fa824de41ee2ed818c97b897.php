<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Page')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item" aria-current="page"> <?php echo e(__('Page')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="card table-card">
                <div class="card-header">
                    <div class="row align-items-center g-2">
                        <div class="col">
                            <h5><?php echo e(__('Page')); ?></h5>
                        </div>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create Page')): ?>
                            <div class="col-auto">
                                <a href="#" class="btn btn-secondary customModal" data-size="xl"
                                    data-url="<?php echo e(route('pages.create')); ?>" data-title="<?php echo e(__('Create New Page')); ?>">
                                    <i class="ti ti-circle-plus align-text-bottom"></i> <?php echo e(__('Create Page')); ?></a>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="dt-responsive table-responsive">
                        <table class="table table-hover advance-datatable">
                            <thead>
                                <tr>
                                    <th><?php echo e(__('Name')); ?></th>
                                    <th><?php echo e(__('Enable')); ?></th>
                                    <?php if(Gate::check('edit Page') || Gate::check('delete Page')): ?>
                                        <th><?php echo e(__('Action')); ?></th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $Pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($item->title); ?> </td>
                                        <td>

                                            <?php if($item->enabled == 1): ?>
                                                <span class="d-inline badge text-bg-success"><?php echo e(__('Enable')); ?></span>
                                            <?php else: ?>
                                                <span class="d-inline badge text-bg-danger"><?php echo e(__('Disable')); ?></span>
                                            <?php endif; ?>

                                        </td>
                                        <?php if(Gate::check('edit Page') || Gate::check('delete Page')): ?>
                                            <td>
                                                <div class="cart-action">
                                                    <?php echo Form::open(['method' => 'DELETE', 'route' => ['pages.destroy', $item->id]]); ?>

                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('show Page')): ?>
                                                        <a class="avtar avtar-xs btn-link-warning text-warning customModal" data-bs-toggle="tooltip"
                                                            data-size="xl" data-bs-original-title="<?php echo e(__('Edit')); ?>"
                                                            href="#" data-url="<?php echo e(route('pages.show', $item->id)); ?>"
                                                            data-title="<?php echo e(__('Show Pages')); ?>"> <i data-feather="eye"></i></a>
                                                    <?php endif; ?>
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit Page')): ?>
                                                        <a class="avtar avtar-xs btn-link-secondary text-secondary customModal" data-bs-toggle="tooltip"
                                                            data-size="xl" data-bs-original-title="<?php echo e(__('Edit')); ?>"
                                                            href="#" data-url="<?php echo e(route('pages.edit', $item->id)); ?>"
                                                            data-title="<?php echo e(__('Edit Pages')); ?>"> <i data-feather="edit"></i></a>
                                                    <?php endif; ?>
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete Page')): ?>
                                                        <?php if(!in_array($item->id, [1,2])): ?>
                                                        <a class=" avtar avtar-xs btn-link-danger text-danger confirm_dialog" data-bs-toggle="tooltip"
                                                            data-bs-original-title="<?php echo e(__('Detete')); ?>" href="#"> <i
                                                                data-feather="trash-2"></i></a>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                    <?php echo Form::close(); ?>

                                                </div>

                                            </td>
                                        <?php endif; ?>
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home4/aizwmjte/sr.elitevinylwindows.com/resources/views/Pages/index.blade.php ENDPATH**/ ?>
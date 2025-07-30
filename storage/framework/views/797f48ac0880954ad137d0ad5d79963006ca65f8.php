

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('menu.index')); ?>">Menu</a></li>
    <li class="breadcrumb-item active">Create</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<section class="mt-4"> 
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 mx-auto">
                <div class="card shadow-sm rounded">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="mb-0">Create Menu</h5>
                        <small class="text-muted">Add a new menu item</small>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="<?php echo e(route('menu.store')); ?>">
                            <?php echo csrf_field(); ?>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label>Name</label>
                                    <input type="text" name="name" class="form-control" placeholder="e.g. Dashboard" required>
                                </div>
                                <div class="col-md-6">
                                    <label>Route</label>
                                    <input type="text" name="route" class="form-control" placeholder="e.g. dashboard.index">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label>Icon</label>
                                    <input type="text" name="icon" class="form-control" placeholder="e.g. fa-solid fa-user">
                                </div>
                                <div class="col-md-4">
                                    <label>Type</label>
                                    <select name="type" class="form-control" required>
                                        <option value="header">Header</option>
                                        <option value="menu" selected>Menu</option>
                                        <option value="submenu">Submenu</option>
                                        <option value="sub-submenu">Sub-Submenu</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label>Order</label>
                                    <input type="number" name="order" class="form-control" value="0">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label>Parent</label>
                                <select name="parent_id" class="form-control">
                                    <option value="">None</option>
                                    <?php $__currentLoopData = $menus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($menu->id); ?>"><?php echo e($menu->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label>Roles</label>
                                <div class="d-flex flex-wrap gap-2">
                                    <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="roles[]" value="<?php echo e($role->name); ?>" id="role_<?php echo e($role->id); ?>">
                                            <label class="form-check-label" for="role_<?php echo e($role->id); ?>"><?php echo e($role->name); ?></label>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Create Menu</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home4/aizwmjte/sr.elitevinylwindows.com/resources/views/admin/menu/create.blade.php ENDPATH**/ ?>
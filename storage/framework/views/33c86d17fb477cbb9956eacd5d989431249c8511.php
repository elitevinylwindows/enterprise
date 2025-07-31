

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('menu.index')); ?>">Menu</a></li>
    <li class="breadcrumb-item active">Edit</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 mx-auto">
            <div class="card shadow-sm rounded">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">Edit Menu</h5>
                    <small class="text-muted">Update menu item details</small>
                </div>
                <div class="card-body">
                    <form method="POST" action="<?php echo e(route('menu.update', $menu->id)); ?>">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label>Name</label>
                                <input type="text" name="name" value="<?php echo e($menu->name); ?>" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label>Route</label>
                                <input type="text" name="route" value="<?php echo e($menu->route); ?>" class="form-control">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label>Icon</label>
                                <input type="text" name="icon" value="<?php echo e($menu->icon); ?>" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label>Type</label>
                                <select name="type" class="form-control">
                                    <option value="header" <?php echo e($menu->type == 'header' ? 'selected' : ''); ?>>Header</option>
                                    <option value="menu" <?php echo e($menu->type == 'menu' ? 'selected' : ''); ?>>Menu</option>
                                    <option value="submenu" <?php echo e($menu->type == 'submenu' ? 'selected' : ''); ?>>Submenu</option>
                                    <option value="sub-submenu" <?php echo e($menu->type == 'sub-submenu' ? 'selected' : ''); ?>>Sub-Submenu</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>Order</label>
                                <input type="number" name="order" value="<?php echo e($menu->order); ?>" class="form-control">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label>Parent</label>
                            <select name="parent_id" class="form-control">
                                <option value="">None</option>
                                <?php $__currentLoopData = $parents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $parent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($parent->id); ?>" <?php echo e($menu->parent_id == $parent->id ? 'selected' : ''); ?>><?php echo e($parent->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label>Roles</label>
                            <div class="d-flex flex-wrap gap-2">
                                <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="roles[]" value="<?php echo e($role->name); ?>" id="role_<?php echo e($role->id); ?>" <?php echo e(in_array($role->name, json_decode($menu->roles ?? '[]')) ? 'checked' : ''); ?>>
                                        <label class="form-check-label" for="role_<?php echo e($role->id); ?>"><?php echo e($role->name); ?></label>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Update Menu</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home4/aizwmjte/sr.elitevinylwindows.com/resources/views/admin/menu/edit.blade.php ENDPATH**/ ?>
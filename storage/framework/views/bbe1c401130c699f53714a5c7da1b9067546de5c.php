<div class="tab-pane fade show active" id="setup" role="tabpanel">
    <div class="d-flex flex-wrap align-items-center gap-3 mb-3">

        <?php
            $tabs = [
                [
                    'icon' => 'fa-users',
                    'label' => 'Customers',
                    'submenu' => [
                        ['label' => 'All Customers', 'url' => '/customers'],
                        ['label' => 'Add Customer', 'url' => '/customers/create'],
                    ],
                ],
                ['icon' => 'fa-truck', 'label' => 'Shipping', 'url' => '/shipping'],
                ['icon' => 'fa-coins', 'label' => 'Pricing', 'url' => '/pricing'],
                ['icon' => 'fa-box', 'label' => 'Products', 'url' => '/products'],
                ['icon' => 'fa-pencil-ruler', 'label' => 'Designers', 'url' => '/designers'],
                ['icon' => 'fa-industry', 'label' => 'Vendors', 'url' => '/vendors'],
                ['icon' => 'fa-warehouse', 'label' => 'Inventory', 'url' => '/inventory'],
                ['icon' => 'fa-network-wired', 'label' => 'Interfaces', 'url' => '/interfaces'],
                ['icon' => 'fa-ban', 'label' => 'Rejects', 'url' => '/rejects'],
                ['icon' => 'fa-chart-line', 'label' => 'Capacity Planning', 'url' => '/capacity'],
                ['icon' => 'fa-handshake', 'label' => 'CRM', 'url' => '/crm'],
                ['icon' => 'fa-cogs', 'label' => 'System', 'url' => '/system'],
            ];

            $vlAfter = [0, 1, 2, 5, 7, 10, 11];
        ?>


        <?php $__currentLoopData = $tabs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $tab): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if(isset($tab['submenu'])): ?>
                <div class="dropdown ribbon-dropdown">
                    <a href="#" class="dropdown-toggle ribbon-tile text-center"
                       data-bs-toggle="dropdown"
                       style="min-width: 20px; background-color: white; color: #6c757d; padding: 2px; font-size: 10px;">
                        <i class="fas <?php echo e($tab['icon']); ?> fa-lg d-block mb-1"></i>
                        <span><?php echo e($tab['label']); ?></span>
                    </a>
                    <ul class="dropdown-menu shadow p-2 border-0">
                        <?php $__currentLoopData = $tab['submenu']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $submenu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><a class="dropdown-item small" href="#"><?php echo e($submenu['label']); ?></a></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php else: ?>
                <a href="#" class="ribbon-tile text-center"
                   style="min-width: 20px; background-color: white; color: #6c757d; padding: 2px; font-size: 10px;">
                    <i class="fas <?php echo e($tab['icon']); ?> fa-lg d-block mb-1"></i>
                    <span><?php echo e($tab['label']); ?></span>
                </a>
            <?php endif; ?>

            <?php if(in_array($index, $vlAfter)): ?>
                <div class="vr mx-1" style="height: 62px;"></div>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        
        <a href="#" class="ribbon-tile text-center"
           style="min-width: 20px; background-color: white; color: #6c757d; padding: 2px; font-size: 10px;">
            <div class="d-flex justify-content-center align-items-center gap-1 mb-1">
                <i class="fas fa-cog fa-sm"></i> <span>Settings</span>
            </div>
            <div class="d-flex justify-content-center align-items-center gap-1 mb-1">
                <i class="fas fa-chart-bar fa-sm"></i> <span>Reports</span>
            </div>
            <div class="d-flex justify-content-center align-items-center gap-1">
                <i class="fas fa-eye fa-sm"></i> <span>Viewers</span>
            </div>
        </a>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<style>
    .ribbon-dropdown:hover .dropdown-menu {
        display: block;
        margin-top: 0.5rem;
    }
</style>
<?php $__env->stopPush(); ?>
<?php /**PATH /home4/aizwmjte/sr.elitevinylwindows.com/resources/views/partials/tabs/setup.blade.php ENDPATH**/ ?>
<?php
    $admin_logo = getSettingsValByName('company_logo');
    $ids = parentId();
    $authUser = \App\Models\User::find($ids);
    $subscription = \App\Models\Subscription::find($authUser->subscription);
    $routeName = \Request::route()->getName();
    $pricing_feature_settings = getSettingsValByIdName(1, 'pricing_feature');
?>
<nav class="pc-sidebar">
    <div class="navbar-wrapper">
        <div class="m-header">
            <a href="<?php echo e(route('home')); ?>" class="b-brand text-primary">
                <img src="<?php echo e(asset(Storage::url('upload/logo/')) . '/' . (isset($admin_logo) && !empty($admin_logo) ? $admin_logo : 'logo.png')); ?>"
                    alt="" class="logo logo-lg" />
            </a>
        </div>
        <div class="navbar-content">
            <ul class="pc-navbar">
                <li class="pc-item pc-caption">
                    <label><?php echo e(__('Home')); ?></label>
                    <i class="ti ti-dashboard"></i>
                </li>
                <li class="pc-item <?php echo e(in_array($routeName, ['dashboard', 'home', '']) ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('dashboard')); ?>" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-dashboard"></i></span>
                        <span class="pc-mtext"><?php echo e(__('Dashboard')); ?></span>
                    </a>
                </li>
                <?php if(\Auth::user()->type == 'super admin'): ?>
                    <?php if(Gate::check('manage user')): ?>
                        <li class="pc-item <?php echo e(in_array($routeName, ['users.index', 'users.show']) ? 'active' : ''); ?>">
                            <a href="<?php echo e(route('users.index')); ?>" class="pc-link">
                                <span class="pc-micon"><i class="ti ti-user-plus"></i></span>
                                <span class="pc-mtext"><?php echo e(__('Customers')); ?></span>
                            </a>
                        </li>
                    <?php endif; ?>
                <?php else: ?>
                    <?php if(Gate::check('manage user') || Gate::check('manage role') || Gate::check('manage logged history')): ?>
                        <li
                            class="pc-item pc-hasmenu <?php echo e(in_array($routeName, ['users.index', 'logged.history', 'role.index', 'role.create', 'role.edit']) ? 'pc-trigger active' : ''); ?>">
                            <a href="#!" class="pc-link">
                                <span class="pc-micon">
                                    <i class="ti ti-users"></i>
                                </span>
                                <span class="pc-mtext"><?php echo e(__('Staff Management')); ?></span>
                                <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                            </a>
                            <ul class="pc-submenu"
                                style="display: <?php echo e(in_array($routeName, ['users.index', 'logged.history', 'role.index', 'role.create', 'role.edit']) ? 'block' : 'none'); ?>">
                                <?php if(Gate::check('manage user')): ?>
                                    <li class="pc-item <?php echo e(in_array($routeName, ['users.index']) ? 'active' : ''); ?>">
                                        <a class="pc-link" href="<?php echo e(route('users.index')); ?>"><?php echo e(__('Users')); ?></a>
                                    </li>
                                <?php endif; ?>
                                <?php if(Gate::check('manage role')): ?>
                                    <li
                                        class="pc-item  <?php echo e(in_array($routeName, ['role.index', 'role.create', 'role.edit']) ? 'active' : ''); ?>">
                                        <a class="pc-link" href="<?php echo e(route('role.index')); ?>"><?php echo e(__('Roles')); ?> </a>
                                    </li>
                                <?php endif; ?>
                                <?php if($pricing_feature_settings == 'off' || $subscription->enabled_logged_history == 1): ?>
                                    <?php if(Gate::check('manage logged history')): ?>
                                        <li
                                            class="pc-item  <?php echo e(in_array($routeName, ['logged.history']) ? 'active' : ''); ?>">
                                            <a class="pc-link"
                                                href="<?php echo e(route('logged.history')); ?>"><?php echo e(__('Logged History')); ?></a>
                                        </li>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </ul>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>
                


<?php if(
    Gate::check('access crud generator') ||
    Gate::check('view all menus') ||
    Gate::check('create menu') ||
    Gate::check('reorder menu')
): ?>
<li class="pc-item pc-caption d-flex justify-content-between align-items-center">
    <div class="d-flex align-items-center gap-2">
        <i class="ti ti-chart-arcs"></i>
        <label class="m-0"><?php echo e(__('CRUD & Menu')); ?></label>
    </div>
    <i class="ti ti-plus text-muted pe-2" style="font-size: 0.9rem;"></i>
</li>

<?php if(Gate::check('access crud generator')): ?>
<li class="pc-item <?php echo e(request()->routeIs('crud.index') ? 'active' : ''); ?>">
    <a href="<?php echo e(route('crud.index')); ?>" class="pc-link">
        <span class="pc-micon"><i class="fa-solid fa-laptop-code"></i></span>
        <span class="pc-mtext"><?php echo e(__('Generator')); ?></span>
    </a>
</li>
<?php endif; ?>

<?php if(
    Gate::check('view all menus') ||
    Gate::check('create menu') ||
    Gate::check('reorder menu')
): ?>
<li class="pc-item pc-hasmenu <?php echo e(request()->routeIs('menu.*') ? 'active pc-trigger' : ''); ?>">
    <a href="#" class="pc-link d-flex align-items-center">
        <span class="pc-micon"><i class="fa-solid fa-bars-staggered"></i></span>
        <span class="pc-mtext ms-2">Menu Manager</span>
        <span class="ms-auto"><i class="fa-solid fa-circle-plus"></i></span>
    </a>

    <ul class="pc-submenu">
        <?php if(Gate::check('view all menus')): ?>
        <li class="pc-item <?php echo e(request()->routeIs('menu.index') ? 'active' : ''); ?>">
            <a href="<?php echo e(route('menu.index')); ?>" class="pc-link">
                <span class="pc-mtext">All Menus</span>
            </a>
        </li>
        <?php endif; ?>
        <?php if(Gate::check('create menu')): ?>
        <li class="pc-item <?php echo e(request()->routeIs('menu.create') ? 'active' : ''); ?>">
            <a href="<?php echo e(route('menu.create')); ?>" class="pc-link">
                <span class="pc-mtext">Create Menu</span>
            </a>
        </li>
        <?php endif; ?>
        <?php if(Gate::check('reorder menu')): ?>
        <li class="pc-item <?php echo e(request()->routeIs('menu.reorder') ? 'active' : ''); ?>">
            <a href="<?php echo e(route('menu.reorder')); ?>" class="pc-link">
                <span class="pc-mtext">Reorder Menu</span>
            </a>
        </li>
        <?php endif; ?>
    </ul>
</li>
<?php endif; ?>
<?php endif; ?>

<?php if(
    Gate::check('view sales dashboard') ||
    Gate::check('manage leads') ||
    Gate::check('view my kanban') ||
    Gate::check('manage quotes') ||
    Gate::check('manage orders') ||
    Gate::check('manage invoices') ||
    Gate::check('manage carts') ||
    Gate::check('view all deliveries') ||
    Gate::check('view today deliveries') ||
    Gate::check('view upcoming deliveries') ||
    Gate::check('manage calendar') ||
    Gate::check('manage deliveries') ||
    Gate::check('manage routes') ||
    Gate::check('manage my route') ||
    Gate::check('manage trucks') ||
    Gate::check('manage drivers') ||
    Gate::check('manage shops') ||
    Gate::check('manage purchase requests') ||
    Gate::check('manage supplier quotes') ||
    Gate::check('manage purchase orders') ||
    Gate::check('manage receiving') ||
    Gate::check('manage purchase invoices') ||
    Gate::check('manage sales settings') ||
    Gate::check('manage bom') ||
    Gate::check('manage master') ||
    Gate::check('manage schema') ||
    Gate::check('manage inventory') ||
    Gate::check('manage miscellaneous') ||
    Gate::check('manage executive') ||
    Gate::check('view reports')
): ?>

<li class="pc-item pc-caption d-flex justify-content-between align-items-center">
    <div>
        <label><?php echo e(__('Enterprise')); ?></label>
        <i class="ti ti-chart-arcs"></i>
    </div>
    <i class="ti ti-plus text-muted pe-2" style="font-size: 0.9rem;"></i>
</li>
<?php endif; ?>


<?php if(
    Gate::check('view sales dashboard') ||
    Gate::check('manage leads') ||
    Gate::check('view my kanban') ||
    Gate::check('manage quotes') ||
    Gate::check('manage sales orders') ||
    Gate::check('manage invoices') ||
    Gate::check('manage sales settings')
): ?>
<li class="pc-item pc-hasmenu <?php echo e(request()->routeIs('sales.*') || request()->routeIs('leads.*') ? 'active pc-trigger' : ''); ?>">
    <a href="#" class="pc-link d-flex align-items-center">
        <span class="pc-micon"><i class="ti ti-receipt"></i></span>
        <span class="pc-mtext ms-2">Sales</span>
        <span class="ms-auto"><i class="fa-solid fa-circle-plus"></i></span>
    </a>

    <ul class="pc-submenu">

        
        <?php if(Gate::check('view sales dashboard')): ?>
        <li class="pc-item <?php echo e(request()->routeIs('sales.dashboard.*') ? 'active' : ''); ?>">
            <a href="<?php echo e(route('sales.dashboard.index')); ?>" class="pc-link">
                <span class="pc-mtext">Dashboard</span>
            </a>
        </li>
        <?php endif; ?>

        
        <?php if(Gate::check('manage leads') || Gate::check('view my kanban')): ?>
        <li class="pc-item pc-hasmenu">
            <a href="#" class="pc-link d-flex justify-content-between align-items-center" onclick="toggleSubmenu(event, this)">
                <span>Leads</span>
                <span class="ms-auto"><i class="fa-solid fa-circle-plus"></i></span>
            </a>
            <ul class="pc-submenu" style="<?php echo e(request()->routeIs('leads.*') ? 'display: block;' : 'display: none;'); ?>">
                <?php if(Gate::check('manage leads')): ?>
                <li><a class="pc-link" href="<?php echo e(route('leads.index')); ?>">Leads</a></li>
                <li><a class="pc-link" href="<?php echo e(route('leads.kanban')); ?>">Kanban</a></li>
                <?php endif; ?>
                <?php if(Gate::check('view my kanban')): ?>
                <li class="pc-item <?php echo e(request()->routeIs('leads.mykanban') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('leads.mykanban')); ?>" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-layout-kanban"></i></span>
                        <span class="pc-mtext"><?php echo e(__('My Kanban')); ?></span>
                    </a>
                </li>
                <?php endif; ?>
            </ul>
        </li>
        <?php endif; ?>

        
        <?php if(Gate::check('manage quotes')): ?>
        <li class="pc-item pc-hasmenu">
            <a href="#" class="pc-link d-flex justify-content-between align-items-center" onclick="toggleSubmenu(event, this)">
                <span>Quotes</span>
                <span class="ms-auto"><i class="fa-solid fa-circle-plus"></i></span>
            </a>
            <ul class="pc-submenu" style="<?php echo e(request()->routeIs('sales.quotes.*') ? 'display: block;' : 'display: none;'); ?>">
                <li><a class="pc-link" href="<?php echo e(route('sales.quotes.create')); ?>">New Quote</a></li>
                <li><a class="pc-link" href="<?php echo e(route('sales.quotes.index')); ?>">Quote History</a></li>
            </ul>
        </li>
        <?php endif; ?>

        
        <?php if(Gate::check('manage sales orders')): ?>
        <li class="pc-item pc-hasmenu">
            <a href="#" class="pc-link d-flex justify-content-between align-items-center" onclick="toggleSubmenu(event, this)">
                <span>Orders</span>
                <span class="ms-auto"><i class="fa-solid fa-circle-plus"></i></span>
            </a>
            <ul class="pc-submenu" style="<?php echo e(request()->routeIs('sales.orders.*') ? 'display: block;' : 'display: none;'); ?>">
                <li><a class="pc-link" href="<?php echo e(route('sales.orders.create')); ?>">New Order</a></li>
                <li><a class="pc-link" href="<?php echo e(route('sales.orders.index')); ?>">Order History</a></li>
            </ul>
        </li>
        <?php endif; ?>

        
        <?php if(Gate::check('manage invoices')): ?>
        <li class="pc-item pc-hasmenu">
            <a href="#" class="pc-link d-flex justify-content-between align-items-center" onclick="toggleSubmenu(event, this)">
                <span>Invoice</span>
                <span class="ms-auto"><i class="fa-solid fa-circle-plus"></i></span>
            </a>
            <ul class="pc-submenu" style="<?php echo e(request()->routeIs('sales.invoices.*') ? 'display: block;' : 'display: none;'); ?>">
                <li><a class="pc-link" href="<?php echo e(route('sales.invoices.create')); ?>">New Invoice</a></li>
                <li><a class="pc-link" href="<?php echo e(route('sales.invoices.index')); ?>">Invoice History</a></li>
            </ul>
        </li>
        <?php endif; ?>

        
        <?php if(Gate::check('manage sales settings')): ?>
        <li class="pc-item">
            <a href="<?php echo e(route('sales.settings.index')); ?>" class="pc-link d-flex justify-content-between align-items-center">
                <span>Settings</span>
            </a>
        </li>
        <?php endif; ?>

    </ul>
</li>
<?php endif; ?>



<!-- Purchasing -->
<?php if(
    Gate::check('manage purchase requests') ||
    Gate::check('manage supplier quotes') ||
    Gate::check('manage purchase orders') ||
    Gate::check('manage receiving') ||
    Gate::check('manage purchase invoices')
): ?>
<li class="pc-item pc-hasmenu <?php echo e(request()->routeIs('purchasing.*') ? 'active pc-trigger' : ''); ?>">
    <a href="#" class="pc-link d-flex align-items-center">
        <span class="pc-micon"><i class="fa-solid fa-file-invoice-dollar"></i></span>
        <span class="pc-mtext ms-2">Purchasing</span>
        <span class="ms-auto"><i class="fa-solid fa-circle-plus"></i></span>
    </a>

    <ul class="pc-submenu">
        <?php if(Gate::check('manage purchase requests')): ?>
        <li><a class="pc-link" href="<?php echo e(route('purchasing.purchase-requests.index')); ?>">Purchase Requests</a></li>
        <?php endif; ?>

        <?php if(Gate::check('manage supplier quotes')): ?>
        <li><a class="pc-link" href="<?php echo e(route('purchasing.supplier-quotes.index')); ?>">Supplier Quotes</a></li>
        <?php endif; ?>

        <?php if(Gate::check('manage purchase orders')): ?>
        <li><a class="pc-link" href="<?php echo e(route('purchasing.purchase-orders.index')); ?>">Purchase Orders</a></li>
        <?php endif; ?>

        <?php if(Gate::check('manage receiving')): ?>
        <li><a class="pc-link" href="<?php echo e(route('purchasing.receiving.index')); ?>">Receiving</a></li>
        <?php endif; ?>

        <?php if(Gate::check('manage purchase invoices')): ?>
        <li><a class="pc-link" href="<?php echo e(route('purchasing.invoices.index')); ?>">Purchase Invoices</a></li>
        <?php endif; ?>
    </ul>
</li>
<?php endif; ?>



<!-- Inventory -->
<?php if(Gate::check('manage inventory')): ?>
<li class="pc-item pc-hasmenu <?php echo e(request()->routeIs('inventory.*') ? 'active pc-trigger' : ''); ?>">
    <a href="#" class="pc-link d-flex align-items-center">
        <span class="pc-micon"><i class="fa-solid fa-warehouse"></i></span>
        <span class="pc-mtext ms-2">Inventory</span>
        <span class="ms-auto"><i class="fa-solid fa-circle-plus"></i></span>
    </a>

    <ul class="pc-submenu">
        <!-- Inventory Operations -->
        <li class="pc-item pc-hasmenu">
            <a href="#" class="pc-link d-flex justify-content-between align-items-center" onclick="toggleSubmenu(this)">
                <span>Operations</span>
                <span class="ms-auto icon-wrapper">
                    <i class="fa-solid fa-circle-plus"></i>
                </span>
            </a>
            <ul class="pc-submenu" style="display: none;">
                <li><a class="pc-link" href="<?php echo e(route('inventory.stock-level.index')); ?>">Stock Level</a></li>
                <li><a class="pc-link" href="<?php echo e(route('inventory.stock-in.index')); ?>">Stock In</a></li>
                <li><a class="pc-link" href="<?php echo e(route('inventory.stock-out.index')); ?>">Stock Out</a></li>
                <li><a class="pc-link" href="<?php echo e(route('inventory.stock-transfer.index')); ?>">Stock Transfer</a></li>
                <li><a class="pc-link" href="<?php echo e(route('inventory.stock-adjustments.index')); ?>">Stock Adjustment</a></li>
                <li><a class="pc-link" href="<?php echo e(route('inventory.stock-alerts.index')); ?>">Stock Alert</a></li>
            </ul>
        </li>

        <!-- Purchase Request -->
        <li class="pc-item <?php echo e(request()->routeIs('inventory.purchase-requests.index') ? 'active' : ''); ?>">
            <a href="<?php echo e(route('inventory.purchase-requests.index')); ?>" class="pc-link">
                <span class="pc-mtext">Requests</span>
            </a>
        </li>

        <!-- Product Master Data -->
        <li class="pc-item pc-hasmenu">
            <a href="#" class="pc-link d-flex justify-content-between align-items-center" onclick="toggleSubmenu(this)">
                <span>Product Master</span>
                <span class="ms-auto icon-wrapper">
                    <i class="fa-solid fa-circle-plus"></i>
                </span>
            </a>
            <ul class="pc-submenu" style="display: none;">
                <li><a class="pc-link" href="<?php echo e(route('inventory.products.index')); ?>">Products</a></li>
                <li><a class="pc-link" href="<?php echo e(route('inventory.categories.index')); ?>">Categories</a></li>
                <li><a class="pc-link" href="<?php echo e(route('inventory.uoms.index')); ?>">Unit of Measure</a></li>
                <li><a class="pc-link" href="<?php echo e(route('inventory.locations.index')); ?>">Locations</a></li>
                <li><a class="pc-link" href="<?php echo e(route('inventory.barcodes.index')); ?>">Barcode Generator</a></li>
                <li><a class="pc-link" href="<?php echo e(route('inventory.logs.index')); ?>">Logs</a></li>
            </ul>
        </li>
    </ul>
</li>
<?php endif; ?>







<!-- Shipping -->
<?php if(
    Gate::check('manage orders') || Gate::check('manage carts') || Gate::check('view all deliveries') ||
    Gate::check('view today deliveries') || Gate::check('view upcoming deliveries') || Gate::check('manage calendar') ||
    Gate::check('manage deliveries') || Gate::check('manage routes') || Gate::check('manage my route') ||
    Gate::check('manage trucks') || Gate::check('manage drivers') || Gate::check('manage shops')
): ?>
<li class="pc-item pc-hasmenu <?php echo e(request()->routeIs('shipping.*') ? 'active pc-trigger' : ''); ?>">
    <a href="#" class="pc-link d-flex align-items-center" onclick="toggleSubmenu(this)">
        <span class="pc-micon"><i class="fa-solid fa-dolly"></i></span>
        <span class="pc-mtext ms-2">Shipping</span>
        <span class="ms-auto"><i class="fa-solid fa-circle-plus"></i></span>
    </a>

    <ul class="pc-submenu" style="display: none;">

        
        <?php if(Gate::check('manage orders') || Gate::check('manage carts')): ?>
        <li class="pc-item pc-hasmenu">
            <a href="#" class="pc-link d-flex justify-content-between align-items-center" onclick="toggleSubmenu(this)">
                <span>Uploads</span>
                <span class="ms-auto icon-wrapper"><i class="fa-solid fa-circle-plus"></i></span>
            </a>
            <ul class="pc-submenu" style="display: none;">
                <?php if(Gate::check('manage orders')): ?>
                <li><a class="pc-link" href="<?php echo e(route('orders.index')); ?>">Orders</a></li>
                <?php endif; ?>
                <?php if(Gate::check('manage carts')): ?>
                <li><a class="pc-link" href="<?php echo e(route('cims.index')); ?>">Locations</a></li>
                <?php endif; ?>
            </ul>
        </li>
        <?php endif; ?>

        
        <?php if(
            Gate::check('view all deliveries') || Gate::check('view today deliveries') ||
            Gate::check('view upcoming deliveries') || Gate::check('manage calendar') ||
            Gate::check('manage deliveries') || Gate::check('manage pickups')
        ): ?>
        <li class="pc-item pc-hasmenu">
            <a href="#" class="pc-link d-flex justify-content-between align-items-center" onclick="toggleSubmenu(this)">
                <span>Panel</span>
                <span class="ms-auto icon-wrapper"><i class="fa-solid fa-circle-plus"></i></span>
            </a>
            <ul class="pc-submenu" style="display: none;">
                <?php if(Gate::check('manage calendar')): ?>
                <li><a class="pc-link" href="<?php echo e(route('calendar.index')); ?>">Calendar</a></li>
                <?php endif; ?>
                <?php if(Gate::check('view all deliveries')): ?>
                <li><a class="pc-link" href="<?php echo e(route('sr.deliveries.all')); ?>">Panel View</a></li>
                <?php endif; ?>
                <?php if(Gate::check('view today deliveries')): ?>
                <li><a class="pc-link" href="<?php echo e(route('sr.deliveries.today')); ?>">Today's Panel</a></li>
                <?php endif; ?>
                <?php if(Gate::check('view upcoming deliveries')): ?>
                <li><a class="pc-link" href="<?php echo e(route('sr.deliveries.upcoming')); ?>">Upcoming Panel</a></li>
                <?php endif; ?>
            </ul>
        </li>
        <?php endif; ?>

        
        <?php if(
            Gate::check('manage deliveries') || Gate::check('manage routes') ||
            Gate::check('manage pickups') || Gate::check('manage my route')
        ): ?>
        <li class="pc-item pc-hasmenu">
            <a href="#" class="pc-link d-flex justify-content-between align-items-center" onclick="toggleSubmenu(this)">
                <span>Routes</span>
                <span class="ms-auto icon-wrapper"><i class="fa-solid fa-circle-plus"></i></span>
            </a>
            <ul class="pc-submenu" style="display: none;">
                <?php if(Gate::check('manage deliveries')): ?>
                <li><a class="pc-link" href="<?php echo e(route('deliveries.index')); ?>">Deliveries</a></li>
                <li><a class="pc-link" href="<?php echo e(route('deliveries.today')); ?>">Today's Route</a></li>
                <li><a class="pc-link" href="<?php echo e(route('deliveries.upcoming')); ?>">Upcoming Route</a></li>
                <?php endif; ?>
                <?php if(Gate::check('manage pickups')): ?>
                <li><a class="pc-link" href="<?php echo e(route('pickups.index')); ?>">Pickups</a></li>
                <?php endif; ?>
                <?php if(Gate::check('manage routes')): ?>
                <li><a class="pc-link" href="<?php echo e(route('routes.auto')); ?>">Auto Routes</a></li>
                <li><a class="pc-link" href="<?php echo e(route('routes.plan')); ?>">Route Plan</a></li>
                <?php endif; ?>
                <?php if(Gate::check('manage my route')): ?>
                <li class="<?php echo e(request()->routeIs('routes.driver') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('routes.driver')); ?>" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-map"></i></span>
                        <span class="pc-mtext">My Route</span>
                    </a>
                </li>
                <?php endif; ?>
            </ul>
        </li>
        <?php endif; ?>

        
        <?php if(
            Gate::check('manage trucks') || Gate::check('manage routes') ||
            Gate::check('manage drivers') || Gate::check('manage shops')
        ): ?>
        <li class="pc-item pc-hasmenu">
            <a href="#" class="pc-link d-flex justify-content-between align-items-center" onclick="toggleSubmenu(this)">
                <span>Dispatch</span>
                <span class="ms-auto icon-wrapper"><i class="fa-solid fa-circle-plus"></i></span>
            </a>
            <ul class="pc-submenu" style="display: none;">
                <?php if(Gate::check('manage drivers')): ?>
                <li><a class="pc-link" href="<?php echo e(route('drivers.index')); ?>">Drivers</a></li>
                <?php endif; ?>
                <?php if(Gate::check('manage trucks')): ?>
                <li><a class="pc-link" href="<?php echo e(route('trucks.index')); ?>">Trucks</a></li>
                <?php endif; ?>
                <?php if(Gate::check('manage shops')): ?>
                <li><a class="pc-link" href="<?php echo e(route('shops.index')); ?>">Shops</a></li>
                <?php endif; ?>
            </ul>
        </li>
        <?php endif; ?>

        
        <?php if(Gate::check('manage shipping settings')): ?>
        <li class="pc-item">
            <a href="<?php echo e(route('settings.shipping')); ?>" class="pc-link d-flex justify-content-between align-items-center">
                <span>Settings</span>
            </a>
        </li>
        <?php endif; ?>

    </ul>
</li>
<?php endif; ?>







<!-- Miscellaneous -->
<?php if(Gate::check('manage miscellaneous')): ?>
<li class="pc-item pc-hasmenu <?php echo e(request()->routeIs('miscellaneous.*') ? 'active pc-trigger' : ''); ?>">
    <a href="#" class="pc-link d-flex align-items-center">
        <span class="pc-micon"><i class="fa-solid fa-network-wired"></i></span>
        <span class="pc-mtext ms-2">Miscellaneous</span>
        <span class="ms-auto"><i class="fa-solid fa-circle-plus"></i></span>
    </a>

    <ul class="pc-submenu">
         <li class="pc-item pc-hasmenu">
            <a href="#" class="pc-link d-flex justify-content-between align-items-center" onclick="toggleSubmenu(this)">
                <span>Purchasing</span>
                <span class="ms-auto icon-wrapper">
                    <i class="fa-solid fa-circle-plus"></i>
                </span>
            </a>
            <ul class="pc-submenu" style="display: none;">
                <li><a class="pc-link" href="#">New Quote</a></li>
                <li><a class="pc-link" href="#">Quote History</a></li>
            </ul>
        </li>
    </ul>
</li>
<?php endif; ?>


<!-- Bill of Material -->
<?php if(Gate::check('manage bom')): ?>
<li class="pc-item pc-hasmenu <?php echo e(request()->routeIs('bom.*') ? 'active pc-trigger' : ''); ?>">
    <a href="#" class="pc-link d-flex align-items-center">
        <span class="pc-micon"><i class="fa-solid fa-b"></i></span>
        <span class="pc-mtext ms-2">Bill of Material</span>
        <span class="ms-auto"><i class="fa-solid fa-circle-plus"></i></span>
    </a>

    <ul class="pc-submenu">
 <li class="pc-item <?php echo e(request()->routeIs('master.bom.*') ? 'active' : ''); ?>">
    <a href="<?php echo e(route('calculator.index')); ?>" class="pc-link">
        <span class="pc-mtext">Calculator</span>
    </a>
</li>   

        <!-- Colors -->
        <li class="pc-item pc-hasmenu">
            <a href="#" class="pc-link d-flex justify-content-between align-items-center" onclick="toggleSubmenu(this)">
                <span>Menu</span>
                <span class="ms-auto icon-wrapper">
                    <i class="fa-solid fa-circle-plus"></i>
                </span>
            </a>
            <ul class="pc-submenu" style="display: none;">
<li><a class="pc-link" href="<?php echo e(route('frametype.index')); ?>">Frame Type</a></li>
<li><a class="pc-link" href="<?php echo e(route('gridtype.index')); ?>">Grid Type</a></li>
<li><a class="pc-link" href="<?php echo e(route('glasstype.index')); ?>">Glass Type</a></li>
<li><a class="pc-link" href="<?php echo e(route('lockcover.index')); ?>">Lock Cover</a></li>
<li><a class="pc-link" href="<?php echo e(route('waterflow.index')); ?>">Water Flow</a></li>
<li><a class="pc-link" href="<?php echo e(route('mullcap.index')); ?>">Mull Cap</a></li>
<li><a class="pc-link" href="<?php echo e(route('mesh.index')); ?>">Mesh</a></li>
<li><a class="pc-link" href="<?php echo e(route('mullstack.index')); ?>">Mull Stack</a></li>
<li><a class="pc-link" href="<?php echo e(route('stop.index')); ?>">Stop</a></li>
<li><a class="pc-link" href="<?php echo e(route('rollertrack.index')); ?>">Roller Track</a></li>
<li><a class="pc-link" href="<?php echo e(route('doubletape.index')); ?>">Double Tape</a></li>
<li><a class="pc-link" href="<?php echo e(route('snapping.index')); ?>">Snapping</a></li>
<li><a class="pc-link" href="<?php echo e(route('gridpattern.index')); ?>">Grid Pattern</a></li>
<li><a class="pc-link" href="<?php echo e(route('locktype.index')); ?>">Lock Type</a></li>
<li><a class="pc-link" href="<?php echo e(route('spacer.index')); ?>">Spacer</a></li>
<li><a class="pc-link" href="<?php echo e(route('screen.index')); ?>">Screen</a></li>
<li><a class="pc-link" href="<?php echo e(route('strikescrew.index')); ?>">Strike Screw</a></li>
<li><a class="pc-link" href="<?php echo e(route('strike.index')); ?>">Strike</a></li>
<li><a class="pc-link" href="<?php echo e(route('lockscrew.index')); ?>">Lock Screw</a></li>
<li><a class="pc-link" href="<?php echo e(route('tensionspring.index')); ?>">Tension Spring</a></li>
<li><a class="pc-link" href="<?php echo e(route('pullers.index')); ?>">Pullers</a></li>
<li><a class="pc-link" href="<?php echo e(route('corners.index')); ?>">Corners</a></li>
<li><a class="pc-link" href="<?php echo e(route('spline.index')); ?>">Spline</a></li>
<li><a class="pc-link" href="<?php echo e(route('warninglabel.index')); ?>">Warning Label</a></li>
<li><a class="pc-link" href="<?php echo e(route('aluminumreinforcement.index')); ?>">Aluminum Reinforcement</a></li>
<li><a class="pc-link" href="<?php echo e(route('steelreinforcement.index')); ?>">Steel Reinforcement</a></li>
<li><a class="pc-link" href="<?php echo e(route('reinforcementmaterial.index')); ?>">Reinforcement Material</a></li>
<li><a class="pc-link" href="<?php echo e(route('mullscrew.index')); ?>">Mull Screw</a></li>
<li><a class="pc-link" href="<?php echo e(route('interlockreinforcement.index')); ?>">Interlock Reinforcement</a></li>
<li><a class="pc-link" href="<?php echo e(route('rollers.index')); ?>">Rollers</a></li>
<li><a class="pc-link" href="<?php echo e(route('interlock.index')); ?>">Interlock</a></li>
<li><a class="pc-link" href="<?php echo e(route('sash.index')); ?>">Sash</a></li>
<li><a class="pc-link" href="<?php echo e(route('elitelabel.index')); ?>">Elite Label</a></li>
<li><a class="pc-link" href="<?php echo e(route('settingblock.index')); ?>">Setting Block</a></li>
<li><a class="pc-link" href="<?php echo e(route('nightlock.index')); ?>">Night Lock</a></li>
<li><a class="pc-link" href="<?php echo e(route('antitheft.index')); ?>">Anti-Theft</a></li>
<li><a class="pc-link" href="<?php echo e(route('ammalabel.index')); ?>">AMMA Label</a></li>
<a class="pc-link" href="<?php echo e(route('mullreinforcement.index')); ?>">Mull Reinforcement</a>
<a class="pc-link" href="<?php echo e(route('sashreinforcement.index')); ?>">Sash Reinforcement</a>

            </ul>
        </li>
        <!-- Prices -->
<li class="pc-item <?php echo e(request()->routeIs('master.dashboard.*') ? 'active' : ''); ?>">
    <a href="<?php echo e(route('prices.index')); ?>" class="pc-link">
        <span class="pc-mtext">Prices</span>
    </a>
</li>  
        
    </ul>
</li>
<?php endif; ?>













<!-- Master -->
<?php if(Gate::check('manage master')): ?>
<li class="pc-item pc-hasmenu <?php echo e(request()->routeIs('master.*') ? 'active pc-trigger' : ''); ?>">
    <a href="#" class="pc-link d-flex align-items-center">
        <span class="pc-micon"><i class="fa-solid fa-brain"></i></span>
        <span class="pc-mtext ms-2">Master</span>
        <span class="ms-auto"><i class="fa-solid fa-circle-plus"></i></span>
    </a>

    <ul class="pc-submenu">
 <li class="pc-item <?php echo e(request()->routeIs('master.dashboard.*') ? 'active' : ''); ?>">
    <a href="<?php echo e(route('master.customers.index')); ?>" class="pc-link">
        <span class="pc-mtext">Customers</span>
    </a>
</li>   
<li class="pc-item <?php echo e(request()->routeIs('master.dashboard.*') ? 'active' : ''); ?>">
    <a href="<?php echo e(route('master.suppliers.index')); ?>" class="pc-link">
        <span class="pc-mtext">Suppliers</span>
    </a>
</li>
        <!-- Library -->
        <li class="pc-item pc-hasmenu">
            <a href="#" class="pc-link d-flex justify-content-between align-items-center" onclick="toggleSubmenu(this)">
                <span>Library</span>
                <span class="ms-auto icon-wrapper">
                    <i class="fa-solid fa-circle-plus"></i>
                </span>
            </a>
            <ul class="pc-submenu" style="display: none;">
                <li><a class="pc-link" href="<?php echo e(route('master.library.configurations.index')); ?>">Configuration</a></li>
                <li><a class="pc-link" href="#">Files</a></li>

            </ul>
        </li>


        <!-- Colors -->
        <li class="pc-item pc-hasmenu">
            <a href="#" class="pc-link d-flex justify-content-between align-items-center" onclick="toggleSubmenu(this)">
                <span>Colors</span>
                <span class="ms-auto icon-wrapper">
                    <i class="fa-solid fa-circle-plus"></i>
                </span>
            </a>
            <ul class="pc-submenu" style="display: none;">
                <li><a class="pc-link" href="<?php echo e(route('color-options.color-configurations.index')); ?>">Configuration</a></li>
<li><a class="pc-link" href="<?php echo e(route('color-options.exterior-colors.index')); ?>">Exterior Colors</a></li>
<li><a class="pc-link" href="<?php echo e(route('color-options.interior-colors.index')); ?>">Interior Colors</a></li>
<li><a class="pc-link" href="<?php echo e(route('color-options.laminate-colors.index')); ?>">Laminate Colors</a></li>

                <li><a class="pc-link" href="#">System Colors</a></li>
                <li><a class="pc-link" href="#">Status Colors</a></li>

            </ul>
        </li>
        <!-- Series -->
<li class="pc-item pc-hasmenu">
    <a href="#" class="pc-link d-flex justify-content-between align-items-center" onclick="toggleSubmenu(this)">
        <span>Series</span>
        <span class="ms-auto icon-wrapper">
            <i class="fa-solid fa-circle-plus"></i>
        </span>
    </a>
    <ul class="pc-submenu" style="display: none;">
        <li><a class="pc-link" href="<?php echo e(route('master.series.index')); ?>">Series</a></li>
        <li><a class="pc-link" href="<?php echo e(route('master.series-type.index')); ?>">Configuration</a></li>
    </ul>
</li>

        <!-- Products -->
        <li class="pc-item pc-hasmenu">
            <a href="#" class="pc-link d-flex justify-content-between align-items-center" onclick="toggleSubmenu(this)">
                <span>Products</span>
                <span class="ms-auto icon-wrapper">
                    <i class="fa-solid fa-circle-plus"></i>
                </span>
            </a>
            <ul class="pc-submenu" style="display: none;">
    <li>
        <a class="pc-link" href="#">Product Master</a>
        <ul class="pc-submenu" style="display: none;">
            <li>
                <a class="pc-link" href="<?php echo e(route('product_master.accessories.index')); ?>">Accessories</a>
            </li>
            <li>
                <a class="pc-link" href="<?php echo e(route('product_master.glassinsert.index')); ?>">Glass/Inserts</a>
            </li>
            <li>
                <a class="pc-link" href="<?php echo e(route('product_master.hardwarevariant.index')); ?>">Hardware Variants</a>
                <ul class="pc-submenu" style="display: none;">
                    <li>
                        <a class="pc-link" href="<?php echo e(route('product_master.hardwareparts.index')); ?>">Parts</a>
                    </li>
                </ul>
            </li>
            <li>
                <a class="pc-link" href="<?php echo e(route('product_master.materials.index')); ?>">Materials</a>
            </li>
            <li>
                <a class="pc-link" href="<?php echo e(route('product_master.profiles.index')); ?>">Profiles</a>
                <ul class="pc-submenu" style="display: none;">
                    <li>
                        <a class="pc-link" href="#">Reinforcements</a> 
                    </li>
                </ul>
            </li>
            <li>
                <a class="pc-link" href="<?php echo e(route('product_master.units.index')); ?>">Units</a>
            </li>
        </ul>
    </li>

                <li><a class="pc-link" href="<?php echo e(route('products.product_classes.index')); ?>">Product Classes</a></li>
<li><a class="pc-link" href="<?php echo e(route('products.basic_products.index')); ?>">Basic Products</a></li>
<li><a class="pc-link" href="<?php echo e(route('products.grille_patterns.index')); ?>">Grille Patterns</a></li>
<li><a class="pc-link" href="<?php echo e(route('products.profile_records.index')); ?>">Profile Records</a></li>
<li><a class="pc-link" href="<?php echo e(route('products.corner_exchange.index')); ?>">Corner Exchange</a></li>
<li><a class="pc-link" href="<?php echo e(route('products.profile_types.index')); ?>">Profile Types</a></li>
<li><a class="pc-link" href="<?php echo e(route('products.sealing_assignment.index')); ?>">Sealing Assignment</a></li>
<li><a class="pc-link" href="<?php echo e(route('products.reinforcement_assignments.index')); ?>">Reinforcement Assignments</a></li>
<li><a class="pc-link" href="<?php echo e(route('products.hardware_types.index')); ?>">Hardware Types</a></li>
<li><a class="pc-link" href="<?php echo e(route('products.system_color.index')); ?>">System / Color</a></li>


            </ul>
        </li>
        <!-- Colors -->
        <li class="pc-item pc-hasmenu">
            <a href="#" class="pc-link d-flex justify-content-between align-items-center" onclick="toggleSubmenu(this)">
                <span>Product Keys</span>
                <span class="ms-auto icon-wrapper">
                    <i class="fa-solid fa-circle-plus"></i>
                </span>
            </a>
            <ul class="pc-submenu" style="display: none;">
                <li><a class="pc-link" href="<?php echo e(route('product_keys.producttypes.index')); ?>">Product Types</a></li>
<li><a class="pc-link" href="<?php echo e(route('product_keys.productareas.index')); ?>">Product Areas</a></li>
<li><a class="pc-link" href="<?php echo e(route('product_keys.productsystems.index')); ?>">Product Systems</a></li>
<li><a class="pc-link" href="<?php echo e(route('product_keys.manufacturersystems.index')); ?>">Manufacturer Systems</a></li>
<li><a class="pc-link" href="<?php echo e(route('product_keys.specialshapemacros.index')); ?>">Special Shape Macros</a></li>
<li><a class="pc-link" href="<?php echo e(route('product_keys.shapecatalog.index')); ?>">Shape Catalog</a></li>
<li><a class="pc-link" href="<?php echo e(route('product_keys.drawingobjects.index')); ?>">Drawing Objects</a></li>

                <li><a class="pc-link" href="#">Color Groups</a></li>
                <li><a class="pc-link" href="#">Color Classes</a></li>
                <li><a class="pc-link" href="#">Color Levels</a></li>
                <li><a class="pc-link" href="#">System / Color</a></li>

            </ul>
        </li>
         
         
        <li class="pc-item pc-hasmenu">
            <a href="#" class="pc-link d-flex justify-content-between align-items-center" onclick="toggleSubmenu(this)">
                <span>Prices/Discounts</span>
                <span class="ms-auto icon-wrapper">
                    <i class="fa-solid fa-circle-plus"></i>
                </span>
            </a>
            <ul class="pc-submenu" style="display: none;">
                <li><a class="pc-link" href="<?php echo e(route('master.prices.matrice.index')); ?>">Price Matrice</a></li>
                <li><a class="pc-link" href="#">Customer Prices</a></li>
<li><a class="pc-link" href="<?php echo e(route('prices.productprices.index')); ?>">Add-On Prices</a></li>
                <li><a class="pc-link" href="<?php echo e(route('master.prices.markup.index')); ?>">Markup</a></li>
                <li><a class="pc-link" href="#">Schema</a></li>
                <li><a class="pc-link" href="#">Price Group</a></li>
                <li><a class="pc-link" href="#">Global Discount</a></li>
                <li><a class="pc-link" href="#">Price Cycle</a></li>
                <li><a class="pc-link" href="#">Generation</a></li>
                <li><a class="pc-link" href="#">Currencies</a></li>
                <li><a class="pc-link" href="#">Exchange Rates</a></li>
                <li><a class="pc-link" href="#">FinAc Accounts</a></li>
                <li><a class="pc-link" href="#">Acc Assignment</a></li>
                <li><a class="pc-link" href="#">Global Discount</a></li>
                <li><a class="pc-link" href="#">Calc Schemes</a></li>
                <li><a class="pc-link" href="#">Calc Set</a></li>
                <li><a class="pc-link" href="#">Commissions</a></li>
                <li><a class="pc-link" href="#">Tax Codes</a></li>
                <li><a class="pc-link" href="#">Tax Classes</a></li>
                <li><a class="pc-link" href="#">Exchange Rules</a></li>
                <li><a class="pc-link" href="#">Tax Rules</a></li>
            </ul>
        </li>
    </ul>
</li>
<?php endif; ?>

<!-- Addon Schema -->
<?php if(Gate::check('manage schema')): ?>
<li class="pc-item pc-hasmenu <?php echo e(request()->routeIs('schema.*') ? 'active pc-trigger' : ''); ?>">
    <a href="#" class="pc-link d-flex align-items-center">
        <span class="pc-micon"><i class="fa-solid fa-database"></i></span>
        <span class="pc-mtext ms-2">Schema/Addon</span>
        <span class="ms-auto"><i class="fa-solid fa-circle-plus"></i></span>
    </a>

    <ul class="pc-submenu">
         <li class="pc-item pc-hasmenu">
            <a href="#" class="pc-link d-flex justify-content-between align-items-center" onclick="toggleSubmenu(this)">
                <span>Schema</span>
                <span class="ms-auto icon-wrapper">
                    <i class="fa-solid fa-circle-plus"></i>
                </span>
            </a>
            <ul class="pc-submenu" style="display: none;">
                <li><a class="pc-link" href="<?php echo e(route('hs-unit.index')); ?>">HS Unit</a></li>
<li><a class="pc-link" href="<?php echo e(route('sh-unit.index')); ?>">SH Unit</a></li>
<li><a class="pc-link" href="<?php echo e(route('dh-unit.index')); ?>">DH Unit</a></li>
<li><a class="pc-link" href="<?php echo e(route('xx-unit.index')); ?>">XX Unit</a></li>
<li><a class="pc-link" href="<?php echo e(route('cm-unit.index')); ?>">CM Unit</a></li>
<li><a class="pc-link" href="<?php echo e(route('pw-unit.index')); ?>">PW Unit</a></li>
<li><a class="pc-link" href="<?php echo e(route('sld-unit.index')); ?>">SLD Unit</a></li>
<li><a class="pc-link" href="<?php echo e(route('swd-unit.index')); ?>">SWD Unit</a></li>
<li><a class="pc-link" href="<?php echo e(route('gsco-hsunit.index')); ?>">GSCO HS Unit</a></li>
<li><a class="pc-link" href="<?php echo e(route('gsco-shunit.index')); ?>">GSCO SH Unit</a></li>
<li><a class="pc-link" href="<?php echo e(route('gsco-dhunit.index')); ?>">GSCO DH Unit</a></li>
<li><a class="pc-link" href="<?php echo e(route('gsco-pwunit.index')); ?>">GSCO PW Unit</a></li>
<li><a class="pc-link" href="<?php echo e(route('gsco-xxunit.index')); ?>">GSCO XX Unit</a></li>
<li><a class="pc-link" href="<?php echo e(route('gsco-cmunit.index')); ?>">GSCO CM Unit</a></li>
<li><a class="pc-link" href="<?php echo e(route('gsco-sldunit.index')); ?>">GSCO SLD Unit</a></li>
<li><a class="pc-link" href="<?php echo e(route('gsco-swdunit.index')); ?>">GSCO SWD Unit</a></li>
<li><a class="pc-link" href="<?php echo e(route('cmpromo.index')); ?>">CM Promo</a></li>
<li><a class="pc-link" href="<?php echo e(route('window-door-field.index')); ?>">Window & Door Field</a></li>


            </ul>
        </li>

        <!-- Orders submenu with toggle icon -->
        <li class="pc-item pc-hasmenu">
            <a href="#" class="pc-link d-flex justify-content-between align-items-center" onclick="toggleSubmenu(this)">
                <span>AddOns</span>
                <span class="ms-auto icon-wrapper">
                    <i class="fa-solid fa-circle-plus"></i>
                </span>
            </a>
            <ul class="pc-submenu" style="display: none;">
                <li><a class="pc-link" href="<?php echo e(route('master.sales.addons.index')); ?>">Prices</a></li>
                <li><a class="pc-link" href="#">AddOns</a></li>
            </ul>
        </li>
    </ul>
</li>
<?php endif; ?>



<!-- Reports -->
<?php if(Gate::check('view reports')): ?>
<li class="pc-item pc-hasmenu <?php echo e(request()->routeIs('reports.*') ? 'active pc-trigger' : ''); ?>">
    <a href="#" class="pc-link d-flex align-items-center">
        <span class="pc-micon"><i class="fa-solid fa-flag"></i></span>
        <span class="pc-mtext ms-2">Reports</span>
        <span class="ms-auto"><i class="fa-solid fa-circle-plus"></i></span>
    </a>

    <ul class="pc-submenu">
         <li class="pc-item pc-hasmenu">
            <a href="#" class="pc-link d-flex justify-content-between align-items-center" onclick="toggleSubmenu(this)">
                <span>Purchasing</span>
                <span class="ms-auto icon-wrapper">
                    <i class="fa-solid fa-circle-plus"></i>
                </span>
            </a>
            <ul class="pc-submenu" style="display: none;">
                <li><a class="pc-link" href="#">New Quote</a></li>
                <li><a class="pc-link" href="#">Quote History</a></li>
            </ul>
        </li>

        <!-- Orders submenu with toggle icon -->
        <li class="pc-item pc-hasmenu">
            <a href="#" class="pc-link d-flex justify-content-between align-items-center" onclick="toggleSubmenu(this)">
                <span>Orders</span>
                <span class="ms-auto icon-wrapper">
                    <i class="fa-solid fa-circle-plus"></i>
                </span>
            </a>
            <ul class="pc-submenu" style="display: none;">
                <li><a class="pc-link" href="#">New Order</a></li>
                <li><a class="pc-link" href="#">Order History</a></li>
            </ul>
        </li>
         <li class="pc-item pc-hasmenu">
            <a href="#" class="pc-link d-flex justify-content-between align-items-center" onclick="toggleSubmenu(this)">
                <span>Invoice</span>
                <span class="ms-auto icon-wrapper">
                    <i class="fa-solid fa-circle-plus"></i>
                </span>
            </a>
            <ul class="pc-submenu" style="display: none;">
                <li><a class="pc-link" href="#">New Invoice</a></li>
                <li><a class="pc-link" href="#">Invoice History</a></li>
            </ul>
        </li>
    </ul>
</li>
<?php endif; ?>

                
                
<!-- Executive -->
<?php if(Gate::check('manage executive')): ?>
<li class="pc-item pc-hasmenu <?php echo e(request()->routeIs('executives.*') ? 'active pc-trigger' : ''); ?>">
    <a href="#" class="pc-link d-flex align-items-center">
        <span class="pc-micon"><i class="ti ti-briefcase"></i></span>
        <span class="pc-mtext ms-2">Executive</span>
        <span class="ms-auto"><i class="fa-solid fa-circle-plus"></i></span>
    </a>

    <ul class="pc-submenu">
         <li class="pc-item pc-hasmenu">
            <a href="#" class="pc-link d-flex justify-content-between align-items-center" onclick="toggleSubmenu(this)">
                <span>Benefits</span>
                <span class="ms-auto icon-wrapper">
                    <i class="fa-solid fa-circle-plus"></i>
                </span>
            </a>
            <ul class="pc-submenu" style="display: none;">
                <li><a class="pc-link" href="<?php echo e(route('executives.tiers.index')); ?>">Tiers</a></li>
                <li><a class="pc-link" href="<?php echo e(route('executives.raffle.index')); ?>">Raffle</a></li>
            </ul>
        </li>
        <!-- Orders submenu with toggle icon -->
        <li class="pc-item pc-hasmenu">
            <a href="#" class="pc-link d-flex justify-content-between align-items-center" onclick="toggleSubmenu(this)">
                <span>Pricing</span>
                <span class="ms-auto icon-wrapper">
                    <i class="fa-solid fa-circle-plus"></i>
                </span>
            </a>
            <ul class="pc-submenu" style="display: none;">
                <li><a class="pc-link" href="<?php echo e(route('inventory.configurator.index')); ?>">Configurator</a></li>
                <li><a class="pc-link" href="<?php echo e(route('executives.formulas.index')); ?>">Formula</a></li>
                <li><a class="pc-link" href="">Pricing</a></li>
                <li><a class="pc-link" href="<?php echo e(route('form-options.index')); ?>">Form Options</a></li>
            </ul>
        </li>
    </ul>
</li>
<?php endif; ?>


<?php if(Gate::check('manage manufacturing')): ?>
<!-- Manufacturing Section Label -->
<li class="pc-item pc-caption d-flex justify-content-between align-items-center">
    <div>
        <label><?php echo e(__('Manufacturing')); ?></label>
        <i class="ti ti-chart-arcs"></i>
    </div>
    <i class="ti ti-plus text-muted pe-2" style="font-size: 0.9rem;"></i>
</li>

<!-- Manufacturing Menu -->
<li class="pc-item pc-hasmenu <?php echo e(request()->routeIs('shipping.*') ? 'active pc-trigger' : ''); ?>">
    <a href="#" class="pc-link d-flex align-items-center">
        <span class="pc-micon"><i class="ti ti-briefcase"></i></span>
        <span class="pc-mtext ms-2">Production</span>
        <span class="ms-auto"><i class="fa-solid fa-circle-plus"></i></span>
    </a>

    <ul class="pc-submenu">
        <li class="pc-item pc-hasmenu">
            <a href="#" class="pc-link d-flex justify-content-between align-items-center" onclick="toggleSubmenu(this)">
                <span>Dashboard</span>
                <span class="ms-auto icon-wrapper"><i class="fa-solid fa-circle-plus"></i></span>
            </a>
            <ul class="pc-submenu" style="display: none;">
                <li><a class="pc-link" href="<?php echo e(route('homepage.index')); ?>">Machines</a></li>
                <li><a class="pc-link" href="<?php echo e(route('pages.index')); ?>">Stations</a></li>
                <li><a class="pc-link" href="<?php echo e(route('FAQ.index')); ?>">FAQ</a></li>
            </ul>
        </li>
    </ul>
</li>
<?php endif; ?>

<!-- Settings Section -->
<?php if(
    Gate::check('manage pricing packages') ||
    Gate::check('manage pricing transation') ||
    Gate::check('manage account settings') ||
    Gate::check('manage password settings') ||
    Gate::check('manage general settings') ||
    Gate::check('manage email settings') ||
    Gate::check('manage payment settings') ||
    Gate::check('manage company settings') ||
    Gate::check('manage seo settings') ||
    Gate::check('manage google recaptcha settings')
): ?>
    <!-- Settings Section -->
    <li class="pc-item pc-caption d-flex justify-content-between align-items-center">
        <div>
            <label><?php echo e(__('Settings')); ?></label>
            <i class="ti ti-chart-arcs"></i>
        </div>
        <i class="ti ti-plus text-muted pe-2" style="font-size: 0.9rem;"></i>
    </li>

    <li class="pc-item pc-hasmenu <?php echo e(request()->routeIs('settings.*') ? 'active pc-trigger' : ''); ?>">
        <a href="#" class="pc-link d-flex align-items-center">
            <span class="pc-micon"><i class="ti ti-briefcase"></i></span>
            <span class="pc-mtext ms-2">Settings</span>
            <span class="ms-auto"><i class="fa-solid fa-circle-plus"></i></span>
        </a>

        <ul class="pc-submenu">

            
            <?php if(Gate::check('manage FAQ') || Gate::check('manage Page')): ?>
            <li class="pc-item pc-hasmenu <?php echo e(in_array($routeName, ['homepage.index', 'FAQ.index', 'pages.index', 'footerSetting']) ? 'active' : ''); ?>">
                <a href="#!" class="pc-link">
                    <span class="pc-micon"><i class="ti ti-layout-rows"></i></span>
                    <span class="pc-mtext"><?php echo e(__('CMS')); ?></span>
                    <span class="pc-arrow"><i class="fa-solid fa-circle-plus"></i></span>
                </a>
                <ul class="pc-submenu"
                    style="display: <?php echo e(in_array($routeName, ['homepage.index', 'FAQ.index', 'pages.index', 'footerSetting']) ? 'block' : 'none'); ?>">
                    <?php if(Gate::check('manage home page')): ?>
                    <li class="pc-item <?php echo e($routeName == 'homepage.index' ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('homepage.index')); ?>" class="pc-link"><?php echo e(__('Home Page')); ?></a>
                    </li>
                    <?php endif; ?>
                    <?php if(Gate::check('manage Page')): ?>
                    <li class="pc-item <?php echo e($routeName == 'pages.index' ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('pages.index')); ?>" class="pc-link"><?php echo e(__('Custom Page')); ?></a>
                    </li>
                    <?php endif; ?>
                    <?php if(Gate::check('manage FAQ')): ?>
                    <li class="pc-item <?php echo e($routeName == 'FAQ.index' ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('FAQ.index')); ?>" class="pc-link"><?php echo e(__('FAQ')); ?></a>
                    </li>
                    <?php endif; ?>
                    <?php if(Gate::check('manage footer')): ?>
                    <li class="pc-item <?php echo e($routeName == 'footerSetting' ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('footerSetting')); ?>" class="pc-link"><?php echo e(__('Footer')); ?></a>
                    </li>
                    <?php endif; ?>
                    <?php if(Gate::check('manage auth page')): ?>
                    <li class="pc-item <?php echo e($routeName == 'authPage.index' ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('authPage.index')); ?>" class="pc-link"><?php echo e(__('Auth Page')); ?></a>
                    </li>
                    <?php endif; ?>
                </ul>
            </li>
            <?php endif; ?>

            
            <?php if(Auth::user()->type == 'super admin' || $pricing_feature_settings == 'on'): ?>
                <?php if(Gate::check('manage pricing packages') || Gate::check('manage pricing transation')): ?>
                <li class="pc-item pc-hasmenu">
                    <a href="#!" class="pc-link">
                    <span class="pc-micon"><i class="ti ti-money"></i></span>
                    <span class="pc-mtext"><?php echo e(__('Pricing')); ?></span>
                    <span class="pc-arrow"><i class="fa-solid fa-circle-plus"></i></span>
                </a>
                    <ul class="pc-submenu" style="display: none;">
                        <li><a class="pc-link" href="<?php echo e(route('subscriptions.index')); ?>">Packages</a></li>
                        <li class="pc-item <?php echo e($routeName == 'subscription.transaction' ? 'active' : ''); ?>">
                            <a class="pc-link" href="<?php echo e(route('subscription.transaction')); ?>">Transactions</a>
                        </li>
                    </ul>
                </li>
                <?php endif; ?>
            <?php endif; ?>

            
            <?php if(Gate::check('manage coupon') || Gate::check('manage coupon history')): ?>
            <li class="pc-item pc-hasmenu <?php echo e(in_array($routeName, ['coupons.index', 'coupons.history']) ? 'active' : ''); ?>">
                <a href="#!" class="pc-link">
                    <span class="pc-micon"><i class="ti ti-shopping-cart-discount"></i></span>
                    <span class="pc-mtext"><?php echo e(__('Coupons')); ?></span>
                    <span class="pc-arrow"><i class="fa-solid fa-circle-plus"></i></span>
                </a>
                <ul class="pc-submenu"
                    style="display: <?php echo e(in_array($routeName, ['coupons.index', 'coupons.history']) ? 'block' : 'none'); ?>">
                    <?php if(Gate::check('manage coupon')): ?>
                    <li class="pc-item <?php echo e($routeName == 'coupons.index' ? 'active' : ''); ?>">
                        <a class="pc-link" href="<?php echo e(route('coupons.index')); ?>"><?php echo e(__('All Coupon')); ?></a>
                    </li>
                    <?php endif; ?>
                    <?php if(Gate::check('manage coupon history')): ?>
                    <li class="pc-item <?php echo e($routeName == 'coupons.history' ? 'active' : ''); ?>">
                        <a class="pc-link" href="<?php echo e(route('coupons.history')); ?>"><?php echo e(__('Coupon History')); ?></a>
                    </li>
                    <?php endif; ?>
                </ul>
            </li>
            <?php endif; ?>

            
            <?php if(
                Gate::check('manage account settings') ||
                Gate::check('manage password settings') ||
                Gate::check('manage general settings') ||
                Gate::check('manage email settings') ||
                Gate::check('manage payment settings') ||
                Gate::check('manage company settings') ||
                Gate::check('manage seo settings') ||
                Gate::check('manage google recaptcha settings')
            ): ?>
            <li class="pc-item <?php echo e($routeName == 'setting.index' ? 'active' : ''); ?>">
                <a href="<?php echo e(route('setting.index')); ?>" class="pc-link">
                    <span class="pc-micon"><i class="ti ti-settings"></i></span>
                    <span class="pc-mtext"><?php echo e(__('Settings')); ?></span>
                </a>
            </li>
            <?php endif; ?>

        </ul>
    </li>
<?php endif; ?>


            </ul>
            <div class="w-100 text-center">
                <div class="badge theme-version badge rounded-pill bg-light text-dark f-12"></div>
            </div>
        </div>
    </div>
</nav>



<?php $__env->startPush('scripts'); ?>
<script>
    function toggleSubmenu(el) {
        const submenu = el.nextElementSibling;
        const icon = el.querySelector('.icon-wrapper i');

        if (submenu && icon) {
            const isOpen = submenu.style.display === 'block';
            submenu.style.display = isOpen ? 'none' : 'block';
            icon.className = isOpen ? 'fa-solid fa-circle-plus' : 'fa-solid fa-circle-minus';
        }
    }
</script>
<?php $__env->stopPush(); ?>
<?php /**PATH /home4/aizwmjte/app.elitevinylwindows.com/resources/views/admin/menu.blade.php ENDPATH**/ ?>
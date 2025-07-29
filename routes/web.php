<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Spatie\Permission\PermissionRegistrar;


use App\Http\Controllers\Master\Customers\CustomerController;
use App\Http\Controllers\BillOfMaterials\Calculator\CalculatorController;
use App\Http\Controllers\BillOfMaterials\Prices\PriceController;
use App\Http\Controllers\Master\Sales\AddonController;
use App\Http\Controllers\Master\Library\ConfigurationController;
use App\Http\Controllers\Master\Suppliers\SupplierController;
use App\Http\Controllers\CrudGenerator\CrudGeneratorController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Settings\ShippingSettingsController;


use App\Http\Controllers\{
    Auth\VerifyEmailController,
    AuthPageController,
    HomeController,
    UserController,
    SubscriptionController,
    SettingController,
    PermissionController,
    RoleController,
    NoticeBoardController,
    ContactController,
    CouponController,
    FAQController,
    HomePageController,
    NotificationController,
    TemplateController,
    OTPController,
    PageController,
    PaymentController,
    VisitorController,
    VisitCategoryController,
    OrderController,
    CartController,
    TruckController,
    DeliveryController,
    PickupController,
    RouteController,
    SrDeliveryController,
    DriverController,
    ActionController,
    RingCentralController,
    CimController,
    CalendarController,
    ShopController,
    PlanRouteController,
    LeadController, 
    FormOptionController,
    FormOptionGroupController,
    ConfiguratorController,
    ExecutiveCustomerController,
    ExecutiveTierController,
    FormulaController,
    RaffleDrawController,
    WindowRenderController
};

use App\Http\Controllers\Master\Products\{
    ProductClassesController,
    BasicProductsController,
    GrillePatternsController,
    ProfileRecordsController,
    CornerExchangeController,
    ProfileTypesController,
    SealingAssignmentController,
    ReinforcementAssignmentsController,
    HardwareTypesController,
    SystemColorController
};

use App\Http\Controllers\Master\Products\ProductMaster\{
    AccessoriesController,
    GlassInsertController,
    HardwareVariantController,
    HardwarePartsController,
    MaterialsController,
    ProfilesController,
    UnitsController
};

use App\Http\Controllers\Master\Prices\{
    ProductPricesController,
    MatriceController,
    MarkupController
};

use App\Http\Controllers\Master\ProductKeys\{
    ProductTypeController,
    ProductAreaController,
    ProductSystemController,
    ManufacturerSystemController,
    SpecialShapeMacroController,
    ShapeCatalogController,
    DrawingObjectController
};

use App\Http\Controllers\BillOfMaterials\Menu\{
    FrameTypeController,
    GridTypeController,
    LockCoverController,
    WaterFlowController,
    MullCapController,
    MeshController,
    MullStackController,
    StopController,
    RollerTrackController,
    DoubleTapeController,
    SnappingController,
    GridPatternController,
    GlassTypeController,
    LockTypeController,
    SpacerController,
    ScreenController,
    StrikeScrewController,
    StrikeController,
    LockScrewController,
    TensionSpringController,
    PullersController,
    CornersController,
    SplineController,
    WarningLabelController,
    AluminumReinforcementController,
    SteelReinforcementController,
    ReinforcementMaterialController,
    MullScrewController,
    InterlockReinforcementController,
    RollersController,
    InterlockController,
    SashController,
    EliteLabelController,
    SettingBlockController,
    NightLockController,
    AntiTheftController,
    AmmaLabelController,
    MullReinforcementController,
    SashReinforcementController
};

use App\Http\Controllers\Master\Series\{
    SeriesController,
    SeriesTypeController
};

use App\Http\Controllers\Sales\{
    QuoteController,
    SalesSettingsController,
    InvoiceController
};


use App\Http\Controllers\Master\Colors\{
    ColorConfigurationController,
    ExteriorColorController,
    InteriorColorController,
    LaminateColorController
};



use App\Http\Controllers\Schemas\{
    HSUnitController,
    SHUnitController,
    DHUnitController,
    XXUnitController,
    CMUnitController,
    PWUnitController,
    SLDUnitController,
    SWDUnitController,
    
    GSCOHSUnitController,
    GSCOSHUnitController,
    GSCODHUnitController,
    GSCOPWUnitController,
    GSCOXXUnitController,
    GSCOCMUnitController,
    GSCOSLDUnitController,
    GSCOSWDUnitController,

    CMPromoController,
    WindowDoorFieldController
};

// Inventory Controllers
use App\Http\Controllers\Inventory\{
    StockLevelController,
    StockInController,
    StockOutController,
    StockTransferController,
    StockAdjustmentController,
    StockAlertController,
    PurchaseRequestController as InventoryPurchaseRequestController,
    ProductController,
    CategoryController,
    UnitOfMeasureController,
    LocationController,
    BarcodeController,
    LogController,
    BomController
};

// Purchasing Controllers
use App\Http\Controllers\Purchasing\{
    PurchaseRequestController as PurchasingPurchaseRequestController,
    SupplierQuoteController,
    PurchaseOrderController
};





















// Auth
require __DIR__ . '/auth.php';

// Home / Dashboard
Route::get('/', [HomeController::class, 'index'])->middleware(['XSS']);
Route::get('home', [HomeController::class, 'index'])->name('home')->middleware(['XSS']);
Route::get('dashboard', [HomeController::class, 'index'])->name('dashboard')->middleware(['XSS']);

// OTP & 2FA
Route::get('login/otp', [OTPController::class, 'show'])->name('otp.show')->middleware(['XSS']);
Route::post('login/otp', [OTPController::class, 'check'])->name('otp.check')->middleware(['XSS']);
Route::get('login/2fa/disable', [OTPController::class, 'disable'])->name('2fa.disable')->middleware(['XSS']);

// Permission cache reset
Route::get('/clear-permission-cache', function () {
    app()[PermissionRegistrar::class]->forgetCachedPermissions();
    \Artisan::call('cache:clear');
    \Artisan::call('config:clear');
    return '✅ Permission cache cleared. Now refresh your page.';
});


// Visitors
Route::middleware(['auth', 'XSS'])->group(function () {
    Route::get('visitor/today', [VisitorController::class, 'todayVisitor'])->name('visitor.today');
    Route::get('visitor/pre-register', [VisitorController::class, 'visitorPreRegister'])->name('visitor.pre-register');
    Route::delete('visitor/pre-register/{id}', [VisitorController::class, 'visitorPreRegisterDestroy'])->name('visitor.pre-register.destroy');
    Route::get('visitor/{id}/pass-print', [VisitorController::class, 'visitorPassPrint'])->name('visitor.pass.print');
    Route::resource('visitor', VisitorController::class);
});
Route::get('pre-register/{code}', [VisitorController::class, 'preRegister'])->name('pre-register');
Route::post('pre-register/{id}/store', [VisitorController::class, 'preRegisterStore'])->name('pre-register.store');

// Auth email verify
Route::get('email-verification/{token}', [VerifyEmailController::class, 'verifyEmail'])->name('email-verification')->middleware(['XSS']);

// Routes with middleware
Route::middleware(['auth', 'XSS'])->group(function () {
    Route::resources([
        'users' => UserController::class,
        'subscriptions' => SubscriptionController::class,
        'permission' => PermissionController::class,
        'role' => RoleController::class,
        'note' => NoticeBoardController::class,
        'contact' => ContactController::class,
        'visit-category' => VisitCategoryController::class,
        'notification' => NotificationController::class,
        'template' => TemplateController::class,
        'FAQ' => FAQController::class,
        'homepage' => HomePageController::class,
        'pages' => PageController::class,
        'authPage' => AuthPageController::class,
    ]);

// Coupons
    Route::get('coupons/history', [CouponController::class, 'history'])->name('coupons.history');
    Route::delete('coupons/history/{id}/destroy', [CouponController::class, 'historyDestroy'])->name('coupons.history.destroy');
    Route::get('coupons/apply', [CouponController::class, 'apply'])->name('coupons.apply');
    Route::resource('coupons', CouponController::class);

// Subscription Payments
    Route::post('subscription/{id}/stripe/payment', [SubscriptionController::class, 'stripePayment'])->name('subscription.stripe.payment');
    Route::get('subscription/transaction', [SubscriptionController::class, 'transaction'])->name('subscription.transaction');
    Route::post('subscription/{id}/bank-transfer', [PaymentController::class, 'subscriptionBankTransfer'])->name('subscription.bank.transfer');
    Route::get('subscription/{id}/bank-transfer/action/{status}', [PaymentController::class, 'subscriptionBankTransferAction'])->name('subscription.bank.transfer.action');
    Route::post('subscription/{id}/paypal', [PaymentController::class, 'subscriptionPaypal'])->name('subscription.paypal');
    Route::get('subscription/{id}/paypal/{status}', [PaymentController::class, 'subscriptionPaypalStatus'])->name('subscription.paypal.status');
    Route::post('subscription/{id}/{user_id}/manual-assign-package', [PaymentController::class, 'subscriptionManualAssignPackage'])->name('subscription.manual_assign_package');
    Route::get('subscription/flutterwave/{sid}/{tx_ref}', [PaymentController::class, 'subscriptionFlutterwave'])->name('subscription.flutterwave');

// Settings
    Route::prefix('settings')->group(function () {
        Route::get('/', [SettingController::class, 'index'])->name('setting.index');
        Route::post('/account', [SettingController::class, 'accountData'])->name('setting.account');
        Route::delete('/account/delete', [SettingController::class, 'accountDelete'])->name('setting.account.delete');
        Route::post('/password', [SettingController::class, 'passwordData'])->name('setting.password');
        Route::post('/general', [SettingController::class, 'generalData'])->name('setting.general');
        Route::post('/smtp', [SettingController::class, 'smtpData'])->name('setting.smtp');
        Route::get('/smtp-test', [SettingController::class, 'smtpTest'])->name('setting.smtp.test');
        Route::post('/smtp-test', [SettingController::class, 'smtpTestMailSend'])->name('setting.smtp.testing');
        Route::post('/payment', [SettingController::class, 'paymentData'])->name('setting.payment');
        Route::post('/site-seo', [SettingController::class, 'siteSEOData'])->name('setting.site.seo');
        Route::post('/google-recaptcha', [SettingController::class, 'googleRecaptchaData'])->name('setting.google.recaptcha');
        Route::post('/company', [SettingController::class, 'companyData'])->name('setting.company');
        Route::post('/2fa', [SettingController::class, 'twofaEnable'])->name('setting.twofa.enable');
        Route::post('/footer', [SettingController::class, 'footerData'])->name('setting.footer');
    });

    Route::get('footer-setting', [SettingController::class, 'footerSetting'])->name('footerSetting');
    Route::get('language/{lang}', [SettingController::class, 'lanquageChange'])->name('language.change');
    Route::post('theme/settings', [SettingController::class, 'themeSettings'])->name('theme.settings');

// Logged History
    Route::prefix('logged')->group(function () {
        Route::get('history', [UserController::class, 'loggedHistory'])->name('logged.history');
        Route::get('{id}/history/show', [UserController::class, 'loggedHistoryShow'])->name('logged.history.show');
        Route::delete('{id}/history', [UserController::class, 'loggedHistoryDestroy'])->name('logged.history.destroy');
    });
    
    
//Sales    
Route::prefix('sales')->name('sales.')->group(function () {
    Route::get('dashboard', [\App\Http\Controllers\Sales\DashboardController::class, 'index'])->name('dashboard.index');
    
    // Quotes
Route::get('quotes', [QuoteController::class, 'index'])->name('quotes.index');
Route::get('quotes/create', [QuoteController::class, 'create'])->name('quotes.create');
Route::get('quotes/{id}/edit', [QuoteController::class, 'edit'])->name('quotes.edit');
Route::delete('quotes/{id}', [QuoteController::class, 'destroy'])->name('quotes.destroy');
Route::post('quotes/{id}/email', [QuoteController::class, 'email'])->name('quotes.email');
Route::post('quotes', [QuoteController::class, 'store'])->name('quotes.store');
Route::get('quotes/customer/{customer_number}', [QuoteController::class, 'getCustomer'])->name('quotes.getCustomer');
Route::get('quotes/{id}/details', [QuoteController::class, 'details'])->name('quotes.details');

Route::post('quotes/{id}/items', [QuoteController::class, 'storeItem'])->name('quotes.storeItem');
Route::get('quotes/items/{id}/edit', [QuoteController::class, 'editItem'])->name('quotes.items.edit');
Route::get('quotes/items/{id}', [QuoteController::class, 'showItem'])->name('quotes.items.show');

// ❗️This should be LAST to avoid hijacking the other routes
Route::get('quotes/{id}', [QuoteController::class, 'show']);



    // Orders
Route::get('orders', [\App\Http\Controllers\Sales\OrderController::class, 'index'])->name('orders.index');
Route::get('orders/create', [\App\Http\Controllers\Sales\OrderController::class, 'create'])->name('orders.create');
Route::get('orders/{id}/edit', [\App\Http\Controllers\Sales\OrderController::class, 'edit'])->name('orders.edit');
Route::delete('orders/{id}', [\App\Http\Controllers\Sales\OrderController::class, 'destroy'])->name('orders.destroy');
Route::post('orders/{id}/email', [\App\Http\Controllers\Sales\OrderController::class, 'email'])->name('orders.email');
Route::get('orders/{id}/print', [\App\Http\Controllers\Sales\OrderController::class, 'print'])->name('orders.print');
    Route::post('orders', [\App\Http\Controllers\Sales\OrderController::class, 'store'])->name('orders.store');
    
    // Invoices
    Route::get('invoices', [\App\Http\Controllers\Sales\InvoiceController::class, 'index'])->name('invoices.index');
    Route::get('/invoices/customer/{customer_number}', [InvoiceController::class, 'getCustomer'])->name('invoices.getCustomer');




    // Settings
    Route::get('settings', [\App\Http\Controllers\Sales\SettingController::class, 'index'])->name('settings.index');
});


//Supplier
Route::prefix('master/suppliers')->name('master.suppliers.')->group(function () {
    Route::get('/', [SupplierController::class, 'index'])->name('index');
    Route::post('/', [SupplierController::class, 'store'])->name('store');
    Route::get('{id}/edit', [SupplierController::class, 'edit'])->name('edit');
    Route::put('{id}', [SupplierController::class, 'update'])->name('update'); // ✅ THIS IS REQUIRED
});



//Crud Generator 
Route::get('/crud-generator', [CrudGeneratorController::class, 'index'])->name('crud.index');
Route::post('/crud-generator', [CrudGeneratorController::class, 'generate'])->name('crud.generate');

//Menus
Route::prefix('admin/menu')->name('menu.')->group(function () {
    Route::get('/', [MenuController::class, 'index'])->name('index');
    Route::get('/create', [MenuController::class, 'create'])->name('create');
    Route::post('/store', [MenuController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [MenuController::class, 'edit'])->name('edit');
    Route::put('/{id}/update', [MenuController::class, 'update'])->name('update');
    Route::delete('/{id}', [MenuController::class, 'destroy'])->name('destroy');

    // Add these two lines for reorder
    Route::get('/reorder', [MenuController::class, 'reorder'])->name('reorder');
    Route::post('/reorder/save', [MenuController::class, 'saveReorder'])->name('reorder.save');
});



// Library
Route::prefix('master/library/configurations')->name('master.library.configurations.')->group(function () {
    Route::get('/', [ConfigurationController::class, 'index'])->name('index');
    Route::get('/{series}', [ConfigurationController::class, 'show'])->name('show');
    Route::post('/{series}/add-category', [ConfigurationController::class, 'addCategory'])->name('addCategory');
    Route::post('/{series}/{category}/upload', [ConfigurationController::class, 'uploadImage'])->name('uploadImage');
    Route::delete('/{series}/{category}/{image}', [ConfigurationController::class, 'deleteImage'])->name('deleteImage');
});
Route::get('/library-image/{series}/{category}/{image}', function ($series, $category, $image) {
    $path = public_path("config-thumbs/$series/$category/$image");

    if (!file_exists($path)) {
        abort(404, 'Image not found at: ' . $path);
    }

    return response()->file($path);
})->where('image', '.*');


Route::prefix('products')->name('products.')->group(function () {
    Route::get('product-classes', [ProductClassesController::class, 'index'])->name('product_classes.index');
    Route::get('basic-products', [BasicProductsController::class, 'index'])->name('basic_products.index');
    Route::get('grille-patterns', [GrillePatternsController::class, 'index'])->name('grille_patterns.index');
    Route::get('profile-records', [ProfileRecordsController::class, 'index'])->name('profile_records.index');
    Route::get('corner-exchange', [CornerExchangeController::class, 'index'])->name('corner_exchange.index');
    Route::get('profile-types', [ProfileTypesController::class, 'index'])->name('profile_types.index');
    Route::get('sealing-assignment', [SealingAssignmentController::class, 'index'])->name('sealing_assignment.index');
    Route::get('reinforcement-assignments', [ReinforcementAssignmentsController::class, 'index'])->name('reinforcement_assignments.index');
    Route::get('hardware-types', [HardwareTypesController::class, 'index'])->name('hardware_types.index');
    Route::get('system-color', [SystemColorController::class, 'index'])->name('system_color.index');
});


    
Route::prefix('products/product-master')->name('product_master.')->group(function () {
    Route::get('accessories', [AccessoriesController::class, 'index'])->name('accessories.index');
    Route::get('glassinsert', [GlassInsertController::class, 'index'])->name('glassinsert.index');
    Route::get('hardwarevariant', [HardwareVariantController::class, 'index'])->name('hardwarevariant.index');
    Route::get('hardwareparts', [HardwarePartsController::class, 'index'])->name('hardwareparts.index');
    Route::get('materials', [MaterialsController::class, 'index'])->name('materials.index');
    Route::get('profiles', [ProfilesController::class, 'index'])->name('profiles.index');
    Route::get('units', [UnitsController::class, 'index'])->name('units.index');
});    
    
    
    
Route::prefix('master/prices')->name('master.prices.')->group(function () {
    Route::get('matrice', [MatriceController::class, 'index'])->name('matrice.index');
    Route::post('matrice/import', [MatriceController::class, 'import'])->name('matrice.import');
    Route::post('matrice/check', [MatriceController::class, 'checkPrice'])->name('matrice.check'); 
});

    


Route::prefix('master/product_keys')->name('product_keys.')->group(function () {
    Route::resource('producttypes', ProductTypeController::class);
    Route::resource('productareas', ProductAreaController::class);
    Route::resource('productsystems', ProductSystemController::class);
    Route::resource('manufacturersystems', ManufacturerSystemController::class);
    Route::resource('specialshapemacros', SpecialShapeMacroController::class);
    Route::resource('shapecatalog', ShapeCatalogController::class);
    Route::resource('drawingobjects', DrawingObjectController::class);
});
    
    
Route::prefix('color-options')->name('color-options.')->group(function () {
    Route::resource('color-configurations', ColorConfigurationController::class);
    Route::resource('exterior-colors', ExteriorColorController::class);
    Route::resource('interior-colors', InteriorColorController::class);
    Route::resource('laminate-colors', LaminateColorController::class);
});
    
Route::prefix('grid-options')->name('grid-options.')->group(function () {
 Route::resource('grid-types', GridTypeController::class);
    Route::resource('grid-patterns', GridPatternController::class);
    Route::resource('grid-profiles', GridProfileController::class);   
});  
    
Route::prefix('glass-options')->name('glass-options.')->group(function () {
    Route::resource('glass-types', GlassTypeController::class);
    Route::resource('spacers', SpacerController::class);
    Route::resource('tempered-options', TemperedOptionController::class);
    Route::resource('special-glasses', SpecialGlassController::class);
});     

Route::prefix('frame-options')->name('frame-options.')->group(function () {
Route::resource('frame-types', FrameTypeController::class);
    Route::resource('retrofit-fin-types', RetrofitFinTypeController::class);
}); 

Route::prefix('other-options')->name('other-options.')->group(function () {
    Route::resource('additional-options', AdditionalOptionController::class);
}); 
    
    // Series routes
Route::prefix('master')->name('master.')->group(function () {
    Route::resource('series', SeriesController::class);
    Route::resource('series-type', SeriesTypeController::class);
});
    
//Prices  
Route::prefix('master/prices')->name('prices.')->group(function () {
    Route::get('productprices', [ProductPricesController::class, 'index'])->name('productprices.index');
});
Route::get('/series/{id}/types', [QuoteController::class, 'getSeriesTypes']);
Route::get('/sales/series-types/{seriesId}', [QuoteController::class, 'getSeriesTypes']);

Route::get('/sales/quotes/previous', [QuoteController::class, 'previous'])->name('sales.quotes.previous');
Route::get('sales/settings', [SalesSettingsController::class, 'index'])->name('sales.settings.index');
Route::post('sales/settings/update', [SalesSettingsController::class, 'update'])->name('sales.settings.update');
Route::post('/sales/settings/save', [SalesSettingsController::class, 'save'])->name('sales.settings.save');

//Invoices
Route::prefix('sales')->name('sales.')->group(function () {
    Route::resource('invoices', \App\Http\Controllers\Sales\InvoiceController::class);
});



Route::get('/master/prices/matrice/types/{seriesId}', [\App\Http\Controllers\Master\Prices\MatriceController::class, 'getTypes']);
Route::post('/master/prices/matrice/import', [MatriceController::class, 'import'])->name('master.prices.matrice.import');
Route::post('/master/prices/matrice/check', [MatriceController::class, 'checkPrice'])->name('master.prices.matrice.check');

Route::prefix('master/prices/markup')->name('master.prices.markup.')->group(function () {
    Route::get('/', [MarkupController::class, 'index'])->name('index');
    Route::post('/', [MarkupController::class, 'store'])->name('store');
    Route::put('/{id}', [MarkupController::class, 'update'])->name('update');
    Route::post('/{id}/lock', [MarkupController::class, 'lock'])->name('lock');
});


// Orders
Route::resource('orders', OrderController::class)->except(['index']);
Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
Route::get('orders/import', [OrderController::class, 'import'])->name('orders.import');
Route::post('/orders/import', [OrderController::class, 'handleImports'])->name('orders.import');
//CIMs
Route::resource('cims', CimController::class)->except(['index']);
Route::get('cims/import', [CimController::class, 'import'])->name('cims.import');
Route::post('/cims/import', [CimController::class, 'handleImports'])->name('cims.import');
Route::get('/cims', [CimController::class, 'index'])->name('cims.index');


// Carts
Route::resource('cart', CartController::class)->except(['show', 'destroy']);
Route::put('/cart/{id}', [CartController::class, 'update'])->name('cart.update');
Route::put('cart/{cart_barcode}', [CartController::class, 'update'])->name('cart.update');
Route::get('deliveries/refresh-carts', [SrDeliveryController::class, 'refreshCartsForAll'])->name('sr.deliveries.refreshCarts');
Route::get('/carts/create', [App\Http\Controllers\CartController::class, 'create'])->name('cart.create');

//Calendar
Route::get('/calendar/deliveries/{date}', [\App\Http\Controllers\CalendarController::class, 'deliveriesByDate'])->name('calendar.deliveries.byDate');
Route::post('/calendar/store', [\App\Http\Controllers\SrDeliveryController::class, 'store'])->name('calendar.store');
Route::get('/calendars/create', [\App\Http\Controllers\CalendarController::class, 'create'])->name('calendar.create');
Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar.index');
Route::get('/calendar/order-details/{order_number}', [\App\Http\Controllers\CalendarController::class, 'getOrderDetails']);
Route::post('/calendar/update-date', [CalendarController::class, 'updateDate'])->name('calendar.updateDate');



//Template
Route::resource('template', TemplateController::class);
Route::get('/send-template/{id}/{template_id}', [ActionController::class, 'sendTemplate'])->name('action.sendTemplate');

//RingCentral
Route::get('/ringcentral/connect', [RingCentralController::class, 'connect'])->name('ringcentral.connect');
Route::get('/ringcentral/callback', [RingCentralController::class, 'callback'])->name('ringcentral.callback');
Route::get('/rc/connect', [RingCentralController::class, 'connect'])->name('rc.connect');
Route::get('/rc/callback', [RingCentralController::class, 'callback'])->name('rc.callback');
Route::post('/delivery/{id}/call', [RingCentralController::class, 'callDeliveryContact'])->name('ringcentral.call');
Route::get('/ringcentral/call/{id}', [RingCentralController::class, 'call'])->name('ringcentral.call');


//Addons
Route::prefix('master/sales/addons')->name('master.sales.addons.')->group(function () {
    Route::get('/', [AddonController::class, 'index'])->name('index');
    Route::post('/', [AddonController::class, 'store'])->name('store');
    Route::delete('/{id}', [AddonController::class, 'destroy'])->name('destroy');
});



Route::prefix('schemas')->group(function () {
    Route::resource('hs-unit', HSUnitController::class);
    Route::resource('sh-unit', SHUnitController::class);
    Route::resource('dh-unit', DHUnitController::class);
    Route::resource('xx-unit', XXUnitController::class);
    Route::resource('cm-unit', CMUnitController::class);
    Route::resource('pw-unit', PWUnitController::class);
    Route::resource('sld-unit', SLDUnitController::class);
    Route::resource('swd-unit', SWDUnitController::class);

    Route::resource('gsco-hsunit', GSCOHSUnitController::class);
    Route::resource('gsco-shunit', GSCOSHUnitController::class);
    Route::resource('gsco-dhunit', GSCODHUnitController::class);
    Route::resource('gsco-pwunit', GSCOPWUnitController::class);
    Route::resource('gsco-xxunit', GSCOXXUnitController::class);
    Route::resource('gsco-cmunit', GSCOCMUnitController::class);
    Route::resource('gsco-sldunit', GSCOSLDUnitController::class);
    Route::resource('gsco-swdunit', GSCOSWDUnitController::class);

    Route::resource('cmpromo', CMPromoController::class);
    Route::resource('window-door-field', WindowDoorFieldController::class);
});




// Inventory
Route::prefix('inventory')->name('inventory.')->group(function () {

    // Inventory Operations
    Route::resource('stock-level', StockLevelController::class)->except(['show']);
    Route::resource('stock-in', StockInController::class)->except(['show']);
    Route::resource('stock-out', StockOutController::class)->except(['show']);
    Route::resource('stock-transfer', StockTransferController::class)->except(['show']);
    Route::resource('stock-adjustments', StockAdjustmentController::class)->except(['show']);
    Route::resource('stock-alerts', StockAlertController::class)->except(['show']);
    Route::get('stock-alerts/{id}/create-request', [StockAlertController::class, 'createPurchaseRequest'])
    ->name('stock-alerts.create_request');

Route::get('stock-alerts/batch-create-requests', [StockAlertController::class, 'createGroupedPurchaseRequests'])
    ->name('stock-alerts.batch_requests');



    // Purchase Requests (Inventory context)
    Route::resource('purchase-requests', InventoryPurchaseRequestController::class)->except(['show']);

    // Product Master
    Route::resource('products', ProductController::class)->except(['show']);
    Route::resource('categories', CategoryController::class)->except(['show']);
    Route::resource('uoms', UnitOfMeasureController::class)->except(['show']);
    Route::resource('locations', LocationController::class)->except(['show']);
    Route::resource('barcodes', BarcodeController::class);
    Route::resource('logs', LogController::class)->only(['index']);

    // BOM
    Route::get('/bom', [BomController::class, 'index'])->name('bom.index');
    Route::get('/bom/create', [BomController::class, 'create'])->name('bom.create');
    Route::post('/bom', [BomController::class, 'store'])->name('bom.store');
    Route::get('/bom/{bom}/edit', [BomController::class, 'edit'])->name('bom.edit');
    Route::put('/bom/{bom}', [BomController::class, 'update'])->name('bom.update');
    Route::delete('/bom/{bom}', [BomController::class, 'destroy'])->name('bom.destroy');
    Route::post('/bom/import', [BomController::class, 'handleImports'])->name('bom.import');
});



// Purchasing
Route::prefix('purchasing')->name('purchasing.')->group(function () {
    Route::resource('purchase-requests', PurchasingPurchaseRequestController::class);
    Route::resource('supplier-quotes', SupplierQuoteController::class);
    Route::resource('purchase-orders', PurchaseOrderController::class);
    Route::resource('receiving', ReceivingController::class); // ← new
    Route::resource('invoices', PurchaseInvoiceController::class); 
    Route::get('purchase-requests/{id}/download', [PurchasingPurchaseRequestController::class, 'download'])
        ->name('purchase-requests.download');

});




    Route::get('/settings/shipping', [ShippingSettingsController::class, 'index'])->name('settings.shipping');
    Route::post('/settings/shipping/truncate', [ShippingSettingsController::class, 'truncateShippingData'])->name('settings.shipping.truncate');




// Trucks, Drivers, Routes
Route::resource('trucks', TruckController::class);
Route::resource('drivers', DriverController::class);



// Deliveries & Pickups
Route::resource('deliveries', DeliveryController::class);
Route::get('deliveries/fix-statuses', [SrDeliveryController::class, 'fixEmptyStatuses'])->name('sr.deliveries.fixStatuses');
Route::get('deliveries/{delivery}/edit', [DeliveryController::class, 'edit'])->name('deliveries.edit');
Route::get('/today', [DeliveryController::class, 'today'])->name('deliveries.today');
Route::get('/upcoming', [DeliveryController::class, 'upcoming'])->name('deliveries.upcoming');

//Shops
Route::resource('shops', ShopController::class)->except(['show']);
Route::get('shops/import', [ShopController::class, 'importForm'])->name('shops.import');
Route::post('shops/import', [ShopController::class, 'import']);
Route::get('/shops/fetch/{customer}', [ShopController::class, 'fetchShop']);
Route::post('/calendar/get-shop-details', [App\Http\Controllers\CalendarController::class, 'getShopByCustomer'])->name('calendar.getShop');
Route::post('/calendar/get-shop-details', [CalendarController::class, 'getShopByCustomer'])->name('calendar.getShop');
Route::post('/calendar/get-shop', [\App\Http\Controllers\ShopController::class, 'fetchShop'])->name('calendar.getShop');
Route::post('/calendar/get-shop', [CalendarController::class, 'getShopByCustomer'])->name('calendar.getShop');
Route::post('/shop/contact', [SrDeliveryController::class, 'getShopByCustomer'])->name('shop.contact');



Route::get('/pickups', [PickupController::class, 'index'])->name('pickups.index');
Route::get('pickups/{pickup}/edit', [PickupController::class, 'edit'])->name('pickups.edit');
Route::put('pickups/{pickup}', [PickupController::class, 'update'])->name('pickups.update');
Route::delete('/pickup/{pickup}', [PickupController::class, 'destroy'])->name('pickup.destroy');
Route::resource('pickup', \App\Http\Controllers\PickupController::class);
    Route::patch('/pickups/{pickup}', [PickupController::class, 'update'])->name('pickups.update');


Route::get('/leads/my-kanban', [LeadController::class, 'mykanban'])
    ->name('leads.mykanban')
    ->middleware('can:view my kanban');
Route::post('/leads/reassign-unassigned', [LeadController::class, 'reassignUnassigned'])
    ->name('leads.reassignUnassigned')
    ->middleware('can:manage leads'); // Or any appropriate permission

Route::get('/leads/kanban', [LeadController::class, 'kanban'])->name('leads.kanban');
Route::post('/leads/kanban/update-status', [LeadController::class, 'updateStatus'])->name('leads.kanban.update-status');






//Leads & Kanban  
Route::resource('leads', LeadController::class);
Route::get('leads/import', [LeadController::class, 'import'])->name('leads.import');
Route::post('/leads/import', [LeadController::class, 'handleImports'])->name('leads.import');
Route::post('/leads/call-status', [LeadController::class, 'updateCallStatus'])->name('leads.call-status');
Route::post('/leads/update-status', [LeadController::class, 'updateStatus'])->name('leads.updateStatus');
Route::put('/leads/{lead}', [LeadController::class, 'update'])->name('leads.update');



Route::get('/inventory/form-options', [FormOptionController::class, 'index'])->name('form-options.index');
Route::post('/inventory/form-options/group', [FormOptionController::class, 'storeGroup'])->name('form-options.groups.store');
Route::post('/inventory/form-options/option', [FormOptionController::class, 'storeOption'])->name('form-options.options.store');
Route::get('/inventory/configurator', [App\Http\Controllers\ProductConfiguratorController::class, 'index'])->name('inventory.configurator.index');




Route::prefix('inventory/form-options')->name('form-options.')->group(function () {
    Route::put('groups/{group}', [FormOptionGroupController::class, 'update'])->name('groups.update');
});
Route::get('/form-options/create', [\App\Http\Controllers\FormOptionController::class, 'create'])->name('form-options.create');
Route::post('/form-options', [\App\Http\Controllers\FormOptionController::class, 'store'])->name('form-options.store');
Route::post('/form-options/store-option', [FormOptionController::class, 'storeOption'])->name('form-options.options.store');

Route::get('/form-options/{option}/edit', [FormOptionController::class, 'edit'])->name('form-options.edit');
Route::delete('/form-options/{option}', [FormOptionController::class, 'destroy'])->name('form-options.destroy');
Route::put('/form-options/options/{id}', [FormOptionController::class, 'updateOption'])->name('form-options.options.update');


Route::prefix('inventory/form-options/groups')->name('form-options.groups.')->group(function () {
    Route::get('/', [FormOptionGroupController::class, 'index'])->name('index');
    Route::get('/{id}/edit', [FormOptionGroupController::class, 'edit'])->name('edit');
    Route::put('/{id}', [FormOptionGroupController::class, 'update'])->name('update');
});


// web.php
Route::get('/window/render/{series}/{code}', [WindowRenderController::class, 'render']);



//BOMMENU
Route::prefix('bill-of-material/menu')->group(function () {
    Route::resource('frametype', FrameTypeController::class);
    Route::resource('gridtype', GridTypeController::class);
    Route::resource('glasstype', GlassTypeController::class);
    Route::resource('lockcover', LockCoverController::class);
    Route::resource('waterflow', WaterFlowController::class);
    Route::resource('mullcap', MullCapController::class);
    Route::resource('mesh', MeshController::class);
    Route::resource('mullstack', MullStackController::class);
    Route::resource('stop', StopController::class);
    Route::resource('rollertrack', RollerTrackController::class);
    Route::resource('doubletape', DoubleTapeController::class);
    Route::resource('snapping', SnappingController::class);
    Route::resource('gridpattern', GridPatternController::class);
    Route::resource('locktype', LockTypeController::class);
    Route::resource('spacer', SpacerController::class);
    Route::resource('screen', ScreenController::class);
    Route::resource('strikescrew', StrikeScrewController::class);
    Route::resource('strike', StrikeController::class);
    Route::resource('lockscrew', LockScrewController::class);
    Route::resource('tensionspring', TensionSpringController::class);
    Route::resource('pullers', PullersController::class);
Route::resource('corners', CornersController::class);
Route::resource('spline', SplineController::class);
Route::resource('warninglabel', WarningLabelController::class);
Route::resource('aluminumreinforcement', AluminumReinforcementController::class);
Route::resource('steelreinforcement', SteelReinforcementController::class);
Route::resource('reinforcementmaterial', ReinforcementMaterialController::class);
Route::resource('mullscrew', MullScrewController::class);
Route::resource('interlockreinforcement', InterlockReinforcementController::class);
Route::resource('rollers', RollersController::class);
Route::resource('interlock', InterlockController::class);
Route::resource('sash', SashController::class);
Route::resource('elitelabel', EliteLabelController::class);
Route::resource('settingblock', SettingBlockController::class);
Route::resource('nightlock', NightLockController::class);
Route::resource('antitheft', AntiTheftController::class);
Route::resource('ammalabel', AmmaLabelController::class);
Route::resource('mullreinforcement', MullReinforcementController::class);
    Route::resource('sashreinforcement', SashReinforcementController::class);
});

Route::prefix('bill-of-material/calculator')->group(function () {
    Route::resource('calculator', CalculatorController::class);
});

Route::prefix('bill-of-material/prices')->group(function () {
    Route::resource('prices', PriceController::class);
    Route::post('/prices/import', [PriceController::class, 'handleImports'])->name('price.import');
    
});


//Configurator
Route::get('inventory/configurator', [ConfiguratorController::class, 'index'])->name('inventory.configurator.index');
Route::post('inventory/configurator', [ConfiguratorController::class, 'store'])->name('inventory.configurator.store');
Route::get('inventory/configurator/{slug}', [ConfiguratorController::class, 'show'])->name('inventory.configurator.show');


//Executive
Route::prefix('executives')->name('executives.')->group(function () {
    Route::resource('tiers', \App\Http\Controllers\ExecutiveTierController::class);

    Route::get('/customers', [ExecutiveCustomerController::class, 'index'])->name('customers.index');
    Route::get('tiers', [ExecutiveTierController::class, 'index'])->name('tiers.index');
    Route::post('tiers', [ExecutiveTierController::class, 'store'])->name('tiers.store');
    Route::put('tiers/{id}', [ExecutiveTierController::class, 'update'])->name('tiers.update');

    Route::get('formulas', [FormulaController::class, 'index'])->name('formulas.index');
    Route::post('formulas', [FormulaController::class, 'update'])->name('formulas.update');
    Route::get('raffle-draw', [RaffleDrawController::class, 'index'])->name('raffle.index');
Route::post('raffle-draw/start', [RaffleDrawController::class, 'start'])->name('raffle.start');
Route::post('raffle-draw/reset', [RaffleDrawController::class, 'reset'])->name('raffle.reset');

    Route::get('/customers/{id}/edit', [ExecutiveCustomerController::class, 'edit'])->name('customers.edit');
    Route::post('/customers', [ExecutiveCustomerController::class, 'store'])->name('customers.store');
    Route::put('/customers/{id}', [ExecutiveCustomerController::class, 'update'])->name('customers.update');
    Route::delete('/customers/{id}', [ExecutiveCustomerController::class, 'destroy'])->name('customers.destroy');
    Route::post('/customers/import', [ExecutiveCustomerController::class, 'import'])->name('customers.import');
    Route::post('/executives/customers', [ExecutiveCustomerController::class, 'store'])->name('executives.customers.store');

});


Route::prefix('master')->name('master.')->group(function () {

    Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('/customers/{id}/edit', [CustomerController::class, 'edit'])->name('customers.edit');
    Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');
    Route::put('/customers/{id}', [CustomerController::class, 'update'])->name('customers.update');
    Route::delete('/customers/{id}', [CustomerController::class, 'destroy'])->name('customers.destroy');
    Route::post('/customers/import', [CustomerController::class, 'import'])->name('customers.import');

    // 🔍 Add this for lookup by customer_number
    Route::get('/customers/lookup/{customer_number}', [CustomerController::class, 'showByNumber'])->name('customers.lookup');
});


Route::prefix('sales')->name('sales.')->group(function () {
    Route::get('quotes/create', [QuoteController::class, 'create'])->name('quotes.create');
    Route::post('quotes', [QuoteController::class, 'store'])->name('quotes.store');
    Route::get('quotes/{id}', [QuoteController::class, 'details'])->name('quotes.details');
    Route::post('/quotes/check-price', [QuoteController::class, 'checkPrice'])->name('quotes.checkPrice');


    Route::get('customers/{customer_number}', [QuoteController::class, 'getCustomer'])->name('customers.get');
});


//Route Maps         
Route::get('/routes', [RouteController::class, 'index'])->name('routes.index');
Route::get('/route/map', [RouteController::class, 'index'])->name('route.map');

Route::post('/route/status/update', [\App\Http\Controllers\RouteController::class, 'updateStopStatus'])->name('route.updateStatus');
Route::get('/routes/auto', [RouteController::class, 'autoRouteView'])->name('routes.auto');

Route::get('/routes/generate', [RouteController::class, 'generate'])->name('routes.generate');
Route::post('/routes/optimize', [RouteController::class, 'optimize'])->name('routes.optimize');
;  
Route::post('/routes/reset', [RouteController::class, 'resetAssignments'])->name('routes.reset');
Route::post('/sr/routes/reorder', [RouteController::class, 'reorderStops'])->name('routes.reorder');
Route::post('/routes/reorder-stops', [RouteController::class, 'reorderStops'])->name('routes.reorder');
Route::get('/routes/driver', [RouteController::class, 'driverRoutes'])
    ->name('routes.driver')
    ->middleware('can:manage my route');
Route::post('/routes/plan/create', [PlanRouteController::class, 'createDateSection'])->name('routes.plan.create');
Route::post('/routes/plan/optimize', [RouteController::class, 'planOptimize'])->name('routes.plan.optimize');
Route::get('/routes/pdf/{truck}/{date}', [RouteController::class, 'generatePdf'])
    ->name('routes.pdf');
Route::get('/routes/plan', [PlanRouteController::class, 'planRouteView'])->name('routes.plan');
Route::post('/routes/plan/optimize', [PlanRouteController::class, 'planOptimize'])->name('routes.plan.optimize');
Route::get('/routes/plan/map/{date}', [PlanRouteController::class, 'planMapView'])->name('routes.plan.map');
Route::post('/routes/plan/reset/{date}', [PlanRouteController::class, 'resetDate'])->name('routes.plan.reset'); // Optional: define this if needed
Route::post('/routes/plan/generate/{date}', [PlanRouteController::class, 'generateDate'])->name('routes.plan.generate'); // Optional
Route::post('/routes/plan/move-to-auto/{date}', [PlanRouteController::class, 'moveToAuto'])->name('routes.plan.moveToAuto'); // Optional


//Invoice Check    
Route::get('/invoice-checker', [\App\Http\Controllers\InvoiceCheckerController::class, 'index'])->name('invoice.checker.index');
    
    


// Static and specific routes FIRST
Route::get('/sr/deliveries/all', [SrDeliveryController::class, 'all'])->name('sr.deliveries.all');
Route::get('/sr/deliveries/today', [SrDeliveryController::class, 'today'])->name('sr.deliveries.today');
Route::get('/sr/deliveries/upcoming', [SrDeliveryController::class, 'upcoming'])->name('sr.deliveries.upcoming');
Route::get('/sr/deliveries/refresh', [SrDeliveryController::class, 'refresh'])->name('sr.deliveries.refresh');
Route::get('/sr/deliveries/refresh-unit-check', [SrDeliveryController::class, 'refreshUnitCheck'])->name('sr.deliveries.refreshUnitCheck');
Route::get('/sr/deliveries/missing-barcodes/{orderNumber}', [SrDeliveryController::class, 'missingBarcodes'])->name('sr.deliveries.missingBarcodes');
Route::get('/recheck', [SrDeliveryController::class, 'recheckFromOrders'])->name('sr.deliveries.recheck');

// Legacy or misrouted fallback routes (optional to keep)
Route::get('sr/deliveries/refresh-unit-check', [SrDeliveryController::class, 'refreshUnitCheck'])->name('sr.deliveries.refreshUnitCheck');
Route::get('deliveries/{delivery}/missing-barcodes', [SrDeliveryController::class, 'missingBarcodes'])->name('sr.deliveries.missing_barcodes');

// Edit/Update routes using consistent structure
Route::get('/sr/deliveries/{delivery}/edit', [SrDeliveryController::class, 'edit'])->name('sr.deliveries.edit');
Route::put('/sr/deliveries/{delivery}', [SrDeliveryController::class, 'update'])->name('sr.deliveries.update');
Route::delete('/sr/deliveries/{delivery}', [SrDeliveryController::class, 'destroy'])->name('sr.deliveries.destroy');

// Toggle actions
Route::post('/sr/deliveries/{id}/toggle', [SrDeliveryController::class, 'toggle'])->name('sr.deliveries.toggle');
Route::post('/sr/deliveries/{id}/toggle-button', [SrDeliveryController::class, 'toggleFieldButton'])->name('sr.deliveries.toggleFieldButton');
Route::post('/sr/deliveries/{id}/toggle', [SrDeliveryController::class, 'toggleField']); // Consider removing duplicate

// SHOW route LAST to avoid overriding `/all`, `/today`, etc.
Route::get('/sr/deliveries/{delivery}', [SrDeliveryController::class, 'show'])->name('sr.deliveries.show');


// POST: submit bulk creation
Route::post('/calendar/bulk-create', [CalendarController::class, 'bulkCreate'])->name('calendar.bulkCreate');
Route::get('/calendar/bulk-create-form', [CalendarController::class, 'bulkCreateForm'])->name('calendar.bulkCreateForm');


   





Route::get('/clear-cache', function () {
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    Artisan::call('optimize:clear');
    return 'Cache cleared!';
});



//Toggle
Route::post('/sr/deliveries/toggle/{id}', [SrDeliveryController::class, 'toggle'])->name('sr.deliveries.toggle');
Route::post('/sr/deliveries/{id}/toggle-field', [SrDeliveryController::class, 'toggleField'])->name('sr.deliveries.toggleField');
Route::post('/sr/deliveries/toggle/{id}', [SrDeliveryController::class, 'toggleFieldButton'])->name('sr.deliveries.toggleFieldButton');
Route::post('/sr/deliveries/{id}/toggle-delivery', [SrDeliveryController::class, 'toggleDelivery'])->name('sr.deliveries.toggleDelivery');



Route::get('/shops/fetch-customer-name/{customer}', [ShopController::class, 'fetchCustomerName'])->name('shops.fetchCustomerName');


//Route::get('/sr/deliveries/{id}', [SrDeliveryController::class, 'show'])->name('sr.deliveries.show');


Route::post('/calendar/fetch-by-order', [CalendarController::class, 'fetchByOrder'])->name('calendar.fetchByOrder');



// Public Page Slug
Route::get('page/{slug}', [PageController::class, 'page'])->name('page');

// Composer Autoload Fix
Route::get('/fix-autoload', function () {
    exec('composer dump-autoload');
    return 'Autoload dumped successfully.';
});

// Impersonate
Route::impersonate();
});
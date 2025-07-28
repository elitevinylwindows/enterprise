    
   //SR Deliveries All Deliveries
   Route::get('/sr/deliveries/all', [SrDeliveryController::class, 'all'])->name('sr.deliveries.all');
    Route::get('/deliveries/{id}/edit', [SrDeliveryController::class, 'edit'])->name('sr.deliveries.edit');
Route::get('/sr/deliveries/{delivery}', [SrDeliveryController::class, 'show'])->name('sr.deliveries.show');
Route::get('/sr/deliveries/{delivery}/edit', [SrDeliveryController::class, 'edit'])->name('sr.deliveries.edit');
Route::get('/sr/deliveries/missing-barcodes/{orderNumber}', [\App\Http\Controllers\SrDeliveryController::class, 'missingBarcodes'])
    ->name('sr.deliveries.missingBarcodes');
Route::get('/sr/deliveries/today', [SrDeliveryController::class, 'today'])->name('sr.deliveries.today');
Route::get('/sr/deliveries/upcoming', [SrDeliveryController::class, 'upcoming'])->name('sr.deliveries.upcoming');
Route::get('/sr/deliveries/edit/{id}', [SrDeliveryController::class, 'edit'])->name('sr.deliveries.edit');
Route::put('/sr/deliveries/update/{id}', [SrDeliveryController::class, 'update'])->name('sr.deliveries.update');
Route::get('/sr/deliveries/refresh', [SrDeliveryController::class, 'refresh'])->name('sr.deliveries.refresh');
Route::get('/sr/deliveries/refresh-unit-check', [SrDeliveryController::class, 'refreshUnitCheck'])->name('sr.deliveries.refreshUnitCheck');
Route::get('/sr/deliveries/missing-barcodes/{orderNumber}', [SrDeliveryController::class, 'missingBarcodes'])->name('sr.deliveries.missingBarcodes');
Route::get('sr/deliveries/refresh', [SrDeliveryController::class, 'refresh'])->name('sr.deliveries.refresh');
    Route::get('deliveries/refresh-unit-check', [SrDeliveryController::class, 'refreshUnitCheck'])->name('sr.deliveries.refreshUnitCheck');
    Route::get('/recheck', [SrDeliveryController::class, 'recheckFromOrders'])->name('sr.deliveries.recheck');
Route::get('deliveries/{delivery}/missing-barcodes', [SrDeliveryController::class, 'missingBarcodes'])->name('sr.deliveries.missing_barcodes');
});
Route::delete('/sr/deliveries/{delivery}', [SrDeliveryController::class, 'destroy'])->name('sr.deliveries.destroy');

 // SR Agent Routes
    Route::prefix('sr')->group(function () {
        Route::get('/all', [SrDeliveryController::class, 'all'])->name('sr.deliveries.all');
        Route::get('sr/deliveries/all', [SrDeliveryController::class, 'all'])->name('sr.deliveries.all');
Route::get('/today', [SrDeliveryController::class, 'today'])->name('sr.deliveries.today');

        Route::get('/upcoming', [SrDeliveryController::class, 'upcoming'])->name('sr.deliveries.upcoming');
    });
Route::put('/sr/deliveries/{delivery}', [SrDeliveryController::class, 'update'])->name('sr.deliveries.update');
Route::delete('/sr/deliveries/{delivery}', [SrDeliveryController::class, 'destroy'])->name('sr.deliveries.destroy');
Route::post('/sr/deliveries/{id}/toggle', [SrDeliveryController::class, 'toggleField']);
Route::post('/sr/deliveries/{id}/toggle', [SrDeliveryController::class, 'toggle'])->name('sr.deliveries.toggle');
Route::post('/sr/deliveries/{id}/toggle-button', [SrDeliveryController::class, 'toggleFieldButton'])->name('sr.deliveries.toggleFieldButton');
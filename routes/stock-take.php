Route::middleware(['auth'])->group(function () {
    Route::get('/stock-take', [App\Http\Controllers\StockTakeController::class, 'index'])->name('stock-take.index');
    Route::get('/stock-take/create', [App\Http\Controllers\StockTakeController::class, 'create'])->name('stock-take.create');
    Route::post('/stock-take', [App\Http\Controllers\StockTakeController::class, 'store'])->name('stock-take.store');
    Route::get('/stock-take/{stockTake}/count', [App\Http\Controllers\StockTakeController::class, 'count'])->name('stock-take.count');
    Route::post('/stock-take/{stockTake}/update-count', [App\Http\Controllers\StockTakeController::class, 'updateCount'])->name('stock-take.update-count');
    Route::post('/stock-take/{stockTake}/complete', [App\Http\Controllers\StockTakeController::class, 'complete'])->name('stock-take.complete');
    Route::get('/stock-take/{stockTake}', [App\Http\Controllers\StockTakeController::class, 'show'])->name('stock-take.show');
});
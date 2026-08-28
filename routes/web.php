<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Master\CategoryController;
use App\Http\Controllers\Master\SupplierController;
use App\Http\Controllers\Master\LocationController;
use App\Http\Controllers\Master\FundingSourceController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProcurementController;
use App\Http\Controllers\ItemExitController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\BackupController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::get('items/{item}/print-label', [ItemController::class, 'printLabel'])->name('items.print-label');
    Route::resource('items', ItemController::class);
    Route::resource('procurements', ProcurementController::class)->only(['index', 'create', 'store', 'show']);
    Route::resource('item_exits', ItemExitController::class)->only(['index', 'create', 'store']);
    
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/export/pdf', [ReportController::class, 'exportPdf'])->name('reports.export.pdf');
    Route::get('/reports/export/excel', [ReportController::class, 'exportExcel'])->name('reports.export.excel');
});

// Admin Only Routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('categories', CategoryController::class);
    Route::resource('suppliers', SupplierController::class);
    Route::resource('locations', LocationController::class);
    Route::resource('funding_sources', FundingSourceController::class);
    
    Route::get('/backup', [BackupController::class, 'index'])->name('backup.index');
    Route::get('/backup/download', [BackupController::class, 'download'])->name('backup.download');
});

require __DIR__.'/auth.php';

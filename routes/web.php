<?php
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\DocumentController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('rooms', RoomController::class)
     ->only(['index', 'show', 'create', 'store', 'edit', 'update', 'destroy']);

Route::resource('tenants', TenantController::class)
         ->only(['index', 'create', 'store', 'show', 'destroy']);

Route::get ('tenants/{tenant}/checkout',       [TenantController::class, 'editCheckout'])->name('tenants.checkout');
Route::post('tenants/{tenant}/checkout',       [TenantController::class, 'checkout'])->name('tenants.checkout.store');
// Document upload routes
Route::get ('tenants/{tenant}/document/upload',  [DocumentController::class, 'create'])->name('documents.create');
Route::post('tenants/{tenant}/document',         [DocumentController::class, 'store'])->name('documents.store');
Route::get ('tenants/{tenant}/document/view',    [DocumentController::class, 'show'])->name('documents.show');
Route::delete('tenants/{tenant}/document',       [DocumentController::class, 'destroy'])->name('documents.destroy');
// Photo routes
Route::get   ('tenants/{tenant}/photo',         [DocumentController::class, 'photoCreate'])->name('documents.photo');
Route::post  ('tenants/{tenant}/photo',         [DocumentController::class, 'photoStore'])->name('documents.photo.store');
Route::delete('tenants/{tenant}/photo',         [DocumentController::class, 'photoDestroy'])->name('documents.photo.destroy');

Route::resource('invoices', InvoiceController::class)
         ->only(['index', 'create', 'store', 'show']);

Route::patch('invoices/{invoice}/paid',        [InvoiceController::class, 'markPaid'])->name('invoices.paid');
Route::get  ('invoices/{invoice}/print',       [InvoiceController::class, 'print'])->name('invoices.print');
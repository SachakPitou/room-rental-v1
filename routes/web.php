<?php
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\InvoiceController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('rooms',   RoomController::class)
         ->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);

Route::resource('tenants', TenantController::class)
         ->only(['index', 'create', 'store', 'show', 'destroy']);

Route::get ('tenants/{tenant}/checkout',       [TenantController::class, 'editCheckout'])->name('tenants.checkout');
Route::post('tenants/{tenant}/checkout',       [TenantController::class, 'checkout'])->name('tenants.checkout.store');

Route::resource('invoices', InvoiceController::class)
         ->only(['index', 'create', 'store', 'show']);

Route::patch('invoices/{invoice}/paid',        [InvoiceController::class, 'markPaid'])->name('invoices.paid');
Route::get  ('invoices/{invoice}/print',       [InvoiceController::class, 'print'])->name('invoices.print');
<?php
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\InvoiceController;

Route::get('/',          [DashboardController::class, 'index'])->name('dashboard');
Route::resource('rooms',    RoomController::class)->only(['index', 'edit', 'update']);
Route::resource('tenants',  TenantController::class)->only(['index', 'create', 'store', 'destroy']);
Route::resource('invoices', InvoiceController::class)->only(['index', 'create', 'store', 'show']);
Route::patch('invoices/{invoice}/paid', [InvoiceController::class, 'markPaid'])->name('invoices.paid');
<?php
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\UserController;

// Breeze auth routes (login / logout)
require __DIR__.'/auth.php';

// All routes require login
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Rooms
    Route::resource('rooms', RoomController::class)
         ->only(['index', 'show', 'create', 'store', 'edit', 'update', 'destroy']);
    // User management
    Route::resource('users', UserController::class)
        ->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);

    Route::post('users/{user}/reset-password',
        [UserController::class, 'resetPassword'])->name('users.reset-password');
    // Tenants
    Route::resource('tenants', TenantController::class)
         ->only(['index', 'create', 'store', 'show', 'edit', 'update', 'destroy']);

    Route::get ('tenants/{tenant}/checkout',
        [TenantController::class, 'editCheckout'])->name('tenants.checkout');
    Route::post('tenants/{tenant}/checkout',
        [TenantController::class, 'checkout'])->name('tenants.checkout.store');
    Route::get ('tenants/{tenant}/recheckin',
        [TenantController::class, 'reCheckin'])->name('tenants.recheckin');
    Route::post('tenants/{tenant}/recheckin',
        [TenantController::class, 'reCheckinStore'])->name('tenants.recheckin.store');

    // Invoices
    Route::resource('invoices', InvoiceController::class)
         ->only(['index', 'create', 'store', 'show']);
    Route::patch('invoices/{invoice}/paid',
        [InvoiceController::class, 'markPaid'])->name('invoices.paid');
    Route::get('invoices/{invoice}/print',
        [InvoiceController::class, 'print'])->name('invoices.print');

    // Documents
    Route::get   ('tenants/{tenant}/document/upload',
        [DocumentController::class, 'create'])->name('documents.create');
    Route::post  ('tenants/{tenant}/document',
        [DocumentController::class, 'store'])->name('documents.store');
    Route::get   ('tenants/{tenant}/document/view',
        [DocumentController::class, 'show'])->name('documents.show');
    Route::delete('tenants/{tenant}/document',
        [DocumentController::class, 'destroy'])->name('documents.destroy');

    // Photos
    Route::get   ('tenants/{tenant}/photo',
        [DocumentController::class, 'photoCreate'])->name('documents.photo');
    Route::post  ('tenants/{tenant}/photo',
        [DocumentController::class, 'photoStore'])->name('documents.photo.store');
    Route::delete('tenants/{tenant}/photo',
        [DocumentController::class, 'photoDestroy'])->name('documents.photo.destroy');

    // Change password
    Route::get('change-password',
        [PasswordController::class, 'edit'])->name('password.change');
    Route::put('change-password',
        [PasswordController::class, 'update'])->name('password.update');

    // Storage serve (shared hosting fix)
    Route::get('uploads/{type}/{filename}', function ($type, $filename) {
        if (!in_array($type, ['photos', 'documents'])) abort(404);
        $path = storage_path('app/public/' . $type . '/' . $filename);
        if (!file_exists($path)) abort(404);
        return response()->file($path, [
            'Content-Type'  => mime_content_type($path),
            'Cache-Control' => 'public, max-age=86400',
        ]);
    })->name('uploads.serve');

});
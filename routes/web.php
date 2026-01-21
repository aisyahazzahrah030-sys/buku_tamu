<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuestBookController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;

// Public Guest Routes
Route::get('/', [GuestBookController::class, 'index'])->name('guest.form');
Route::post('/', [GuestBookController::class, 'store'])->name('guest.store');

// Adminer Route Workaround (Access via /adminer)
Route::any('/adminer', function() {
    if (file_exists(public_path('adminer.php'))) {
        require public_path('adminer.php');
        return; // Stop Laravel execution
    }
    abort(404);
});

// Admin Auth Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    
    // Protected Admin Routes
    Route::middleware('auth:admin')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        Route::get('/guests/export', [DashboardController::class, 'export'])->name('guests.export');
        Route::get('/guests/print', [DashboardController::class, 'printReport'])->name('guests.print');
        Route::get('/guests/{id}/edit', [DashboardController::class, 'edit'])->name('guests.edit');
        Route::put('/guests/{id}', [DashboardController::class, 'update'])->name('guests.update');
        Route::get('/guests/{id}', [DashboardController::class, 'show'])->name('guests.show');
        Route::delete('/guests/{id}', [DashboardController::class, 'destroy'])->name('guests.destroy');
    });
});

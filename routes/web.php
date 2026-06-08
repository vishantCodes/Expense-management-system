<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExpenseApprovalController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ExpenseRejectionController;
use App\Http\Middleware\EditExpensePermissionCheck;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect(route('showLogin'));
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('showLogin');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('expense')->name('expense.')->group(function () {
        Route::get('index',                [ExpenseController::class, 'index'])->name('index');
        Route::get('create',               [ExpenseController::class, 'create'])->name('create');
        Route::post('store',               [ExpenseController::class, 'store'])->name('store');

        Route::get('edit/{expense}',       [ExpenseController::class, 'edit'])->name('edit')
            ->middleware(EditExpensePermissionCheck::class);
            
        Route::put('update/{expense}',     [ExpenseController::class, 'update'])->name('update');
        Route::get('show/{expense}',       [ExpenseController::class, 'show'])->name('show');

        Route::get('pending-approvals', [ExpenseController::class, 'pendingApprovals'])->name('pendingApprovals');

        Route::post('approve/{expense}', [ExpenseApprovalController::class, 'store'])->name('approve');
        Route::post('reject/{expense}', [ExpenseRejectionController::class, 'store'])->name('reject');
        Route::post('store/query/{expense}', [ExpenseRejectionController::class, 'store'])->name('store.query');
        Route::post('store/comment/{expense}', [ExpenseRejectionController::class, 'store'])->name('store.comment');
    });

    Route::prefix('vendor')->name('vendor.')->group(function () {
        Route::get('/', [App\Http\Controllers\VendorController::class, 'index'])->name('index');
        Route::get('create', [App\Http\Controllers\VendorController::class, 'create'])->name('create');
        Route::post('store', [App\Http\Controllers\VendorController::class, 'store'])->name('store');
        Route::get('edit/{vendor}', [App\Http\Controllers\VendorController::class, 'edit'])->name('edit');
        Route::put('update/{vendor}', [App\Http\Controllers\VendorController::class, 'update'])->name('update');
        Route::get('show/{vendor}', [App\Http\Controllers\VendorController::class, 'show'])->name('show');
        Route::delete('destroy/{vendor}', [App\Http\Controllers\VendorController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('user')->name('user.')->group(function () {
        Route::get('/', [App\Http\Controllers\UserController::class, 'index'])->name('index');
        Route::get('create', [App\Http\Controllers\UserController::class, 'create'])->name('create');
        Route::post('store', [App\Http\Controllers\UserController::class, 'store'])->name('store');
        Route::get('edit/{user}', [App\Http\Controllers\UserController::class, 'edit'])->name('edit');
        Route::put('update/{user}', [App\Http\Controllers\UserController::class, 'update'])->name('update');
        Route::get('show/{user}', [App\Http\Controllers\UserController::class, 'show'])->name('show');
        Route::delete('destroy/{user}', [App\Http\Controllers\UserController::class, 'destroy'])->name('destroy');
    });
});

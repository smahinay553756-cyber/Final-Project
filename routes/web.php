<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\SuperAdmin;
use App\Http\Controllers\Customer;
use App\Http\Controllers\Staff;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => redirect()->route('login'));

require __DIR__.'/auth.php';

Route::prefix('superadmin')->name('superadmin.')->middleware(['auth', 'role:superadmin'])->group(function () {
    Route::get('/dashboard', [SuperAdmin\DashboardController::class, 'index'])->name('dashboard');
    Route::patch('/users/{user}/approve', [SuperAdmin\DashboardController::class, 'approve'])->name('users.approve');
    Route::delete('/users/{user}/reject', [SuperAdmin\DashboardController::class, 'reject'])->name('users.reject');
    Route::delete('/users/{user}/remove', [SuperAdmin\DashboardController::class, 'removeUser'])->name('users.remove');
    Route::patch('/removals/{removalRequest}/approve', [SuperAdmin\DashboardController::class, 'approveRemoval'])->name('removals.approve');
    Route::patch('/removals/{removalRequest}/reject', [SuperAdmin\DashboardController::class, 'rejectRemoval'])->name('removals.reject');
    Route::get('/supplies', [SuperAdmin\StockLogController::class, 'index'])->name('supplies.index');
    Route::get('/sales', [SuperAdmin\DashboardController::class, 'sales'])->name('sales.index');
    Route::get('/customers', [SuperAdmin\DashboardController::class, 'customers'])->name('customers.index');
});

Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('medicines', Admin\MedicineController::class);
    Route::get('/orders', [Admin\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [Admin\OrderController::class, 'show'])->name('orders.show');
    Route::get('/orders/{order}/receipt', [Admin\OrderController::class, 'receipt'])->name('orders.receipt');
    Route::get('/users', [Admin\UserController::class, 'index'])->name('users.index');
    Route::get('/customers', [Admin\UserController::class, 'customers'])->name('customers.index');
    Route::patch('/users/{user}/approve', [Admin\UserController::class, 'approveStaff'])->name('users.approve');
    Route::delete('/users/{user}/reject', [Admin\UserController::class, 'rejectStaff'])->name('users.reject');
    Route::post('/users/{user}/request-removal', [Admin\UserController::class, 'requestRemoval'])->name('users.request_removal');
    Route::get('/supplies', [Admin\StockLogController::class, 'index'])->name('supplies.index');
    Route::patch('/supplies/{stockLog}/approve', [Admin\StockLogController::class, 'approve'])->name('supplies.approve');
    Route::patch('/supplies/{stockLog}/reject', [Admin\StockLogController::class, 'reject'])->name('supplies.reject');
});

Route::prefix('staff')->name('staff.')->middleware(['auth', 'role:staff'])->group(function () {
    Route::get('/dashboard', [Staff\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/orders', [Staff\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/walkin', [Staff\OrderController::class, 'walkinCreate'])->name('orders.walkin');
    Route::post('/orders/walkin', [Staff\OrderController::class, 'walkinStore'])->name('orders.walkin.store');
    Route::get('/orders/{order}/receipt', [Staff\OrderController::class, 'receipt'])->name('orders.receipt');
    Route::get('/orders/{order}', [Staff\OrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/status/{status}', [Staff\OrderController::class, 'updateStatus'])->name('orders.status');
    Route::get('/stock', [Staff\StockController::class, 'index'])->name('stock.index');
    Route::post('/stock/{medicine}/in', [Staff\StockController::class, 'stockIn'])->name('stock.in');
    Route::post('/stock/{medicine}/out', [Staff\StockController::class, 'stockOut'])->name('stock.out');
});

Route::prefix('customer')->name('customer.')->middleware(['auth', 'role:customer'])->group(function () {
    Route::get('/dashboard', [Customer\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/catalog', [Customer\OrderController::class, 'catalog'])->name('catalog');
    Route::get('/orders', [Customer\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/create', [Customer\OrderController::class, 'create'])->name('orders.create');
    Route::post('/orders', [Customer\OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{order}', [Customer\OrderController::class, 'show'])->name('orders.show');
    Route::get('/orders/{order}/receipt', [Customer\OrderController::class, 'receipt'])->name('orders.receipt');
    Route::patch('/orders/{order}/cancel', [Customer\OrderController::class, 'cancel'])->name('orders.cancel');
    Route::patch('/orders/{order}/pay', [Customer\OrderController::class, 'pay'])->name('orders.pay');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

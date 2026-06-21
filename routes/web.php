<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DebtController;
use App\Http\Controllers\GoalController;
use App\Http\Controllers\PeriodicTransactionController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::inertia('/', 'Welcome')->name('home');

Route::middleware(['auth', 'verified', 'account'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('transactions', TransactionController::class)->except('show', 'edit', 'create');
    Route::resource('periodic_transactions', PeriodicTransactionController::class)->except('show', 'edit', 'create');
    Route::resource('categories', CategoryController::class)->except('show', 'create', 'edit');
    Route::resource('goals', GoalController::class)->except('show', 'create', 'edit', 'delete');
    Route::resource('debts', DebtController::class)->except('show', 'create', 'edit');
});

require __DIR__.'/settings.php';

<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PeriodicTransactionController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::inertia('/', 'Welcome')->name('home');

Route::middleware(['auth', 'verified', 'account'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('transactions', TransactionController::class)->except('show');
    Route::resource('periodic_transactions', PeriodicTransactionController::class)->except('show');
});

require __DIR__.'/settings.php';

<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $account = $user->account;

        // Total balance
        $balance = $account->starting_balance + $account->transactions()->sum('amount');

        // Recent transactions
        $recentTransactions = $account->transactions()
            ->latest()
            ->take(5)
            ->get();

        // Monthly income vs expense
        $monthly = $account->transactions()
            ->selectRaw('
                SUM(CASE WHEN amount > 0 THEN amount ELSE 0 END) as income,
                SUM(CASE WHEN amount < 0 THEN amount ELSE 0 END) as expense
            ')
            ->whereMonth('created_at', now()->month)
            ->first();

        return Inertia::render('Dashboard', [
            'balance' => $balance,
            'recentTransactions' => $recentTransactions,
            'income' => (float) ($monthly->income ?? 0),
            'expense' => (float) abs($monthly->expense ?? 0),
        ]);
    }
}

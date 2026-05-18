<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $account = $user->account;

        $balance = $this->totalBalance($account);

        $recentTransactions = $this->recentTransactions($account);

        $monthlyIncomeVsExpense = $this->monthlyIncomeVsExpense($account);

        $balanceHistory = $this->balanceHistory($account);

        return Inertia::render('Dashboard', [
            'balance' => $balance,
            'recentTransactions' => $recentTransactions,
            'income' => (float) ($monthlyIncomeVsExpense->income ?? 0),
            'expense' => (float) abs($monthlyIncomeVsExpense->expense ?? 0),
            'balanceHistory' => $balanceHistory,
        ]);
    }

    private function totalBalance(Account $account)
    {
        return $account->starting_balance + $account->transactions()->sum('amount');
    }

    private function recentTransactions(Account $account)
    {
        return $account->transactions()->latest()->take(5)->get();
    }

    private function monthlyIncomeVsExpense(Account $account)
    {
        return $account->transactions()
            ->selectRaw('
                SUM(CASE WHEN amount > 0 THEN amount ELSE 0 END) as income,
                SUM(CASE WHEN amount < 0 THEN amount ELSE 0 END) as expense
            ')
            ->whereMonth('created_at', now()->month)
            ->first();
    }

    private function balanceHistory(Account $account)
    {
        $transactions = $account->transactions()
            ->orderBy('created_at')
            ->where('created_at', '>=', now()->subDays(30))
            ->get(['amount', 'created_at']);

        $balance = $account->starting_balance;

        $balanceHistory = [];

        foreach ($transactions as $transaction) {
            $balance += $transaction->amount;

            $balanceHistory[] = [
                'date' => $transaction->created_at->format('Y-m-d'),
                'balance' => $balance,
            ];
        }

        return $balanceHistory;
    }
}

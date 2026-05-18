<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Carbon\CarbonPeriod;
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
        $startDate = now()->subDays(10)->startOfDay();
        $endDate = now()->endOfDay();

        // 1. Get daily sums
        $dailyTransactions = $account->transactions()
            ->selectRaw('DATE(created_at) as date, SUM(amount) as total')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('total', 'date');

        // 2. Initialize balance BEFORE the period
        $initialBalance = $account->starting_balance +
            $account->transactions()
                ->where('created_at', '<', $startDate)
                ->sum('amount');

        $history = [];

        $period = CarbonPeriod::create($startDate, $endDate);
        foreach ($period as $date) {
            $day = $date->format('Y-m-d');

            $initialBalance += $dailyTransactions->get($day, 0);

            $history[] = [
                'date' => $day,
                'balance' => $initialBalance,
            ];
        }

        return $history;
    }
}

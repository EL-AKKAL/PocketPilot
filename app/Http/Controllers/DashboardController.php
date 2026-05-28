<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Services\GoalProgressService;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(GoalProgressService $goalService)
    {
        $user = Auth::user();
        $account = $user->account;

        $balance = $this->totalBalance($account);

        $recentTransactions = $this->recentTransactions($account);

        $monthlyIncomeVsExpense = $this->monthlyIncomeVsExpense($account);

        $balanceHistory = $this->balanceHistory($account);

        [$goalData,$canCreateGoal] = $this->currentGoal($account, $goalService);

        return Inertia::render('Dashboard', [
            'balance' => $balance,
            'recentTransactions' => $recentTransactions,
            'income' => (float) ($monthlyIncomeVsExpense->income ?? 0),
            'expense' => (float) abs($monthlyIncomeVsExpense->expense ?? 0),
            'balanceHistory' => $balanceHistory,
            'goal' => $goalData,
            'canCreateGoal' => $canCreateGoal,
        ]);
    }

    private function totalBalance(Account $account)
    {
        return $account->starting_balance + $account->transactions()->sum('amount');
    }

    private function recentTransactions(Account $account)
    {
        return $account->transactions()->latest()->take(4)->get();
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

    private function currentGoal(Account $account, GoalProgressService $goalService)
    {
        $goal = $account->goals()
            ->orderByDesc('starts_at')
            ->first();
        $goalData = null;
        $canCreateGoal = true;

        if ($goal) {
            $progressData = $goalService->calculate($goal);

            $goalData = [
                'value' => (float) $goal->value,
                'period' => $goal->period,
                'progress' => $progressData['progress'],
                'percentage' => $progressData['percentage'],
                'status' => $progressData['status'],
                'ends_at' => $goal->ends_at,
                'type' => $goal->type,
                'starts_at' => $goal->starts_at,
                'account_id' => $goal->account_id,
                'id' => $goal->id,
            ];

            $canCreateGoal = $goal->status !== 'in_progress';
        }

        return [
            $goalData, $canCreateGoal,
        ];
    }
}

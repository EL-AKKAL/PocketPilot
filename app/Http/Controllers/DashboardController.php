<?php

namespace App\Http\Controllers;

use App\Enums\GoalStatusEnum;
use App\Models\Account;
use App\Services\Goal\GoalLifecycleService;
use App\Services\Goal\GoalProgressService;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(GoalProgressService $goalProgressService, GoalLifecycleService $goalLifecycleService)
    {
        $user = Auth::user();
        $account = $user->account;

        $balance = $this->totalBalance($account);

        $recentTransactions = $this->recentTransactions($account);

        $monthlyIncomeVsExpense = $this->monthlyIncomeVsExpense($account);

        $balanceHistory = $this->balanceHistory($account);

        [$goalData,$canCreateGoal] = $this->currentGoal($account, $goalProgressService, $goalLifecycleService);

        $expensesByCategory = $this->expensesByCategory($account);

        $mostUsed = $this->mostUsedCategories($account);

        $monthlyNetWorthTrend = $this->MonthlyNetWorthTrend($account);

        $upcomingObligations = $this->UpcomingObligations($account);

        return Inertia::render('Dashboard', [
            'balance' => $balance,
            'recentTransactions' => $recentTransactions,
            'income' => (float) ($monthlyIncomeVsExpense->income ?? 0),
            'expense' => (float) abs($monthlyIncomeVsExpense->expense ?? 0),
            'balanceHistory' => $balanceHistory,
            'goal' => $goalData,
            'canCreateGoal' => $canCreateGoal,
            'expensesByCategory' => $expensesByCategory,
            'mostUsedCategories' => $mostUsed,
            'monthlyNetWorthTrend' => $monthlyNetWorthTrend,
            'upcomingObligations' => $upcomingObligations,
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
            ->whereYear('created_at', now()->year)
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

    private function currentGoal(Account $account, GoalProgressService $goalProgressService, GoalLifecycleService $goalLifecycleService)
    {
        $goal = $account->goals()
            ->orderByDesc('starts_at')
            ->first();
        $goalData = null;
        $canCreateGoal = true;

        if ($goal) {
            $progress = $goalProgressService->calculate($goal);
            $status = $goalLifecycleService->determineStatus(
                $goal,
                $progress['progress']
            );

            $goalData = [
                'value' => (float) $goal->value,
                'period' => $goal->period,
                'progress' => $progress['progress'],
                'percentage' => $progress['percentage'],
                'status' => $status->value,
                'ends_at' => $goal->ends_at,
                'type' => $goal->type,
                'id' => $goal->id,
            ];

            $canCreateGoal = $status !== GoalStatusEnum::IN_PROGRESS;
        }

        return [
            $goalData, $canCreateGoal,
        ];
    }

    private function expensesByCategory(Account $account)
    {
        return $account->transactions()
            ->with('category:id,value')
            ->where('amount', '<', 0)
            ->get()
            ->groupBy('category.value')
            ->map(fn ($transactions, $category) => [
                'category' => $category,
                'total' => abs($transactions->sum('amount')),
            ])
            ->values();
    }

    private function mostUsedCategories(Account $account): array
    {
        $transactions = $account->transactions()
            ->with('category:id,value')
            ->whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->get();

        $topIncome = $transactions
            ->where('amount', '>', 0)
            ->groupBy('category.value')
            ->map(fn ($items, $category) => [
                'category' => $category,
                'count' => $items->count(),
                'total_amount' => $items->sum('amount'),
            ])
            ->sortByDesc('total_amount')
            ->first();

        $topExpense = $transactions
            ->where('amount', '<', 0)
            ->groupBy('category.value')
            ->map(fn ($items, $category) => [
                'category' => $category,
                'count' => $items->count(),
                'total_amount' => abs($items->sum('amount')),
            ])
            ->sortByDesc('total_amount')
            ->first();

        return [
            'income' => $topIncome,
            'expense' => $topExpense,
        ];

    }

    private function MonthlyNetWorthTrend(Account $account)
    {
        return $account->transactions()->selectRaw("
                DATE_FORMAT(created_at, '%b %Y') as month,
                SUM(CASE WHEN amount > 0 THEN amount ELSE 0 END) as income,
                SUM(CASE WHEN amount < 0 THEN amount ELSE 0 END) as expense
            ")
            ->groupByRaw("DATE_FORMAT(created_at, '%Y-%m'), DATE_FORMAT(created_at, '%b %Y')")
            ->orderByRaw("DATE_FORMAT(created_at, '%Y-%m')")
            ->get()
            ->map(fn ($month) => [
                'month' => $month->month,
                'income' => (float) $month->income,
                'expense' => (float) $month->expense,
                'net' => (float) ($month->income - abs($month->expense)),
            ]);
    }

    private function UpcomingObligations(Account $account)
    {
        $debts = $account->debts()
            ->whereNull('paid_at')
            ->whereDate('due_date', '>=', today())
            ->select([
                'description',
                'amount',
                'due_date as date',
            ])
            ->get()
            ->map(fn ($debt) => [
                'type' => 'Debt',
                'title' => $debt->description ?: 'Debt',
                'amount' => $debt->amount,
                'date' => $debt->date,
                'human_date' => $this->humanDate($debt->date),
            ]);

        $periodic = $account->periodicTransactions()
            ->where('is_active', true)
            ->whereDate('next_apply_date', '>=', today())
            ->select([
                'description',
                'amount',
                'next_apply_date as date',
            ])
            ->get()
            ->map(fn ($transaction) => [
                'type' => 'Periodic',
                'title' => $transaction->description ?: 'Recurring transaction',
                'amount' => $transaction->amount,
                'date' => $transaction->date,
                'human_date' => $this->humanDate($transaction->date),
            ]);

        return collect($debts)
            ->merge($periodic)
            ->sortBy('date')
            ->take(10)
            ->values();
    }

    private function humanDate($date): string
    {
        return Carbon::parse($date)->diffForHumans([
            'syntax' => Carbon::DIFF_RELATIVE_TO_NOW,
            'parts' => 1,
        ]);
    }
}

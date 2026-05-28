<?php

namespace App\Observers;

use App\Models\Transaction;
use App\Services\GoalProgressService;

class TransactionObserver
{
    public function created(Transaction $transaction)
    {
        $this->updateGoal($transaction);
    }

    public function updated(Transaction $transaction)
    {
        $this->updateGoal($transaction);
    }

    private function updateGoal(Transaction $transaction)
    {
        $goal = $transaction->account
            ->goals()
            ->where('status', 'in_progress')
            ->latest()
            ->first();

        if (! $goal) {
            return;
        }

        $service = app(GoalProgressService::class);
        $service->calculate($goal);
    }
}

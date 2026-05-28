<?php

namespace App\Jobs;

use App\Models\Goal;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class RollGoalsJob implements ShouldQueue
{
    use Queueable;

    public function handle(): void
    {
        $now = now();

        $goals = Goal::where('status', 'in_progress')
            ->where('ends_at', '<', $now)
            ->get();

        foreach ($goals as $goal) {

            // 1. Mark as failed
            $goal->update([
                'status' => 'failed',
            ]);

            // 2. Create next goal
            $goal->account->goals()->create([
                'value' => $goal->value,
                'period' => $goal->period,
                'type' => $goal->type,
                'status' => 'in_progress',
                'starts_at' => $now,
                'ends_at' => $this->calculateNextEnd($goal->period),
            ]);
        }
    }

    private function calculateNextEnd(string $period): Carbon
    {
        return match ($period) {
            'daily' => now()->endOfDay(),
            'weekly' => now()->endOfWeek(),
            'monthly' => now()->endOfMonth(),
        };
    }
}

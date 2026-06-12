<?php

namespace App\Jobs;

use App\Enums\GoalStatusEnum;
use App\Models\Goal;
use App\Services\Goal\GoalLifecycleService;
use App\Services\Goal\GoalProgressService;
use App\Services\Goal\GoalRollService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class RollGoalsJob implements ShouldQueue
{
    use Queueable;

    public function handle(
        GoalProgressService $progressService,
        GoalLifecycleService $lifecycleService,
        GoalRollService $rollService
    ): void {

        Goal::where('status', GoalStatusEnum::IN_PROGRESS->value)
            ->where('ends_at', '<', now())
            ->each(function (Goal $goal) use (
                $progressService,
                $lifecycleService,
                $rollService
            ) {
                $progress = $progressService
                    ->calculate($goal);

                $status = $lifecycleService
                    ->determineStatus(
                        $goal,
                        $progress['progress']
                    );

                $rollService->roll(
                    $goal,
                    $status
                );
            });
    }
}

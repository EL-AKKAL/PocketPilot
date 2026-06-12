<?php

namespace App\Services\Goal;

use App\Enums\GoalPeriodEnum;
use App\Enums\GoalStatusEnum;
use App\Models\Goal;
use Carbon\CarbonImmutable;

class GoalRollService
{
    public function roll(Goal $goal, GoalStatusEnum $status): Goal
    {
        $goal->update(['status' => $status->value]);

        return $goal->account->goals()->create([
            'value' => $goal->value,
            'period' => $goal->period,
            'type' => $goal->type,
            'status' => GoalStatusEnum::IN_PROGRESS->value,
            'starts_at' => now(),
            'ends_at' => $this->calculateNextEnd(GoalPeriodEnum::from($goal->period)),
        ]);
    }

    private function calculateNextEnd(GoalPeriodEnum $period): CarbonImmutable
    {
        return match ($period) {
            GoalPeriodEnum::DAILY => now()->endOfDay(),
            GoalPeriodEnum::WEEKLY => now()->endOfWeek(),
            GoalPeriodEnum::MONTHLY => now()->endOfMonth(),
        };
    }
}

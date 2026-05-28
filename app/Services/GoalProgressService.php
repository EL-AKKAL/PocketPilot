<?php

namespace App\Services;

use App\Enums\GoalStatusEnum;
use App\Enums\GoalTypeEnum;
use App\Models\Goal;

class GoalProgressService
{
    public function calculate(Goal $goal): array
    {
        $query = $goal->account
            ->transactions()
            ->whereBetween('created_at', [$goal->starts_at, $goal->ends_at]);

        $total = match ($goal->type) {
            GoalTypeEnum::SAVINGS->value => (float) $query->clone()->where('amount', '>', 0)->sum('amount'),
            GoalTypeEnum::NET->value => (float) $query->sum('amount'),
            default => 0,
        };

        $progress = max(0, $total);
        $percentage = min(100, ($progress / $goal->value) * 100);

        $status = 'in_progress';

        if ($progress >= $goal->value) {
            $status = GoalStatusEnum::ACHIEVED->value;
        } elseif (now()->greaterThan($goal->ends_at)) {
            $status = GoalStatusEnum::FAILED->value;
        }

        if ($goal->status !== $status) {
            $goal->update(['status' => $status]);
        }

        return [
            'progress' => $progress,
            'percentage' => round($percentage, 2),
            'status' => $status,
        ];
    }
}

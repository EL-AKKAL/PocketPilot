<?php

namespace App\Services\Goal;

use App\Enums\GoalStatusEnum;
use App\Models\Goal;

class GoalLifecycleService
{
    public function determineStatus(Goal $goal, float $progress): GoalStatusEnum
    {
        if ($progress >= $goal->value) {
            return GoalStatusEnum::ACHIEVED;
        }

        if (now()->greaterThan($goal->ends_at)) {
            return GoalStatusEnum::FAILED;
        }

        return GoalStatusEnum::IN_PROGRESS;
    }
}

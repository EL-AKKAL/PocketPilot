<?php

namespace App\Enums;

enum GoalStatusEnum: string
{
    case IN_PROGRESS = 'in_progress';
    case ACHIEVED = 'achieved';
    case FAILED = 'failed';
}

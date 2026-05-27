<?php

namespace App\Enums;

enum GoalPeriodEnum: string
{
    case DAILY = 'daily';
    case WEEKLY = 'weekly';
    case MONTHLY = 'monthly';
}

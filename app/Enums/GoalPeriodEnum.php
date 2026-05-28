<?php

namespace App\Enums;

enum GoalPeriodEnum: string
{
    case DAILY = 'Daily';
    case WEEKLY = 'Weekly';
    case MONTHLY = 'Monthly';
}

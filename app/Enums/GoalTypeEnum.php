<?php

namespace App\Enums;

enum GoalTypeEnum: string
{
    case SAVINGS = 'Savings'; // only income
    case NET = 'Net';         // income - expenses
}

<?php

namespace App\Enums;

enum CategoryEnum: string
{
    case FOOD = 'Food';
    case TRANSPORT = 'Transport';
    case BILLS = 'Bills';
    case NEEDS = 'Needs';
    case WANTS = 'Wants';
    case EMERGENCIES = 'Emergencies';
    case FIXES = 'Fixes';

    case BUSINESS = 'Business';
    case INVESTMENTS = 'Investments';
    case SALARY = 'Salary';

    public static function values(): array
    {
        return array_map(fn ($case) => $case->value, self::cases());
    }
}

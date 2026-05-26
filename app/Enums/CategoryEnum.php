<?php

namespace App\Enums;

enum CategoryEnum: string
{
    // Expenses
    case FOOD = 'Food';
    case TRANSPORT = 'Transport';
    case BILLS = 'Bills';
    case NEEDS = 'Needs';
    case WANTS = 'Wants';
    case EMERGENCIES = 'Emergencies';
    case FIXES = 'Fixes';

    // Income
    case SALARY = 'Salary';
    case FREELANCE = 'Freelance';
    case BUSINESS = 'Business';
    case INVESTMENTS = 'Investments';
    case OTHER_INCOME = 'Other Income';

    public static function values(): array
    {
        return array_map(fn ($case) => $case->value, self::cases());
    }

    public function isIncome(): bool
    {
        return in_array($this, [
            self::SALARY,
            self::FREELANCE,
            self::BUSINESS,
            self::INVESTMENTS,
            self::OTHER_INCOME,
        ]);
    }

    public function isExpense(): bool
    {
        return ! $this->isIncome();
    }

    public static function income(): array
    {
        return array_map(
            fn ($case) => $case->value,
            array_filter(self::cases(), fn ($case) => $case->isIncome())
        );
    }

    public static function expense(): array
    {
        return array_map(
            fn ($case) => $case->value,
            array_filter(self::cases(), fn ($case) => $case->isExpense())
        );
    }
}

<?php

namespace Database\Seeders;

use App\Enums\TypeEnum;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $ID = Auth::user()->account->id;
        $expenses = [
            'Food',
            'Transport',
            'Bills',
            'Needs',
            'Wants',
            'Emergencies',
            'Fixes',
        ];
        $incomes = [
            'Salary',
            'Freelance',
            'Business',
            'Investments',
            'Other Income',
        ];

        foreach ($expenses as $expense) {
            Category::create([
                'value' => $expense,
                'type' => TypeEnum::EXPENSE,
                'account_id' => $ID,
            ]);
        }

        foreach ($incomes as $income) {
            Category::create([
                'value' => $income,
                'type' => TypeEnum::INCOME,
                'account_id' => $ID,
            ]);
        }
    }
}

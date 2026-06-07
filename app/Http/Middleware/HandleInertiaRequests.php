<?php

namespace App\Http\Middleware;

use App\Enums\GoalPeriodEnum;
use App\Enums\GoalTypeEnum;
use App\Enums\TypeEnum;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    protected $rootView = 'app';

    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    public function categories(): array
    {
        $income = Category::whereBelongsTo(Auth::user()->account)
            ->where('type', TypeEnum::INCOME);

        $expense = Category::whereBelongsTo(Auth::user()->account)
            ->where('type', TypeEnum::EXPENSE);

        return [
            'expense' => $expense->pluck('value', 'id'),
            'income' => $income->pluck('value', 'id'),
        ];
    }

    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'name' => config('app.name'),
            'auth' => [
                'user' => $request->user(),
            ],
            'categories' => $this->categories(),
            'goalPeriods' => GoalPeriodEnum::cases(),
            'goalTypes' => GoalTypeEnum::cases(),
            'sidebarOpen' => ! $request->hasCookie('sidebar_state') || $request->cookie('sidebar_state') === 'true',
        ];
    }
}

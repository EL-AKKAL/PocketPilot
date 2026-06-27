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
        $user = Auth::user();

        if (! $user || ! $user->account) {
            return [
                'income' => [],
                'expense' => [],
            ];
        }

        $income = Category::whereBelongsTo($user->account)
            ->where('type', TypeEnum::INCOME)->select(['id', 'value'])->get();

        $expense = Category::whereBelongsTo($user->account)
            ->where('type', TypeEnum::EXPENSE)->select(['id', 'value'])->get();

        return [
            'expense' => $expense,
            'income' => $income,
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
            'flash' => [
                'toast' => fn () => $request->session()->get('toast'),

                'showCategorySuggestions' => fn () => $request->session()->get('showCategorySuggestions'),

                'suggestedCategories' => fn () => $request->session()->get('suggestedCategories'),
            ],
        ];
    }
}

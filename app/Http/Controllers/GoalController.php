<?php

namespace App\Http\Controllers;

use App\Enums\GoalPeriodEnum;
use App\Http\Requests\StoreGoalRequest;
use App\Http\Requests\UpdateGoalRequest;
use App\Models\Goal;
use App\Services\GoalProgressService;
use Carbon\CarbonInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class GoalController extends Controller
{
    public function index()
    {
        $account = Auth::user()->account;

        $goalsHistory = $account->goals()
            ->where('status', '!=', 'in_progress')
            ->latest('starts_at')
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('goals/List', [
            'goalsHistory' => $goalsHistory,
        ]);
    }

    public function store(StoreGoalRequest $request)
    {
        $user = Auth::user();
        $account = $user->account;

        return DB::transaction(function () use ($request, $account) {

            // 1. Close previous active goal
            $account->goals()
                ->where('status', 'in_progress')
                ->update([
                    'status' => 'failed',
                    'ends_at' => now(),
                ]);

            $period = GoalPeriodEnum::from($request->period);
            // 2. Create new goal
            $account->goals()->create([
                'value' => $request->value,
                'period' => $period->value,
                'type' => $request->type,
                'starts_at' => now(),
                'ends_at' => $this->calculateEndDate($period),
            ]);

            Inertia::flash('toast', ['type' => 'success', 'message' => 'Goal created successfully']);

            return back();
        });
    }

    public function update(Goal $goal, UpdateGoalRequest $request)
    {
        if ($goal->status !== 'in_progress') {
            Inertia::flash('toast', ['type' => 'error', 'message' => 'You can only edit an active goal']);

            return back()->withErrors([
                'goal' => 'You can only edit an active goal',
            ]);
        }

        $goal->update($request->validated());

        app(GoalProgressService::class)->calculate($goal);

        Inertia::flash('toast', ['type' => 'success', 'message' => 'Goal updated successfully']);

        return back();
    }

    private function calculateEndDate(GoalPeriodEnum $period): CarbonInterface
    {
        return match ($period) {
            GoalPeriodEnum::DAILY => now()->endOfDay(),
            GoalPeriodEnum::WEEKLY => now()->endOfWeek(),
            GoalPeriodEnum::MONTHLY => now()->endOfMonth(),
        };
    }
}

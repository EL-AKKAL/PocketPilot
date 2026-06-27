<?php

namespace App\Http\Controllers;

use App\Concerns\HasToast;
use App\Enums\TypeEnum;
use App\Http\Requests\AccountRequest;
use App\Http\Requests\StoreInitialCategoriesRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class AccountController extends Controller
{
    use HasToast;

    public function create()
    {
        return Inertia::render('account/Create');
    }

    public function store(AccountRequest $request)
    {
        Auth::user()->account()->create(
            $request->validated()
        );

        $this->toast('account created successfully');

        return redirect()->route('dashboard')->with([
            'showCategorySuggestions' => true,
            'suggestedCategories' => [
                'expense' => ['Food', 'Transport', 'Rent', 'Fixes', 'Bills', 'Needs'],
                'income' => ['Salary', 'Freelance',  'Gift', 'Sells', 'Skills', 'Arts'],
            ]]);
    }

    public function storeStarterCategories(StoreInitialCategoriesRequest $request)
    {
        $validated = $request->validated();

        $categories = collect($validated['income'] ?? [])
            ->map(fn ($value) => [
                'value' => $value,
                'type' => TypeEnum::INCOME,
            ])
            ->merge(
                collect($validated['expense'] ?? [])
                    ->map(fn ($value) => [
                        'value' => $value,
                        'type' => TypeEnum::EXPENSE,
                    ])
            );

        DB::transaction(function () use ($categories) {
            Auth::user()->account->categories()->createMany($categories);
        });

        $this->toast('Starter categories imported successfully');

        return redirect()->route('dashboard');
    }
}

<?php

namespace App\Http\Controllers;

use App\Enums\TypeEnum;
use App\Http\Requests\DebtRequest;
use App\Models\Debt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class DebtController extends Controller
{
    public function index()
    {
        $debts = Debt::dataTable()->getResponse();

        return Inertia::render('debts/List', [
            'debts' => $debts,
        ]);
    }

    public function store(DebtRequest $request)
    {
        Auth::user()
            ->account
            ->debts()
            ->create($request->validated());

        $this->success('debt added successfully');

        return to_route('debts.index');
    }

    public function update(DebtRequest $request, Debt $debt)
    {
        $this->authorizeDebt($debt);

        $debt->update($request->validated());

        $this->success('debt updated successfully');

        return to_route('debts.index');
    }

    public function destroy(Debt $debt)
    {
        $this->authorizeDebt($debt);

        $debt->delete();

        $this->success('debt deleted successfully');

        return to_route('debts.index');
    }

    public function pay(Debt $debt)
    {
        $this->authorizeDebt($debt);

        if ($debt->paid_at) {
            $this->success('Debt already paid');

            return to_route('debts.index');
        }

        DB::transaction(function () use ($debt) {

            $category = $this->getDebtCategory();

            Auth::user()
                ->account
                ->transactions()
                ->create([
                    'amount' => -$debt->amount,
                    'description' => $debt->description,
                    'category_id' => $category->id,
                ]);

            $debt->update([
                'paid_at' => now(),
            ]);

        });

        $this->success('debt paid successfully');

        return to_route('debts.index');
    }

    private function authorizeDebt(Debt $debt)
    {
        abort_if($debt->account_id !== Auth::user()->account->id, 403);
    }

    private function success(string $message)
    {
        Inertia::flash('toast', [
            'type' => 'success',
            'message' => $message,
        ]);
    }

    private function getDebtCategory()
    {
        return Auth::user()
            ->account
            ->categories()
            ->firstOrCreate([
                'value' => 'Debt',
                'type' => TypeEnum::EXPENSE,
            ]);
    }
}

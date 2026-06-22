<?php

namespace App\Http\Controllers;

use App\Concerns\AuthorizeAction;
use App\Concerns\HasToast;
use App\Enums\TypeEnum;
use App\Http\Requests\DebtRequest;
use App\Models\Debt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class DebtController extends Controller
{
    use AuthorizeAction,HasToast;

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

        $this->toast('debt added successfully');

        return to_route('debts.index');
    }

    public function update(DebtRequest $request, Debt $debt)
    {
        $this->authorizeAccountOwnership($debt);

        $debt->update($request->validated());

        $this->toast('debt updated successfully');

        return to_route('debts.index');
    }

    public function destroy(Debt $debt)
    {
        $this->authorizeAccountOwnership($debt);

        $debt->delete();

        $this->toast('debt deleted successfully');

        return to_route('debts.index');
    }

    public function pay(Debt $debt)
    {
        $this->authorizeAccountOwnership($debt);

        if ($debt->paid_at) {
            $this->toast('Debt already paid');

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

            $debt->update(['paid_at' => now()]);

        });

        $this->toast('debt paid successfully');

        return to_route('debts.index');
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

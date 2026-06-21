<?php

namespace App\Http\Controllers;

use App\Http\Requests\DebtRequest;
use App\Models\Debt;
use Illuminate\Support\Facades\Auth;
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
}

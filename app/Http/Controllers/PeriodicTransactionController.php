<?php

namespace App\Http\Controllers;

use App\Concerns\AuthorizeAction;
use App\Concerns\HasToast;
use App\Http\Requests\PeriodicTransactionRequest;
use App\Models\PeriodicTransaction;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class PeriodicTransactionController extends Controller
{
    use AuthorizeAction,HasToast;

    public function index()
    {
        $periodics = PeriodicTransaction::dataTable()->getResponse();

        return Inertia::render('periodic/List', [
            'periodics' => $periodics,
        ]);
    }

    public function store(PeriodicTransactionRequest $request)
    {
        $account = Auth::user()->account;

        $account
            ->periodicTransactions()
            ->create([
                ...$request->validated(),
                'next_apply_date' => $request->start_date,
            ]);

        $this->toast('Periodic transaction created successfully');

        return to_route('periodic_transactions.index');
    }

    public function update(PeriodicTransactionRequest $request, PeriodicTransaction $periodicTransaction)
    {
        $this->authorizeAccountOwnership($periodicTransaction);

        $periodicTransaction->update($request->validated());

        $this->toast('Periodic transaction updated successfully');

        return to_route('periodic_transactions.index');
    }

    public function destroy(PeriodicTransaction $periodic_transaction)
    {
        $this->authorizeAccountOwnership($periodic_transaction);

        $periodic_transaction->delete();

        $this->toast('Periodic transaction deleted successfully');

        return to_route('periodic_transactions.index');
    }
}

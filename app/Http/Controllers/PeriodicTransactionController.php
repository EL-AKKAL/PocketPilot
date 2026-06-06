<?php

namespace App\Http\Controllers;

use App\Http\Requests\PeriodicTransactionRequest;
use App\Models\PeriodicTransaction;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class PeriodicTransactionController extends Controller
{
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

        $this->success('Periodic transaction created successfully');

        return to_route('periodic_transactions.index');
    }

    public function update(PeriodicTransactionRequest $request, PeriodicTransaction $periodicTransaction)
    {
        $this->authorizeTransaction($periodicTransaction);

        $periodicTransaction->update($request->validated());

        $this->success('Periodic transaction updated successfully');

        return to_route('periodic_transactions.index');
    }

    public function destroy(PeriodicTransaction $periodic_transaction)
    {
        $this->authorizeTransaction($periodic_transaction);

        $periodic_transaction->delete();

        $this->success('Periodic transaction deleted successfully');

        return to_route('periodic_transactions.index');
    }

    private function authorizeTransaction(PeriodicTransaction $periodic_transaction)
    {
        abort_if($periodic_transaction->account_id !== Auth::user()->account->id, 403);
    }

    private function success(string $message)
    {
        Inertia::flash('toast', [
            'type' => 'success',
            'message' => $message,
        ]);
    }
}

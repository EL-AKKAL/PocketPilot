<?php

namespace App\Http\Controllers;

use App\Http\Requests\PeriodicTransactionRequest;
use App\Models\PeriodicTransaction;
use Inertia\Inertia;

class PeriodicTransactionController extends Controller
{
    public function index()
    {
        $periodics = auth()->user()
            ->account
            ->periodicTransactions()
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('periodic/List', [
            'periodics' => $periodics,
        ]);
    }

    public function store(PeriodicTransactionRequest $request)
    {
        auth()->user()
            ->account
            ->periodicTransactions()
            ->create([
                ...$request->validated(),
                'next_apply_date' => $request->start_date,
            ]);

        Inertia::flash('toast', ['type' => 'success', 'message' => 'Periodic transaction created successfully']);

        return to_route('periodic_transactions.index');
    }

    public function edit(PeriodicTransaction $periodicTransaction)
    {
        return Inertia::render('periodic/Edit', ['periodicTransaction' => $periodicTransaction]);
    }

    public function update(PeriodicTransactionRequest $request, PeriodicTransaction $periodicTransaction)
    {
        $periodicTransaction->update($request->validated());

        Inertia::flash('toast', ['type' => 'success', 'message' => 'Periodic transaction updated successfully']);

        return to_route('periodic_transactions.index');
    }

    public function destroy(PeriodicTransaction $periodic_transaction)
    {
        $periodic_transaction->delete();

        Inertia::flash('toast', ['type' => 'success', 'message' => 'Periodic transaction deleted successfully']);

        return to_route('periodic_transactions.index');
    }
}

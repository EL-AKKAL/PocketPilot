<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionRequest;
use App\Models\Transaction;
use Inertia\Inertia;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = auth()->user()
            ->account
            ->transactions()
            ->latest()
            ->get();

        return Inertia::render('transactions/List', [
            'transactions' => $transactions,
        ]);
    }

    public function store(TransactionRequest $request)
    {
        auth()->user()
            ->account
            ->transactions()
            ->create($request->validated());

        Inertia::flash('toast', ['type' => 'success', 'message' => 'transaction added successfully']);

        return to_route('transactions.index');
    }

    public function edit(Transaction $transaction)
    {
        return Inertia::render('transactions/Edit', ['transaction' => $transaction]);
    }

    public function update(TransactionRequest $request, Transaction $transaction)
    {
        $transaction->update($request->validated());

        Inertia::flash('toast', ['type' => 'success', 'message' => 'transaction updated successfully']);

        return to_route('transactions.index');
    }

    public function destroy(Transaction $transaction)
    {
        $transaction->delete();
        Inertia::flash('toast', ['type' => 'success', 'message' => 'transaction deleted successfully']);

        return to_route('transactions.index');
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionRequest;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class TransactionController extends Controller
{
    public function index()
    {
        $account = Auth::user()->account;

        $transactions = $account
            ->transactions()
            ->select(['id', 'amount', 'category', 'description', 'created_at'])
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('transactions/List', [
            'transactions' => $transactions,
        ]);
    }

    public function store(TransactionRequest $request)
    {
        Auth::user()
            ->account
            ->transactions()
            ->create($request->validated());

        $this->success('transaction added successfully');

        return to_route('transactions.index');
    }

    public function update(TransactionRequest $request, Transaction $transaction)
    {
        $this->authorizeTransaction($transaction);

        $transaction->update($request->validated());

        $this->success('transaction updated successfully');

        return to_route('transactions.index');
    }

    public function destroy(Transaction $transaction)
    {
        $this->authorizeTransaction($transaction);

        $transaction->delete();

        $this->success('transaction deleted successfully');

        return to_route('transactions.index');
    }

    private function authorizeTransaction(Transaction $transaction)
    {
        abort_if($transaction->account_id !== Auth::user()->account->id, 403);
    }

    private function success(string $message)
    {
        Inertia::flash('toast', [
            'type' => 'success',
            'message' => $message,
        ]);
    }
}

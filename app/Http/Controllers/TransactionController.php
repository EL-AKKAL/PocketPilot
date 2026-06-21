<?php

namespace App\Http\Controllers;

use App\Concerns\HasToast;
use App\Http\Requests\TransactionRequest;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class TransactionController extends Controller
{
    use HasToast;

    public function index()
    {
        $transactions = Transaction::dataTable()->getResponse();

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

        $this->toast('transaction added successfully');

        return to_route('transactions.index');
    }

    public function update(TransactionRequest $request, Transaction $transaction)
    {
        $this->authorizeTransaction($transaction);

        $transaction->update($request->validated());

        $this->toast('transaction updated successfully');

        return to_route('transactions.index');
    }

    public function destroy(Transaction $transaction)
    {
        $this->authorizeTransaction($transaction);

        $transaction->delete();

        $this->toast('transaction deleted successfully');

        return to_route('transactions.index');
    }

    private function authorizeTransaction(Transaction $transaction)
    {
        abort_if($transaction->account_id !== Auth::user()->account->id, 403);
    }
}

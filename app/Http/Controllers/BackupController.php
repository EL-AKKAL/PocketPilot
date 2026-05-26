<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\PeriodicTransaction;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class BackupController extends Controller
{
    // chatgpt ideas for future improvments :
    // 🔍 “import preview timeline” (see how old data looks before importing)
    // 🧠 automatic “data migration versioning”
    private $VERSION = '1.0';

    public function export()
    {
        $user = Auth::user();

        $account = $user->account->makeHidden(['user_id', 'id']);
        $transactions = $account->transactions()->get()->makeHidden(['account_id']);
        $periodicTransactions = $account->periodicTransactions()->get()->makeHidden(['account_id']);

        $data = [
            'version' => '1.0',
            'exported_at' => now()->toISOString(),
            'account' => $account,
            'transactions' => $transactions,
            'periodic_transactions' => $periodicTransactions,
        ];

        $json = json_encode($data, JSON_PRETTY_PRINT);
        $filename = 'pocketpilot-backup-'.now()->format('Y-m-d_H-i').'.json';

        return response($json)
            ->header('Content-Type', 'application/json')
            ->header('Content-Disposition', 'attachment; filename="'.$filename.'"');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:json'],
        ]);

        $user = Auth::user();
        $oldAccount = $user->account;

        $content = file_get_contents($request->file('file')->getRealPath());
        $data = json_decode($content, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            Inertia::flash('toast', ['type' => 'error', 'message' => 'Invalid JSON file']);

            return back();
        }

        if (($data['version'] ?? null) !== $this->VERSION) {
            Inertia::flash('toast', ['type' => 'error', 'message' => 'Unsupported backup version']);

            return back();
        }

        // Validate structure
        if (
            ! isset($data['account']) ||
            ! isset($data['transactions']) ||
            ! isset($data['periodic_transactions'])
        ) {
            Inertia::flash('toast', ['type' => 'error', 'message' => 'Invalid backup structure']);

            return back()->withErrors(['file' => 'Invalid backup structure']);
        }

        DB::transaction(function () use ($oldAccount, $data, $user) {

            if ($oldAccount) {
                $oldAccount->transactions()->delete();
                $oldAccount->periodicTransactions()->delete();
                $oldAccount->delete();
            }

            // restore account
            $account = $this->restoreModel(Account::class, $data['account'], ['user_id' => $user->id]);

            // restore transactions
            foreach ($data['transactions'] as $t) {
                $this->restoreModel(Transaction::class, $t, [
                    'account_id' => $account->id,
                ]);
            }

            // restore periodic transactions
            foreach ($data['periodic_transactions'] as $p) {
                $this->restoreModel(PeriodicTransaction::class, $p, [
                    'account_id' => $account->id,
                ]);
            }
        });

        Inertia::flash('toast', ['type' => 'success', 'message' => 'Data restored successfully']);

        return back()->with('success', 'Data restored successfully');
    }

    private function restoreModel(string $modelClass, array $data, array $extra = []): mixed
    {
        $model = new $modelClass;
        $model->timestamps = false;

        $allowed = match ($modelClass) {
            Account::class => ['name', 'starting_balance', 'created_at', 'updated_at'],
            Transaction::class => ['amount', 'description', 'created_at', 'updated_at'],
            PeriodicTransaction::class => [
                'amount', 'start_date', 'end_date', 'frequency',
                'description', 'is_active', 'next_apply_date',
                'created_at', 'updated_at',
            ],
            default => throw new \Exception("Unsupported model: $modelClass"),
        };

        foreach ($data as $key => $value) {
            if (! in_array($key, $allowed)) {
                continue;
            }
            $model->$key = $value;
        }

        foreach ($extra as $key => $value) {
            $model->$key = $value;
        }

        $model->save();

        return $model;
    }
}

<?php

namespace App\Http\Controllers;

use App\Concerns\HasToast;
use App\Models\Category;
use App\Models\Goal;
use App\Models\PeriodicTransaction;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BackupController extends Controller
{
    use HasToast;

    private $VERSION = '1.0';

    public function export()
    {
        $user = Auth::user();

        $account = $user->account->makeHidden(['user_id', 'id']);
        $transactions = $account->transactions()->get()->makeHidden(['account_id']);
        $periodicTransactions = $account->periodicTransactions()->get()->makeHidden(['account_id']);
        $categories = $account->categories()->get()->makeHidden(['account_id']);
        $goals = $account->goals()->get()->makeHidden(['account_id']);

        $data = [
            'version' => '1.0',
            'exported_at' => now()->toISOString(),
            'transactions' => $transactions,
            'periodic_transactions' => $periodicTransactions,
            'categories' => $categories,
            'goals' => $goals,
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
        $account = $user->account;

        $content = file_get_contents($request->file('file')->getRealPath());
        $data = json_decode($content, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->toast('Invalid JSON file', 'error');

            return back();
        }

        if (($data['version'] ?? null) !== $this->VERSION) {
            $this->toast('Unsupported backup version', 'error');

            return back();
        }

        // Validate structure
        if (
            ! isset($data['transactions']) ||
            ! isset($data['periodic_transactions']) ||
            ! isset($data['categories']) ||
            ! isset($data['goals'])
        ) {
            $this->toast('Invalid backup structure', 'error');

            return back()->withErrors(['file' => 'Invalid backup structure']);
        }

        DB::transaction(function () use ($account, $data) {

            if ($account) {
                $account->goals()->delete();
                $account->transactions()->delete();
                $account->periodicTransactions()->delete();
                $account->categories()->delete();
            }

            // restore goals
            foreach ($data['goals'] as $g) {
                $this->restoreModel(Goal::class, $g, [
                    'account_id' => $account->id,
                ]);
            }

            // restore categories
            foreach ($data['categories'] as $c) {
                $this->restoreModel(Category::class, $c, [
                    'account_id' => $account->id,
                ]);
            }

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

        $this->toast('Data restored successfully');

        return back()->with('success', 'Data restored successfully');
    }

    public function delete()
    {
        $account = Auth::user()->account;

        if ($account) {
            DB::transaction(function () use ($account) {
                $account->goals()->delete();
                $account->transactions()->delete();
                $account->periodicTransactions()->delete();
                $account->categories()->delete();
                $account->delete();
            });
        }

        $this->toast('All data deleted successfully');

        return back();
    }

    private function restoreModel(string $modelClass, array $data, array $extra = []): mixed
    {
        $model = new $modelClass;
        $model->timestamps = false;

        $allowed = match ($modelClass) {
            Goal::class => ['value', 'period', 'status', 'starts_at', 'ends_at', 'type', 'created_at', 'updated_at'],
            Transaction::class => ['amount', 'category', 'description', 'created_at', 'updated_at'],
            PeriodicTransaction::class => [
                'amount', 'category', 'start_date', 'end_date', 'frequency',
                'description', 'is_active', 'next_apply_date',
                'created_at', 'updated_at',
            ],
            Category::class => ['value', 'type', 'created_at', 'updated_at'],
            default => throw new \Exception("Unsupported model: $modelClass"),
        };

        foreach ($data as $key => $value) {
            if (! in_array($key, $allowed)) {
                continue;
            }
            if (in_array($key, ['created_at', 'updated_at', 'starts_at', 'ends_at', 'start_date', 'end_date', 'next_apply_date']) && $value) {
                $model->$key = Carbon::parse($value)->format('Y-m-d H:i:s');

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

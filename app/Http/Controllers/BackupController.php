<?php

namespace App\Http\Controllers;

use App\Concerns\HasToast;
use App\Http\Requests\ImportRequest;
use App\Models\Account;
use App\Models\Category;
use App\Models\Debt;
use App\Models\Goal;
use App\Models\PeriodicTransaction;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BackupController extends Controller
{
    use HasToast;

    private const VERSION = '1.0';

    private const DATE_FIELDS = [
        'created_at',
        'updated_at',
        'starts_at',
        'ends_at',
        'start_date',
        'end_date',
        'next_apply_date',
    ];

    private const RESTORABLE_FIELDS = [
        Goal::class => ['value', 'period', 'status', 'starts_at', 'ends_at', 'type', 'created_at', 'updated_at'],
        Transaction::class => ['amount', 'category_id', 'description', 'created_at', 'updated_at'],
        PeriodicTransaction::class => ['amount', 'category_id', 'start_date', 'end_date', 'frequency', 'description', 'is_active', 'next_apply_date', 'created_at', 'updated_at'],
        Category::class => ['value', 'type', 'created_at', 'updated_at'],
        Debt::class => ['amount', 'description', 'paid_at', 'due_date', 'created_at', 'updated_at'],
    ];

    public function export()
    {
        $account = Auth::user()->account;

        $data = [
            'version' => self::VERSION,
            'exported_at' => now()->toISOString(),
            'transactions' => $account->transactions()->get()->makeHidden(['account_id', 'id']),
            'periodic_transactions' => $account->periodicTransactions()->get()->makeHidden(['account_id', 'id']),
            'categories' => $account->categories()->get()->makeHidden(['account_id']),
            'goals' => $account->goals()->get()->makeHidden(['account_id', 'id']),
            'debts' => $account->debts()->get()->makeHidden(['account_id', 'id']),
        ];

        $json = json_encode($data, JSON_PRETTY_PRINT);
        $filename = 'pocketpilot-backup-'.now()->format('Y-m-d_H-i').'.json';

        return response($json)
            ->header('Content-Type', 'application/json')
            ->header('Content-Disposition', 'attachment; filename="'.$filename.'"');
    }

    public function import(ImportRequest $request)
    {
        $account = Auth::user()->account;

        $data = json_decode($request->file('file')->get(), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->toast('Invalid JSON file', 'error');

            return back();
        }

        if (($data['version'] ?? null) !== self::VERSION) {
            $this->toast('Unsupported backup version', 'error');

            return back();
        }

        // Validate structure
        $required = ['transactions', 'periodic_transactions', 'categories', 'goals', 'debts'];

        foreach ($required as $key) {
            if (! array_key_exists($key, $data)) {
                $this->toast('Invalid backup structure', 'error');

                return back();
            }
        }

        DB::transaction(function () use ($account, $data) {

            $this->deleteAccountModules($account);

            $this->restoreCollection(Goal::class, $data['goals'], fn () => ['account_id' => $account->id]);
            $this->restoreCollection(Debt::class, $data['debts'], fn () => ['account_id' => $account->id]);

            $this->restoreCollection(Category::class, $data['categories'], fn ($category) => [
                'account_id' => $account->id,
                'id' => $category['id'],
            ]);

            // Preserve original IDs so transactions keep their category references.
            $this->restoreCollection(
                Transaction::class,
                $data['transactions'],
                fn ($transaction) => [
                    'account_id' => $account->id,
                    'category_id' => $transaction['category_id'],
                ]
            );

            $this->restoreCollection(
                PeriodicTransaction::class,
                $data['periodic_transactions'],
                fn ($transaction) => [
                    'account_id' => $account->id,
                    'category_id' => $transaction['category_id'],
                ]
            );

        });

        $this->toast('Data restored successfully');

        return back();
    }

    public function delete()
    {
        $account = Auth::user()->account;

        DB::transaction(function () use ($account) {
            $this->deleteAccountModules($account);
            $account->delete();
        });

        $this->toast('All data deleted successfully');

        return back();
    }

    private function deleteAccountModules(Account $account): void
    {
        $account->goals()->delete();
        $account->transactions()->delete();
        $account->periodicTransactions()->delete();
        $account->categories()->delete();
        $account->debts()->delete();
    }

    private function restoreModel(string $modelClass, array $data, array $extra = []): mixed
    {
        $model = new $modelClass;
        $model->timestamps = false;

        $allowed = self::RESTORABLE_FIELDS[$modelClass] ?? throw new \Exception("Unsupported model: {$modelClass}");

        foreach ($data as $key => $value) {
            if (! in_array($key, $allowed, true)) {
                continue;
            }

            if ($value && in_array($key, self::DATE_FIELDS, true)) {
                $value = Carbon::parse($value)->format('Y-m-d H:i:s');
            }

            $model->{$key} = $value;
        }

        foreach ($extra as $key => $value) {
            $model->$key = $value;
        }

        $model->save();

        return $model;
    }

    private function restoreCollection(string $model, array $items, callable $extra): void
    {
        foreach ($items as $item) {
            $this->restoreModel($model, $item, $extra($item));
        }
    }
}

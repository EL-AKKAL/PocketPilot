<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class BackupController extends Controller
{
    public function export()
    {
        $user = Auth::user();

        $account = $user->account->makeHidden(['user_id']);
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
}

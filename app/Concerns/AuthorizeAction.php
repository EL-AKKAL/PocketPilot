<?php

namespace App\Concerns;

use Illuminate\Support\Facades\Auth;

trait AuthorizeAction
{
    protected function authorizeAccountOwnership($model): void
    {
        abort_if($model->account_id !== Auth::user()->account->id, 403);
    }
}

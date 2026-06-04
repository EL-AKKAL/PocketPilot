<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

#[Fillable(['start_date', 'end_date', 'frequency', 'amount', 'description', 'category_id', 'account_id', 'is_active', 'next_apply_date'])]
class PeriodicTransaction extends Model
{
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function scopeMine($query)
    {
        return $query->whereHas('account', function ($q) {
            $q->where('user_id', Auth::id());
        });
    }
}

<?php

namespace App\Models;

use App\Enums\CategoryEnum;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['start_date', 'end_date', 'frequency', 'amount', 'description', 'category', 'account_id', 'is_active', 'next_apply_date'])]
class PeriodicTransaction extends Model
{
    protected function casts(): array
    {
        return [
            'category' => CategoryEnum::class,
        ];
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function scopeMine($query)
    {
        return $query->whereHas('account', function ($q) {
            $q->where('user_id', auth()->id());
        });
    }
}

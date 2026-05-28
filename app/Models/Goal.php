<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['value', 'period', 'status', 'starts_at', 'ends_at', 'type'])]
class Goal extends Model
{
    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}

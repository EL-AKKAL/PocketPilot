<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['account_id', 'value', 'description', 'type'])]
class Category extends Model
{
    protected $fillable = [
        'account_id',
        'value',
        'description',
        'type',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function periodicTransactions()
    {
        return $this->hasMany(PeriodicTransaction::class);
    }
}

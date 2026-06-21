<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name', 'starting_balance'])]
class Account extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function periodicTransactions()
    {
        return $this->hasMany(PeriodicTransaction::class);
    }

    public function goals()
    {
        return $this->hasMany(Goal::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function debts()
    {
        return $this->hasMany(Debt::class);
    }
}

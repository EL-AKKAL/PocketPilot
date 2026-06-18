<?php

namespace App\Models;

use App\Services\DataTable\Column;
use App\Services\DataTable\Table;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

#[Fillable(['account_id', 'value', 'type'])]
class Category extends Model
{
    protected $fillable = [
        'account_id',
        'value',
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

    public static function dataTable(): Table
    {
        $query = static::query()->whereBelongsTo(Auth::user()->account);

        return Table::make($query)
            ->columns([
                Column::make('id'),
                Column::make('value')->searchable(),
                Column::make('type')->filterable(),
                Column::make('created_at')->date(),
            ]);
    }
}

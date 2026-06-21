<?php

namespace App\Models;

use App\Services\DataTable\Column;
use App\Services\DataTable\Table;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

#[Fillable(['account_id', 'amount', 'description', 'paid_at', 'due_date'])]
class Debt extends Model
{
    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public static function dataTable(): Table
    {
        $query = static::query()->whereBelongsTo(Auth::user()->account);

        return Table::make($query)
            ->columns([
                Column::make('id'),
                Column::make('amount')->searchable(),
                Column::make('description')->searchable(),
                Column::make('paid_at')->date(),
                Column::make('due_date')->date(),
            ]);
    }
}

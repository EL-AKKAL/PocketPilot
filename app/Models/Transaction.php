<?php

namespace App\Models;

use App\Services\DataTable\Column;
use App\Services\DataTable\Table;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

#[Fillable(['amount', 'description', 'account_id', 'category_id'])]
class Transaction extends Model
{
    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeMine($query)
    {
        return $query->whereHas('account', function ($q) {
            $q->where('user_id', Auth::id());
        });
    }

    public static function dataTable(): Table
    {
        $query = static::query()->whereBelongsTo(Auth::user()->account);

        return Table::make($query)
            ->columns([
                Column::make('id'),
                Column::make('amount')->searchable(),
                Column::make('category'),
                Column::make('description')->searchable(),
                Column::make('created_at')->date(),
            ]);
    }
}

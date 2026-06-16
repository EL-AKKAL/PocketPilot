<?php

namespace App\Models;

use App\Enums\GoalStatusEnum;
use App\Services\DataTable\Column;
use App\Services\DataTable\Table;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

#[Fillable(['value', 'period', 'status', 'starts_at', 'ends_at', 'type'])]
class Goal extends Model
{
    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public static function dataTable(): Table
    {
        $query = static::query()->whereBelongsTo(Auth::user()->account)->where('status', '!=', GoalStatusEnum::IN_PROGRESS);

        return Table::make($query)
            ->columns([
                Column::make('id'),
                Column::make('value')->searchable(),
                Column::make('period'),
                Column::make('status'),
                Column::make('type'),
            ]);
    }
}

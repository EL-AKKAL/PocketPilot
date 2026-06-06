<?php

namespace App\Services\DataTable;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Database\Eloquent\Builder as BuilderContract;
use Illuminate\Support\Facades\DB;

class Filter
{
    const CONTAINS = 'contains';
    const IN = 'in';
    const EQUALS = 'equals';
    const BETWEEN = 'between';
    const DATE_BETWEEN = 'date_between';
    const TIME_BETWEEN = 'time_between';

    private $likeOperator = 'LIKE';

    public function __construct(public string $field, public ?string $value = null, public ?string $matchMode = self::CONTAINS)
    {
        $this->likeOperator = DB::connection()->getPDO()->getAttribute(\PDO::ATTR_DRIVER_NAME) == 'pgsql' ? 'ILIKE' : 'LIKE';
    }

    public function buildWhere(Builder | BuilderContract &$q)
    {
        if (!str_contains($this->field, '.')) {
            $this->applyWhere($q, $this->field);
            return;
        }

        $parts = explode('.', $this->field);
        $field = array_pop($parts);
        $relations = implode('.', $parts);

        $q->whereHas($relations, fn($subQuery) => $this->applyWhere($subQuery, $field));
    }

    private function applyWhere(Builder | BuilderContract &$q, string $field)
    {
        switch ($this->matchMode) {
            case self::IN:
                $q->whereIn($field, json_decode($this->value));
                break;

            case self::BETWEEN:
            case self::DATE_BETWEEN:
            case self::TIME_BETWEEN:
                $this->applyBetween($q, $field);
                break;

            case self::EQUALS:
                $q->where($field, $this->value);
                break;

            case self::CONTAINS:
            default:
                $q->where($field, $this->likeOperator, "%" . $this->value . "%");
                break;
        }
    }

    private function applyBetween(Builder | BuilderContract &$q, string $field)
    {
        $method = match ($this->matchMode) {
            self::BETWEEN => 'where',
            self::DATE_BETWEEN => 'whereDate',
            self::TIME_BETWEEN => 'whereTime',
        };;

        if (count($values = json_decode($this->value)) != 2) return;

        if (!empty($values[0]) && $formattedValue = $this->formatValue($values[0])) $q->$method($field, '>=', $formattedValue);
        if (!empty($values[1]) && $formattedValue = $this->formatValue($values[1])) $q->$method($field, '<=', $formattedValue);
    }

    private function formatValue($value)
    {
        if ($this->matchMode === self::DATE_BETWEEN) {
            try {
                return Carbon::parse($value)->format('Y-m-d');
            } catch (\Exception $e) {
                return null;
            }
        }

        if ($this->matchMode === self::TIME_BETWEEN) {
            try {
                return Carbon::parse($value)->format('H:i:s');
            } catch (\Exception $e) {
                return null;
            }
        }

        return $value;
    }
}

<?php

namespace App\Services\DataTable;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Database\Eloquent\Builder as BuilderContract;

class Column
{
    protected string $field;
    protected string $headerName;
    protected bool $sortable = false;
    protected bool $searchable = false;
    protected bool $exportable = false;
    protected ?Closure $customSearchQuery = null;
    protected ?Closure $customSortQuery = null;
    protected ?string $filterMatchMode = null;
    protected ?Closure $customFilterQuery = null;
    protected ?Closure $customFormat = null;
    protected ?Closure $customState = null;
    protected ?Closure $customExportQuery = null;

    public function __construct(string $field)
    {
        $this->field = $field;
    }

    public static function make(string $field): static
    {
        return new static($field);
    }

    public function sortable(bool|Closure $sortable = true): static
    {
        if ($sortable instanceof Closure) {
            $this->customSortQuery = $sortable;
            $this->sortable = true;
        } else {
            $this->sortable = $sortable;
        }
        return $this;
    }

    public function searchable(bool|Closure $searchable = true): static
    {
        if ($searchable instanceof Closure) {
            $this->customSearchQuery = $searchable;
            $this->searchable = true;
        } else {
            $this->searchable = $searchable;
        }
        return $this;
    }

    /**
     * @param string $headerName
     * @param Closure $exportableFn (state, record)
     */
    public function exportable(string $headerName, ?Closure $exportableFn = null): static
    {
        $this->headerName = $headerName;
        $this->exportable = true;
        if ($exportableFn instanceof Closure) {
            $this->customExportQuery = $exportableFn;
        }
        return $this;
    }

    public function getHeaderName()
    {
        return $this->headerName;
    }

    public function isExportable(): bool
    {
        return $this->exportable;
    }

    public function filterable(string | Closure $matchMode = 'contains'): static
    {
        if ($matchMode instanceof Closure) $this->customFilterQuery = $matchMode;
        else $this->filterMatchMode = $matchMode;
        return $this;
    }

    public function getField(): string
    {
        return $this->field;
    }

    // TODO: delete this method if not used
    public function format(Closure $callback)
    {
        $this->customState = $callback;
        return $this;
    }

    public function date(): static
    {
        $this->customFormat = function ($state) {
            return $state ? \Carbon\Carbon::parse($state)->format('d/m/Y') : null;
        };

        return $this;
    }

    public function getStateUsing(Closure $callback)
    {
        $this->customState = $callback;
        return $this;
    }

    /**
     * @param Closure $callback ($state, $record) => $formattedState
     *
     */
    public function formatStateUsing(Closure $callback)
    {
        $this->customFormat = $callback;
        return $this;
    }

    public function getState($record): mixed
    {
        if ($this->customState) {
            return call_user_func($this->customState, $record);
        }
        return $record->{$this->field};
    }

    public function getData($record, $forExport = false): mixed
    {
        $state = $this->getState($record);

        if ($forExport && $this->customExportQuery) {
            return call_user_func($this->customExportQuery, $state, $record);
        }

        if ($this->customFormat) {
            return call_user_func($this->customFormat, $state, $record);
        }

        return $state;
    }

    public function isSortable(): bool
    {
        return $this->sortable;
    }

    public function isSearchable(): bool
    {
        return $this->searchable;
    }

    public function applySearch(Builder | BuilderContract $query, string $search, bool $or = false): void
    {
        if ($this->customSearchQuery) {
            $method = $or ? 'orWhere' : 'where';
            $query->$method(function ($query) use ($search) {
                call_user_func($this->customSearchQuery, $query, $search);
            });
        } else {
            $method = $or ? 'orWhere' : 'where';
            $query->$method($this->field, 'LIKE', "%{$search}%");
        }
    }

    public function applySort(Builder | BuilderContract $query, string $direction): void
    {
        if ($this->customSortQuery) {
            call_user_func($this->customSortQuery, $query, $direction);
        } else {
            $query->orderBy($this->field, $direction);
        }
    }

    public function applyFilter(Builder | BuilderContract $query, $value): void
    {
        if ($this->customFilterQuery) {
            call_user_func($this->customFilterQuery, $query, $value);
            return;
        }

        $filter = new Filter($this->field, $value, $this->filterMatchMode);
        $filter->buildWhere($query);
    }
}

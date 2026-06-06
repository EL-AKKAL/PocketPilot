<?php

namespace App\Services\DataTable;

use App\Exports\Export;
use Closure;
use Illuminate\Contracts\Database\Eloquent\Builder as BuilderContract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;

class Table
{
    protected Builder|BuilderContract $query;

    protected Collection $columns;

    protected Request $request;

    protected string $sortField = 'created_at';

    protected string $sortOrder = 'desc';

    protected string $exportedFileName = 'file';

    public function __construct(Builder|BuilderContract $query)
    {
        $this->query = $query;
        $this->columns = collect([]);
        $this->request = request();
    }

    public function query(Closure $fn)
    {
        $fn($this->query);

        return $this;
    }

    public static function make(Builder|BuilderContract $query): static
    {
        return new static($query);
    }

    /**
     * @param  array<Column|string>  $columns
     */
    public function columns(array $columns): self
    {
        foreach ($columns as $column) {
            $this->column($column);
        }

        return $this;
    }

    public function column(Column|string $column): self
    {
        $column = is_string($column) ? Column::make($column) : $column;
        $this->columns->push($column);

        return $this;
    }

    public function exportedFileName($fileName)
    {
        $this->exportedFileName = $fileName;

        return $this;
    }

    private function getData($all = false)
    {
        $query = clone $this->query;

        $this->applyGlobalSearch($query)
            ->applyFilters($query)
            ->applySort($query);

        $data = $all ? $query->get() : $query->paginate($this->getPerPage(), ['*'], 'page', $this->getCurrentPage());

        return $all
            ? $data->map(fn ($record) => $this->formatRecord($record))
            : tap($data)->through(fn ($record) => $this->formatRecord($record));
    }

    // private function export($fileName = null)
    // {
    //     $export = new Export($this->getData(true)?->toArray(), $this->getExportHeaders());
    //     return Excel::download($export, "$fileName.xlsx", null, ['Access-Control-Expose-Headers' => 'Content-Disposition']);
    // }

    // private function getExportHeaders()
    // {
    //     return $this->columns
    //         ->filter(fn(Column $column) => $column->isExportable())
    //         ->map(fn(Column $column) => $column->getHeaderName())
    //         ->toArray();
    // }

    public function getResponse()
    {
        // return request('exportable') ? $this->export($this->exportedFileName) : $this->getData();
        return $this->getData();
    }

    protected function formatRecord($record): array
    {
        return $this->columns
            ->filter(fn (Column $column) => request('exportable') ? $column->isExportable() : true)
            ->mapWithKeys(fn (Column $column) => [
                $column->getField() => $column->getData($record, request('exportable')),
            ])
            ->toArray();
    }

    protected function applyGlobalSearch(Builder|BuilderContract $query): self
    {
        if ($search = $this->request->input('search')) {
            $query->where(function (Builder|BuilderContract $query) use ($search) {
                $this->columns
                    ->filter(fn (Column $column) => $column->isSearchable())
                    ->each(function (Column $column) use ($query, $search) {
                        $column->applySearch($query, $search, true);
                    });
            });
        }

        return $this;
    }

    protected function applyFilters(Builder|BuilderContract $query): self
    {
        $filters = $this->getFilterFields();

        foreach ($filters as $field => $filter) {
            if ($column = $this->columns->first(fn ($col) => $col->getField() === $field)) {
                $column->applyFilter($query, $filter ?? null);
            }
        }

        return $this;
    }

    public function defaultSort($sortField = 'created_at', $sortOrder = 'desc')
    {
        $this->sortField = $sortField;
        $this->sortOrder = $sortOrder;

        return $this;
    }

    protected function applySort(Builder|BuilderContract $query): self
    {
        $sortField = $this->request->input('sortField', $this->sortField);
        $sortOrder = $this->request->input('sortOrder', strtolower($this->sortOrder) === 'desc' ? -1 : 1);

        if ($sortField) {
            $column = $this->columns->first(fn ($col) => $col->getField() === $sortField);
            if ($column && $column->isSortable()) {
                $column->applySort($query, $sortOrder == 1 ? 'asc' : 'desc');
            } else {
                $query->orderBy($sortField, $sortOrder == 1 ? 'asc' : 'desc');
            }
        }

        return $this;
    }

    protected function getStart(): int
    {
        return ($this->getCurrentPage() - 1) * $this->getPerPage();
    }

    protected function getCurrentPage(): int
    {
        return (int) $this->request->input('page', 1);
    }

    protected function getPerPage(): int
    {
        $perPage = (int) $this->request->input('perPage', session('perPage', 10));
        session(['perPage' => $perPage]);

        return $perPage;
    }

    private function getFilterFields(): array
    {
        return collect(request()->query())->except([
            'page',
            'perPage',
            'sortField',
            'sortOrder',
            'search',
        ])->toArray();
    }
}

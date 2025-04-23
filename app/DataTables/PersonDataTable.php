<?php

namespace App\DataTables;

use App\Models\Person;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class PersonDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<Person> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('action', function ($person) {
                $btn = '<a href="' . route('persons.edit', $person->id) . '" class="btn btn-xs btn-warning" data-toggle="tooltip" title="Edit User" ><i class="fa fa-pen"></i></a> ';
                $btn .= '<form  action="' . route('persons.destroy', $person->id) . '" method="POST" class="d-inline" onsubmit="return confirmDelete()" >
                            ' . csrf_field() . '
                                ' . method_field("DELETE") . '
                            <button type="submit"  class="btn bg-danger btn-xs  dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700" onclick="return confirm(\'Do you need to delete this\');" data-toggle="tooltip" title="Delete">
                            <i class="fa fa-trash-alt"></i></button>
                            </form> </div>';
                return $btn;
            })
            ->rawColumns(['action']);

    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Person>
     */
    public function query(Person $model): QueryBuilder
    {
        return $model->with(['rank','regiment','unit']);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('person-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(1)
                    ->selectStyleSingle()
                    // ->dom('Bfrtip')
                    ->buttons([
                        Button::make('excel'),
                        Button::make('csv'),
                        Button::make('pdf'),
                        Button::make('print'),
                        Button::make('reset')
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')->title('#')->searchable(false)->orderColumn(false)->width(40),
            Column::make('service_no'),
            Column::make('eno'),
            Column::make('name'),
            Column::make('rank.name')->title('Rank'),
            Column::make('regiment.regiment')->title('Regiment'),
            Column::make('unit.unit')->title('Unit'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(110)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Person_' . date('YmdHis');
    }
}

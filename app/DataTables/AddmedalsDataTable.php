<?php

namespace App\DataTables;

use App\Models\Addmedal;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class AddmedalsDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<Addmedal> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
        ->addIndexColumn()
        ->addColumn('action', function ($addmedalsdatatable) {
            $btn = '<a href="'.route('addmedals.edit',$addmedalsdatatable->id).'" class="btn btn-xs btn-warning" data-toggle="tooltip" title="Edit User" ><i class="fa fa-pen"></i></a> ';
            $btn .= '<form  action="' . route('addmedals.destroy', $addmedalsdatatable->id) . '" method="POST" class="d-inline" onsubmit="return confirmDelete()" >
            ' . csrf_field() . '
                ' . method_field("DELETE") . '
            <button type="submit"  class="btn bg-danger btn-xs  dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700" onclick="return confirm(\'Do you need to delete this\');" data-toggle="tooltip" title="Delete">
            <i class="fa fa-trash-alt"></i></button>
            </form> </div>';
            $btn .= '<a href="'.route('addmedals.show', $addmedalsdatatable->id).'" class="btn btn-xs btn-info" data-toggle="tooltip" title="View User" ><i class="fa fa-eye"></i></a> ';
            return $btn;
        })
        ->rawColumns([ 'action']);
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Addmedal>
     */
    public function query(Addmedal $model): QueryBuilder
    {
        return $model->newQuery()->with([
            'person',
            'medal',
        //    'referance',
           
       ]);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('addmedals-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->buttons([
                        Button::make('excel'),
                        Button::make('csv'),
                        Button::make('pdf'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')->title('#')->searchable(false)->orderable(false)->width(5),
            Column::make('person.name')->title('Person')->data('person.name')->searchable(true),
            Column::make('medal.name')->title('Medal')->data('medal.name')->searchable(true),

            // Column::make('id'),
            Column::make('reference.referance')->title('Reference No')->data('reference.reference')->searchable(true),
            Column::make('rtype.name')->title('Referance Type')->data('rtype.name')->searchable(true),
            Column::make('date'),
            Column::make('file'),


            // Column::make('created_at'),
            // Column::make('updated_at'),
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(80)
                  ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'addmedals_' . date('YmdHis');
    }
}
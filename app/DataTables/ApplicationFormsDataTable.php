<?php

namespace App\DataTables;

use App\Models\ApplicationForm;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ApplicationFormsDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<ApplicationForm> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('file', function ($addmedalsdatatable) {
                return '<a href="' . asset('/storage/' . $addmedalsdatatable->file) . '" target="_blank"><i class="fa fa-download"></i></a>';
            })
            ->editColumn('medal.name', function ($row) {
                if ($row->medal) {
                    return '<span data-toggle="tooltip" title="' . e($row->medal->name) . '">' . e($row->medal->name) . '</span>';
                }
                return '';
            })
            ->addColumn('action', function ($application_form) {

                $btn = '<a href="' . route('application_forms.edit', $application_form->id) . '" class="btn btn-xs btn-warning" data-toggle="tooltip" title="Edit User" ><i class="fa fa-pen"></i></a> ';
                $btn .= '<form  action="' . route('application_forms.destroy', $application_form->id) . '" method="POST" class="d-inline" onsubmit="return confirmDelete()" >
            ' . csrf_field() . '
                ' . method_field("DELETE") . '
            <button type="submit"  class="btn bg-danger btn-xs  dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700" onclick="return confirm(\'Do you need to delete this\');" data-toggle="tooltip" title="Delete">
            <i class="fa fa-trash-alt"></i></button>
            </form> </div>';
                $btn .= '<a href="' . route('application_forms.show', $application_form->id) . '" class="btn btn-xs btn-info" data-toggle="tooltip" title="View User" ><i class="fa fa-eye"></i></a> ';
                return $btn;
            })
            ->rawColumns(['action', 'file', 'medal.name']);
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<ApplicationForm>
     */
    public function query(ApplicationForm $model): QueryBuilder
    {
        return $model->newQuery()->select('application_forms.*')->with(['medal']);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('application_forms-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1, 'asc')
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
            Column::make('medal.name')
                ->title('Medal')
                ->orderable(true)
                ->searchable(true),
            Column::make('file')
                ->title('Application Form')
                ->orderable(false),
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
        return 'ApplicationForms_' . date('YmdHis');
    }
}

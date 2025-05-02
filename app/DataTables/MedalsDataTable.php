<?php

namespace App\DataTables;

use App\Models\Medal;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class MedalsDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<Medal> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
        ->addIndexColumn()
        ->addColumn('image', function ($medalsdatatable) {
            if ($medalsdatatable->image) {
                $base64 = base64_encode($medalsdatatable->image);
                return '<img src="data:image/jpeg;base64,' . $base64 . '" width="50" />';
            }
        })
        ->editColumn('is_un', function ($row) {
            switch ($row->is_un) {
                case 0:
                     $badge = '<span class="badge badge-danger">Not UN</span>';
                     break;
                case 1:
                    $badge = '<span class="badge badge-warning">UN</span>';
                    break;


            }
            return $badge;
        })
        ->addColumn('action', function ($medalsdatatable) {
            $btn = '<a href="'.route('medals.edit',$medalsdatatable->id).'" class="btn btn-xs btn-warning" data-toggle="tooltip" title="Edit User" ><i class="fa fa-pen"></i></a> ';
            $btn .= '<form  action="' . route('medals.destroy', $medalsdatatable->id) . '" method="POST" class="d-inline" onsubmit="return confirmDelete()" >
            ' . csrf_field() . '
                ' . method_field("DELETE") . '
            <button type="submit"  class="btn bg-danger btn-xs  dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700" onclick="return confirm(\'Do you need to delete this\');" data-toggle="tooltip" title="Delete">
            <i class="fa fa-trash-alt"></i></button>
            </form> </div>';
            $btn .= '<a href="'.route('medals.show', $medalsdatatable->id).'" class="btn btn-xs btn-info" data-toggle="tooltip" title="View User" ><i class="fa fa-eye"></i></a> ';
            return $btn;
        })
        ->rawColumns(['action', 'image', 'is_un']);

    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Medal>
     */
    public function query(Medal $model): QueryBuilder
    {
        return $model->newQuery()->with('medal_type');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('medals-table')
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

            Column::make('name'),
            Column::make('description'),
            Column::make('medal_type.medal_type')->title('Medal Type'),
            Column::make('image')->title('Image'),
            Column::make('is_un')->title('UN Mission or Not'),
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
        return 'medals_' . date('YmdHis');
    }
}

<?php

namespace App\DataTables;

use App\Models\Addclasp;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class AddclaspsDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('action', function ($addclaspsdatatable) {
                $btn = '<a href="' . route('addclasps.edit', $addclaspsdatatable->id) . '" class="btn btn-xs btn-warning" data-toggle="tooltip" title="Edit" ><i class="fa fa-pen"></i></a> ';
                $btn .= '<form action="' . route('addclasps.destroy', $addclaspsdatatable->id) . '" method="POST" class="d-inline" onsubmit="return confirmDelete()" >
                    ' . csrf_field() . method_field("DELETE") . '
                    <button type="submit" class="btn bg-danger btn-xs" onclick="return confirm(\'Do you need to delete this\');" data-toggle="tooltip" title="Delete">
                    <i class="fa fa-trash-alt"></i></button>
                    </form>';
                $btn .= '<a href="' . route('addclasps.show', $addclaspsdatatable->id) . '" class="btn btn-xs btn-info" data-toggle="tooltip" title="View" ><i class="fa fa-eye"></i></a> ';
                return $btn;
            })
            ->addColumn('reference_no', function ($row) {
                return $row->clasp_profile->rtype->rtype . '-' . $row->clasp_profile->reference_no . '-' . $row->clasp_profile->date;
            })
            ->rawColumns(['action', 'file']);
    }

    public function query(Addclasp $model): QueryBuilder
    {
        return $model->newQuery()
            ->select('addclasps.*')
            ->with([
                'person',
                'medal',
                'clasp_profile',
                'rtype',
            ]);
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('addclasps-table')
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

    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')->title('#')->searchable(false)->orderable(false),
            Column::make('person.service_no')->title('Service No'),
            Column::make('person.name')->title('Name'),
            Column::computed('reference_no')->title('Reference No'),
            Column::make('medal.name')->title('Medal'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(80)
                ->addClass('text-center'),
        ];
    }

    protected function filename(): string
    {
        return 'Addclasps_' . date('YmdHis');
    }
}

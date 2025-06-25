<?php

namespace App\DataTables;

use App\Models\ClaspProfile;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ClaspProfileDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('file', function ($row) {
                return '<a href="' . asset('/storage/' . $row->file) . '" target="_blank"><i class="fa fa-download"></i></a>';
            })
            ->editColumn('medal.name', function ($row) {
                if ($row->medal) {
                    return '<span data-toggle="tooltip" title="' . e($row->medal->name) . '">' . e($row->medal->name) . '</span>';
                }
                return '';
            })
            ->editColumn('status', function ($row) {
                switch ($row->status) {
                    case config('const.MEDAL_PROFILE_STATUS_PENDING_VALUE'):
                        return '<span class="badge badge-warning">' . config('const.MEDAL_PROFILE_STATUS_PENDING_NAME') . '</span>';
                    case config('const.MEDAL_PROFILE_STATUS_ACTIVE_VALUE'):
                        return '<span class="badge badge-success">' . config('const.MEDAL_PROFILE_STATUS_ACTIVE_NAME') . '</span>';
                    case config('const.MEDAL_PROFILE_STATUS_CLOSE_VALUE'):
                        return '<span class="badge badge-secondary">' . config('const.MEDAL_PROFILE_STATUS_CLOSE_NAME') . '</span>';
                    default:
                        return '<span class="badge badge-warning">' . config('const.MEDAL_PROFILE_STATUS_PENDING_NAME') . '</span>';
                }
            })
            ->addColumn('action', function ($clasp_profile) {
                $btn = '';
                if ($clasp_profile->status == config('const.MEDAL_PROFILE_STATUS_PENDING_VALUE')) {
                    $btn = '<a href="' . route('clasp_profiles.activate', $clasp_profile->id) . '" class="btn btn-xs btn-success"><i class="fa fa-check"></i></a> ';
                }
                if ($clasp_profile->status == config('const.MEDAL_PROFILE_STATUS_ACTIVE_VALUE')) {
                    $btn = '<a href="' . route('clasp_profiles.close', $clasp_profile->id) . '" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></a> ';
                }
                $btn .= '<a href="' . route('clasp_profiles.edit', $clasp_profile->id) . '" class="btn btn-xs btn-warning"><i class="fa fa-pen"></i></a> ';
                $btn .= '<form action="' . route('clasp_profiles.destroy', $clasp_profile->id) . '" method="POST" class="d-inline">
                            ' . csrf_field() . method_field("DELETE") . '
                            <button type="submit" class="btn bg-danger btn-xs dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700" onclick="return confirm(\'Do you need to delete this\');" data-toggle="tooltip" title="Delete"><i class="fa fa-trash-alt"></i></button>
                        </form>';
                return $btn;
            })
            ->rawColumns(['action', 'file', 'medal.name', 'status']);
    }

    public function query(ClaspProfile $model): QueryBuilder
    {
        return $model->newQuery()->select('clasp_profiles.*')->with(['rtype', 'medal']);
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('clasp_profiles-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1)
            ->selectStyleSingle()
            ->buttons([
                Button::make('excel'),
                Button::make('csv'),
                Button::make('pdf'),
                Button::make('print'),
                Button::make('reset')
            ]);
    }

    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')->title('#')->searchable(false)->orderable(false)->width(40),
            Column::make('rtype.rtype')->title('Reference Type'),
            Column::make('reference_no')->title('Reference No'),
            Column::make('date')->title('Date'),
            Column::make('file')->title('File'),
            Column::make('status')->title('Status'),
            Column::make('medal.name')->title('Medal'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(110)
                ->addClass('text-center'),
        ];
    }

    protected function filename(): string
    {
        return 'ClaspProfile_' . date('YmdHis');
    }
}

<?php

namespace App\DataTables;

use App\Models\MedalProfile;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class MedalProfileDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<MedalProfile> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('file', function ($addmedalsdatatable) {
                return '<a href="'.asset('/storage/'.$addmedalsdatatable->file).'" target="_blank"><i class="fa fa-download"></i></a>';
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
                        $badge = '<span class="badge badge-warning">'.config('const.MEDAL_PROFILE_STATUS_PENDING_NAME').'</span>';
                        break;
                    case config('const.MEDAL_PROFILE_STATUS_ACTIVE_VALUE'):
                        $badge = '<span class="badge badge-success">'.config('const.MEDAL_PROFILE_STATUS_ACTIVE_NAME').'</span>';
                        break;
                    case config('const.MEDAL_PROFILE_STATUS_CLOSE_VALUE'):
                        $badge = '<span class="badge badge-secondary">'.config('const.MEDAL_PROFILE_STATUS_CLOSE_NAME').'</span>';
                        break;
                    default:
                        $badge = '<span class="badge badge-warning">'.config('const.MEDAL_PROFILE_STATUS_PENDING_NAME').'</span>';
                }
                return $badge;
            })
            ->addColumn('action', function ($medal_profile) {
                $btn = '';
                if ($medal_profile->status == config('const.MEDAL_PROFILE_STATUS_PENDING_VALUE')) {
                    $btn = '<a href="' . route('medal_profiles.activate', $medal_profile->id) . '" class="btn btn-xs btn-success" data-toggle="tooltip" title="Activate MedalProfile" ><i class="fa fa-check"></i></a> ';
                }
                if ($medal_profile->status == config('const.MEDAL_PROFILE_STATUS_ACTIVE_VALUE')) {
                    $btn = '<a href="' . route('medal_profiles.close', $medal_profile->id) . '" class="btn btn-xs btn-danger" data-toggle="tooltip" title="Close MedalProfile" ><i class="fa fa-times"></i></a> ';
                }
                $btn .= '<a href="' . route('medal_profiles.edit', $medal_profile->id) . '" class="btn btn-xs btn-warning" data-toggle="tooltip" title="Edit MedalProfile" ><i class="fa fa-pen"></i></a> ';
                $btn .= '<form  action="' . route('medal_profiles.destroy', $medal_profile->id) . '" method="POST" class="d-inline" onsubmit="return confirmDelete()" >
                            ' . csrf_field() . '
                                ' . method_field("DELETE") . '
                            <button type="submit"  class="btn bg-danger btn-xs  dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700" onclick="return confirm(\'Do you need to delete this\');" data-toggle="tooltip" title="Delete">
                            <i class="fa fa-trash-alt"></i></button>
                            </form> </div>';
                 $btn .= '<a href="'.route('medal_profiles.show', $medal_profile->id).'" class="btn btn-xs btn-info" data-toggle="tooltip" title="View User" ><i class="fa fa-eye"></i></a> ';

                return $btn;
            })
            ->rawColumns(['action', 'file', 'medal.name', 'status']);

    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<MedalProfile>
     */
    public function query(MedalProfile $model): QueryBuilder
    {
        return $model->newQuery()->select('medal_profiles.*')->with(['rtype', 'medal']);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('medal_profile-table')
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

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'MedalProfile_' . date('YmdHis');
    }
}

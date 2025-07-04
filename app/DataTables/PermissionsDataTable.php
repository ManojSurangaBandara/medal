<?php

namespace App\DataTables;

use App\Models\Permission;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class PermissionsDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<Permission> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
        ->addIndexColumn()

        // ->editColumn('created_at', function ($notification) {
        //     return Carbon::parse($notification->created_at)->format('Y-m-d H:i:s');
        // })
        // ->editColumn('updated_at', function ($notification) {
        //     return Carbon::parse($notification->updated_at)->format('Y-m-d H:i:s');
        // })

        ->addColumn('action', function ($permissionsdatatable) {
            $btn = '';
            // if(auth()->user()->can('edit_permissions')) {
            //     $btn = '<a href="'.route('permissions.edit',$permissionsdatatable->id).'" class="btn btn-xs btn-warning" data-toggle="tooltip" title="Edit User" ><i class="fa fa-pen"></i></a> ';
            // }
            // if(auth()->user()->can('delete_permissions')) {
            //     $btn .= '<form  action="' . route('permissions.destroy', $permissionsdatatable->id) . '" method="POST" class="d-inline" onsubmit="return confirmDelete()" >
            //                 ' . csrf_field() . '
            //                     ' . method_field("DELETE") . '
            //                 <button type="submit"  class="btn bg-danger btn-xs  dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700" onclick="return confirm(\'Do you need to delete this\');" data-toggle="tooltip" title="Delete">
            //                 <i class="fa fa-trash-alt"></i></button>
            //                 </form> </div>';
            // }
            if(auth()->user()->can('view_permissions')) {
                $btn .= '<a href="'.route('permissions.show', $permissionsdatatable->id).'" class="btn btn-xs btn-info" data-toggle="tooltip" title="View User" ><i class="fa fa-eye"></i></a> ';
            }
            return $btn;
        })
        ->rawColumns(['action']);
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Permission>
     */
    public function query(Permission $model): QueryBuilder
    {

        return $model->newQuery()->with([
            //  'permission',

        ]);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('users-table')
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
            // Column::make('id'),
            Column::make('name')->title('Name')->data('name')->searchable(true),
            Column::make('guard_name'),
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
        return 'Permissions_' . date('YmdHis');
    }
}

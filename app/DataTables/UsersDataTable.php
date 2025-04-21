<?php

namespace App\DataTables;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class UsersDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<User> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
        ->addIndexColumn()
        ->addColumn('active', function ($usersdatatable) {
            switch ($usersdatatable->active) {
                case 0:
                    return '<span class="badge badge-danger">In-Active</span>';
                    break;
                case 1:
                    return '<span class="badge badge-success">Active</span>';
                    break;
            }
        })
        ->addColumn('role.name', function ($user) {
            return '<span class="badge badge-primary">' . $user->role->name. '</span>';
        })
        // ->editColumn('created_at', function ($notification) {
        //     return Carbon::parse($notification->created_at)->format('Y-m-d H:i:s');
        // })
        // ->editColumn('updated_at', function ($notification) {
        //     return Carbon::parse($notification->updated_at)->format('Y-m-d H:i:s');
        // })

        ->addColumn('action', function ($usersdatatable) {
            $btn = '<a href="'.route('users.edit',$usersdatatable->id).'" class="btn btn-xs btn-warning" data-toggle="tooltip" title="Edit User" ><i class="fa fa-pen"></i></a> ';
            $btn .= '<form  action="' . route('users.destroy', $usersdatatable->id) . '" method="POST" class="d-inline" onsubmit="return confirmDelete()" >
                            ' . csrf_field() . '
                                ' . method_field("DELETE") . '
                            <button type="submit"  class="btn bg-danger btn-xs  dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700" onclick="return confirm(\'Do you need to delete this\');" data-toggle="tooltip" title="Delete">
                            <i class="fa fa-trash-alt"></i></button>
                            </form> </div>';
            $btn .= '<a href="'.route('users.show', $usersdatatable->id).'" class="btn btn-xs btn-info" data-toggle="tooltip" title="View User" ><i class="fa fa-eye"></i></a> ';
            return $btn;
        })
        ->rawColumns(['active', 'action','role.name']);
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<User>
     */
    public function query(User $model): QueryBuilder
    {
       
        return $model->newQuery()->with([
             'role',
             'ranks',
            'regiments',
            'units'
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
            Column::make('service_no')->title('Service No')->data('service_no')->searchable(true),
            Column::make('ranks.name')->title('Rank')->data('ranks.name')->searchable(true),
            Column::make('name')->title('Name')->data('name')->searchable(true),
            Column::make('email')->title('Email')->data('email')->searchable(true),
            Column::make('regiments.regiment')->title('Regiment')->data('regiments.regiment')->searchable(true),
            Column::make('units.unit')->title('Unit')->data('units.unit')->searchable(true),
            Column::make('role.name')->title('Role')->data('role.name')->searchable(true),
            Column::make('active')->title('Active')->data('active')->searchable(true),
           
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
        return 'Users_' . date('YmdHis');
    }
}

<?php

namespace App\Http\Controllers;
use App\DataTables\PermissionsDataTable;
use App\Models\Role;
use App\Models\Permission;


use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view_permissions')->only('index', 'show');
        $this->middleware('permission:create_permissions')->only('create', 'store');
        $this->middleware('permission:edit_permissions')->only('edit', 'update');
        $this->middleware('permission:delete_permissions')->only('destroy');

    }
    public function index(PermissionsDataTable $dataTable)
    {
        
        return $dataTable->render('permissions.index');
    }

    public function create()
    {
        return view('permissions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name',
        ]);
    
        Permission::create([
            'name' => $request->name,
            'guard_name' => 'web', 
        ]);

        return redirect()->route('permissions.index');
    }

    public function show(Permission $permission)
{
    return view('permissions.show', compact('permission'));
}

    public function edit(Permission $permission)
    {
        return view('permissions.edit', compact('permission'));
    }

    public function update(Request $request, Permission $permission)
    {
        $permission->update($request->all());
        return redirect()->route('permissions.index');
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();
        return redirect()->route('permissions.index');
    }
}

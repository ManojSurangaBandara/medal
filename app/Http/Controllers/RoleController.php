<?php

namespace App\Http\Controllers;
use Spatie\Permission\Models\Role;  // Import Location Model

use Spatie\Permission\Models\Permission;  // Import Location Model
use App\DataTables\RolesDataTable;
// use Illuminate\Support\Facades\Hash;



use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view_roles')->only('index', 'show');
        $this->middleware('permission:create_roles')->only('create', 'store');
        $this->middleware('permission:edit_roles')->only('edit', 'update');
        $this->middleware('permission:delete_roles')->only('destroy');

    }
   
    public function index(RolesDataTable $dataTable)
    {
        
        return $dataTable->render('roles.index');
    }

    
    public function create()
    {
        $permissions = Permission::get();
        return view('roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'permissions' => 'array|exists:permissions,id', // Ensure valid permissions are provided
        ]);
    
        // Create the role
        $role = Role::create(['name' => $request->name]);
    
        // Sync the permissions if provided
       
        $permissions = Permission::whereIn('id', $request->permissions)->get();
$role->syncPermissions($permissions);

            // $role->givePermissionTo($request->permissions);

        
    
        return redirect()->route('roles.index')->with('success', 'Role created successfully!');
    }

    public function show(Role $role)
    {
        $role->load('permissions'); // Eager load permissions
        return view('roles.show', compact('role'));
    }

    public function edit(Role $role)
    {
        $permissions = Permission::all();
        return view('roles.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'permissions' => 'array|exists:permissions,id', // Ensure valid permissions
        ]);
    
        // Find the role
        $role = Role::findOrFail($id);
    
        // Update the role name
        $role->name = $request->name;
        $role->save();
    
        // Sync the permissions (this will add/remove permissions as needed)
       
        $permissions = Permission::whereIn('id', $request->permissions)->get();
        $role->syncPermissions($permissions);
        
            // $role->givePermissionTo($request->permissions);

     

        return redirect()->route('roles.index')->with('success', 'Role updated successfully!');
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('roles.index');
    }
}

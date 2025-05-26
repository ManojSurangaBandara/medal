<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Regiment;  // Import Location Model
use App\Models\Role;
use App\Models\Rank;
use App\Models\Unit;
use App\DataTables\UsersDataTable;
use Illuminate\Support\Facades\Hash;



use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view_users')->only('index', 'show');
        $this->middleware('permission:create_users')->only('create', 'store');
        $this->middleware('permission:edit_users')->only('edit', 'update');
        $this->middleware('permission:delete_users')->only('destroy');

    }
   
    public function index(UsersDataTable $dataTable)
    {
        
        return $dataTable->render('users.index');
    }

    public function create()
    {
        $regiment = Regiment::all();
        $role = Role::all();
        $rank = Rank::all();
        $unit = Unit::all();

        return view('users.create', compact('regiment','role','rank','unit'));
        
    }

    public function store(Request $request)
    {
       
            
        $validated = $request->validate([
        'service_no' => 'required|string|max:255',
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:8',
        // 'role_id' => 'required|exists:roles,id', // Ensure the role_id exists in the roles table
        // 'location_id' => 'required|exists:locations,id', // Ensure the location_id exists in the locations table
        // 'rank_id' => 'required|exists:ranks,id', // Ensure the rank_id exists in the ranks table
        // 'unit_id' => 'required|exists:units,id', // Ensure the unit_id exists in the units table
            // 'service_no' => ['required', 'string'],
            // 'name' => 'required|string|max:255',
            // 'email' => 'required|string|max:255',
            'regiment_id' => ['required', 'numeric'],
            'rank_id' => ['required', 'numeric'],
            'unit_id' => ['required', 'numeric'],
            'password' => ['required', 'string', 'min:8'], // Optional field
            'role_id' => ['required'], // Validate role input
        ]);
    
        // Create a new customer with the validated data
        // User::create( $validated);
        $user = User::create($validated);

        $user->password = Hash::make($request->password);
        $user->active = 1;
        $user->save();

        $role = Role::findOrFail($request->input('role_id'));
        
        // Sync the roles for the user (in case role is updated)
        $user->syncRoles([$role->name]);
        $user->assignRole($role->name);
        

        return redirect()->route('users.index')->with('success', 'User created successfully!');
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }
    

    public function edit(User $user)
    {
        // $user = User::with('units','ranks','locations','roles')->find($id);
        $regiment = Regiment::all();
        $role = Role::all();
        $rank = Rank::all();
        $unit = Unit::all();
        return view('users.edit', compact('user','regiment','role','rank','unit'));
    }

    public function update(Request $request, User $user)
    {
        $user_detail = $request->validate([
            'service_no' => ['required', 'string'],
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'regiment_id' => ['required', 'numeric'],
            'rank_id' => ['required', 'numeric'],
            'unit_id' => ['required', 'numeric'],
            'password' => 'required|string|min:8', // Optional field
            'role_id' => ['required'], // Validate role input
        ]);

        // Find the user
        // $user = User::findOrFail($id);
        $user->update($user_detail);

        $role = Role::findOrFail($request->input('role_id'));
        
        // Sync the roles for the user (in case role is updated)
        $user->syncRoles([$role->name]);
        $user->assignRole($role->name);

        $user->syncPermissions($request->input('permissions'));

        // $user->update($request->all());
        return redirect()->route('users.index')->with('success', 'User updated successfully!');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully!');
    }

    
}

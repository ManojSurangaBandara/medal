<?php

namespace App\Http\Controllers;
use App\Models\Person;
use App\Models\Medal;  // Import Location Model
use App\Models\Rtype;  // Import Location Model

// use App\Models\Rank;
// use App\Models\Unit;
// use App\DataTables\PersonsDataTable;
// use Illuminate\Support\Facades\Hash;



use Illuminate\Http\Request;

class AddmedalController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('permission:view_users')->only('index', 'show');
    //     $this->middleware('permission:create_users')->only('create', 'store');
    //     $this->middleware('permission:edit_users')->only('edit', 'update');
    //     $this->middleware('permission:delete_users')->only('destroy');

    // }
   
    public function index()
    {
        
        // return $dataTable->render('users.index');
    }

    public function create()
    {
        // $regiment = Regiment::all();
     
        // $rank = Rank::all();
        $rtype = Rtype::all();
        $medal =Medal::all();

        return view('addmedals.create',compact('medal','rtype'));
        
    }

    public function store(Request $request)
    {
       
            
        $validated = $request->validate([
        'referance_type' => 'required',
        'referance_no' => 'required|string|max:255',
        'file' => 'required|file|pdf',
            'medal_id' => ['required', 'numeric'],
            
            
        ]);
    
        $addmedal = Addmedal::create($validated);


        return redirect()->route('addmedals.create');
    }

    public function show()
    {
        
    }
    

    public function edit()
    {
       
    }

    public function update()
    {
        
    }

    public function destroy()
    {
       
    }
}

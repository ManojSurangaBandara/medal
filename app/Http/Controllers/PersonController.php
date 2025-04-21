<?php

namespace App\Http\Controllers;
use App\Models\Person;
use App\Models\Regiment;  // Import Location Model

use App\Models\Rank;
use App\Models\Unit;
// use App\DataTables\PersonsDataTable;
// use Illuminate\Support\Facades\Hash;



use Illuminate\Http\Request;

class PersonController extends Controller
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
        $regiment = Regiment::all();
     
        $rank = Rank::all();
        $unit = Unit::all();

        return view('persons.create', compact('regiment','rank','unit'));
        
    }

    public function store(Request $request)
    {
       
            
        $validated = $request->validate([
        'service_no' => 'required|string|max:255',
        'e_no' => 'required|string|max:255',
        'name' => 'required|string|max:255',
            'regiment_id' => ['required', 'numeric'],
            'rank_id' => ['required', 'numeric'],
            'unit_id' => ['required', 'numeric'],
            'date_of_enlishment'=>'required|date',
            'date_of_commision'=>'required|date',
            
        ]);
    
        $person = Person::create($validated);


        return redirect()->route('persons.create');
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

<?php

namespace App\Http\Controllers;
use App\Models\Person;
use App\Models\Medal;  // Import Location Model
use App\Models\Rtype;
use App\Models\Referance;
use App\DataTables\AddmedalsDataTable;  // Import Location Model

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
   
    public function index(AddmedalsDataTable $dataTable)
    {
        
        return $dataTable->render('addmedals.index');
    }

    public function create()
    {
        // $regiment = Regiment::all();
     
        $person = Person::all();
        $rtype = Rtype::all();
        $medal =Medal::all();
        $referance = Referance::all();


        return view('addmedals.create',compact('medal','rtype','person','referance'));
        
    }

    public function store(Request $request)
    {
       
            
        $validated = $request->validate([
            'person_id' => ['required', 'numeric'],
        'rtype_id' => ['required', 'numeric'],
        'referance_id' => ['required', 'numeric'],
        'file' => 'required|file|pdf',
            'medal_id' => ['required', 'numeric'],
            'date' =>'date',
            
            
        ]);
    
        $addmedal = Addmedal::create($validated);


        return redirect()->route('addmedals.create');
    }

    public function show(Addmedal $addmedal)
    {
        return view('addmedals.show', compact('addmedal'));
    }
    

    public function edit(Addmedal $addmedal)
    {
       
        $person = Person::all();
        $rtype = Rtype::all();
        $medal =Medal::all();
        $referance = Referance::all();
        return view('addmedals.edit', compact('person','trype','medal','referance'));
    }

    public function update(Request $request, Addmedal $addmedal)
    {
        $user_detail = $request->validate([
            'person_id' =>  ['required', 'numeric'],
            'rtype_id' =>  ['required', 'numeric'],
            'referance_id' =>  ['required', 'numeric'],
            'file' => 'required|file|pdf',
                'medal_id' => ['required', 'numeric'],
                'date' =>'date',
        ]);

        $user->update($user_detail);

        
      
        return redirect()->route('addmedals.index');
    }

    public function destroy(Addmedal $addmedal)
    {
        $addmedal->delete();
        return redirect()->route('addmedals.index');
    }
}

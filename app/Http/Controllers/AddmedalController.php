<?php

namespace App\Http\Controllers;
use App\Models\Person;
use App\Models\Medal;  // Import Location Model
use App\Models\Rtype;
use App\Models\Reference;
use App\Models\Addmedal;

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

        $person = Person::all();
        $rtype = Rtype::all();
        $medal =Medal::all();
        $reference = Reference::all();


        return view('addmedals.create',compact('medal','rtype','person','reference'));

    }

    public function store(Request $request)
    {


        $validated = $request->validate([
            'person_id' => ['required', 'numeric'],
        'rtype_id' => ['required', 'numeric'],
        'reference_id' => ['required', 'numeric'],
            'file' => 'required|mimes:pdf',
            'medal_id' => ['required', 'numeric'],
            'date' => 'required|date'

        ]);

        $path = $request->file('file')->store('medal_reference_files', 'public'); // stores in storage/app/private/medal_reference_files
        $validated['file'] = $path; // save the stored path in DB
        $addmedal = Addmedal::create($validated);


        return redirect()->route('addmedals.index')->with('success', 'Addmedal created successfully.');
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
        $reference = Reference::all();
        return view('addmedals.edit', compact('person','rtype','medal','reference','addmedal'));
    }

    public function update(Request $request, Addmedal $addmedal)
    {
        $validated = $request->validate([
            'person_id' =>  ['required', 'numeric'],
            'rtype_id' =>  ['required', 'numeric'],
            'reference_id' =>  ['required', 'numeric'],
            'file' => 'required|mimes:pdf',
                'medal_id' => ['required', 'numeric'],
                'date' => 'required|date' ,
        ]);

        $addmedal->update($validated);



        return redirect()->route('addmedals.index')->with('success', 'Addmedal updated successfully.');
    }

    public function destroy(Addmedal $addmedal)
    {
        $addmedal->delete();
        return redirect()->route('addmedals.index')->with('success', 'Addmedal deleted successfully.');
    }
}

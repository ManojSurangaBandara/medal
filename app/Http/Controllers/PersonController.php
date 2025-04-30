<?php

namespace App\Http\Controllers;

use App\DataTables\PersonDataTable;
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

    public function index(PersonDataTable $dataTable)
    {
        return $dataTable->render('persons.index');
    }

    public function create()
    {
        $regiment = Regiment::all();
        $rank = Rank::all();
        $unit = Unit::all();

        return view('persons.create', compact('regiment', 'rank', 'unit'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_no' => 'required|string|max:255|unique:persons,service_no',
            'eno' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'rank_id' => 'required|numeric',
            'regiment_id' => 'required|numeric',
            'unit_id' => 'required|numeric',
            'doe' => 'required|date|before_or_equal:today',
        ], [
            'service_no.unique' => 'Person already added.',
        ]);

        $person = Person::create($validated);

        return redirect()->route('persons.index')->with('success', 'Person created successfully.');
    }

    public function show(Person $person)
    {
        return view('persons.show', compact('person'));
    }


    public function edit(Person $person)
    {
        $regiments = Regiment::all();
        $ranks = Rank::all();
        $units = Unit::all();

        return view('persons.edit', compact('regiments', 'ranks', 'units', 'person'));
    }

    public function update(Request $request, Person $person)
    {
        $validated = $request->validate([
            'service_no' => 'required|string|max:255',
            'eno' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'rank_id' => 'required|numeric',
            'regiment_id' => 'required|numeric',
            'unit_id' => 'required|numeric',
            'doe' => 'required|date|before_or_equal:today',

        ]);

        // $person = Person::findOrFail($id);
        $person->update($validated);

        return redirect()->route('persons.index')->with('success', 'Person updated successfully.');
    }

    public function destroy(Person $person)
    {
        $person->delete();
        return redirect()->route('persons.index')->with('success', 'Person deleted successfully.');
    }

    public function person_search_ajax(Request $request)
    {
        $query = $request->get('service_no');
        $persons = Person::where('service_no', 'LIKE', "{$query}%")->with(['rank', 'regiment'])
            ->get();

        return response()->json($persons);
    }
}

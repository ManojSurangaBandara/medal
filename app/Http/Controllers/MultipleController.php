<?php

namespace App\Http\Controllers;
use App\Models\Multiple;
// use App\Models\Regiment;  // Import Location Model

// use App\Models\Rank;
// use App\Models\Unit;
// use App\DataTables\PersonsDataTable;
// use Illuminate\Support\Facades\Hash;



use Illuminate\Http\Request;

class MultipleController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('permission:view_multiples')->only('index', 'show');
    //     $this->middleware('permission:create_multiples')->only('create', 'store');
    //     $this->middleware('permission:edit_multiples')->only('edit', 'update');
    //     $this->middleware('permission:delete_multiples')->only('destroy');

    // }

    public function index()
    {

        // return $dataTable->render('users.index');
    }

    public function create()
    {


        return view('multiples.create');

    }

    public function store(Request $request)
    {


        $validated = $request->validate([
        'year' => 'required',
        'issue_date' => 'required',
        'remarks' => 'required|string',
            'country' => 'string',
            'from' => 'date',
            'to' => 'date',
            'deseases_date' => 'date',
            'location' => 'string',
            'description' => 'string',
            'date_of_hospitalize'=>'date',
            'hospitalize_duration'=>'date',

        ]);

        $multiple = Multiple::create($validated);


        return redirect()->route('multiples.create')->with('success', 'Multiple created successfully.');
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

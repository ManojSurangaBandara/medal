<?php

namespace App\Http\Controllers;
use App\Models\Unit;
use App\Models\Regiment;
use App\DataTables\UnitsDataTable;

use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view_units')->only('index', 'show');
        $this->middleware('permission:create_units')->only('create', 'store');
        $this->middleware('permission:edit_units')->only('edit', 'update');
        $this->middleware('permission:delete_units')->only('destroy');

    }
    // public function index()
    // {
    //     $units = Unit::all();
    //     return view('units.index', compact('units'));
    // }
    public function index(UnitsDataTable $dataTable)
    {
        
        return $dataTable->render('units.index');
    }

    public function create()
    {
        $regiment = Regiment::all();
        return view('units.create',compact('regiment'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            
            'unit' => 'required|string|max:255',
            'regiment_id' => ['required', 'numeric'],
               
            ]);
        
           
            $unit = Unit::create($validated);
    

        // Unit::create($request->all());
        return redirect()->route('units.index');
    }

    public function show(Unit $unit)
{
    return view('units.show', compact('unit'));
}

    public function edit(Unit $unit)
    {
        $regiment = Regiment::all();

        return view('units.edit', compact('unit','regiment'));
    }

    public function update(Request $request, Unit $unit)
    {
        $user_detail = $request->validate([
            
            'unit' => 'required|string|max:255',
            'regiment_id' => ['required', 'numeric'],
           
        ]);

        $unit->update($user_detail);
        // $unit->update($request->all());
        return redirect()->route('units.index');
    }

    public function destroy(Unit $unit)
    {
        $unit->delete();
        return redirect()->route('units.index');
    }
}

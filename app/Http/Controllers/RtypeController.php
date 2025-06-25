<?php

namespace App\Http\Controllers;
use App\Models\Person;
use App\Models\Rtype;

use App\DataTables\RtypesDataTable;

use Illuminate\Http\Request;

class RtypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view_rtypes')->only('index', 'show');
        $this->middleware('permission:create_rtypes')->only('create', 'store');
        $this->middleware('permission:edit_rtypes')->only('edit', 'update');
        $this->middleware('permission:delete_rtypes')->only('destroy');

    }
    // public function index()
    // {
    //     $units = Unit::all();
    //     return view('units.index', compact('units'));
    // }
    public function index(RtypesDataTable $dataTable)
    {

        return $dataTable->render('rtypes.index');
    }

    public function create()
    {

        return view('rtypes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([

            'rtype' => 'required|string|max:255',


            ]);


            $rtype = Rtype::create($validated);


        // Unit::create($request->all());
        return redirect()->route('rtypes.index')->with('success', 'Rtype created successfully!');
    }

    public function show(Rtype $rtype)
{
    return view('rtypes.show', compact('rtype'));
}

    public function edit(Rtype $rtype)
    {

        return view('rtypes.edit', compact('rtype'));
    }

    public function update(Request $request, Rtype $rtype)
    {
        $user_detail = $request->validate([

            'rtype' => 'required|string|max:255',


        ]);

        $rtype->update($user_detail);
        // $unit->update($request->all());
        return redirect()->route('rtypes.index')->with('success', 'Rtype updated successfully!');
    }

    public function destroy(Rtype $rtype)
    {

        if ($rtype->medal_profiles()->exists() || $rtype->clasp_profiles()->exists()) {
            return redirect()->route('rtypes.index')->with('error', 'Cannot delete reference type. It is used in medal profiles or clasp profiles.');
        }

        $rtype->delete();
        return redirect()->route('rtypes.index')->with('success', 'Reference Type deleted successfully!');
    }
}

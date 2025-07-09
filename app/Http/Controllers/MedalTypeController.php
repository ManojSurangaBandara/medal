<?php

namespace App\Http\Controllers;

use App\DataTables\MedalTypeDataTable;
use Illuminate\Http\Request;
use App\Models\MedalType;

class MedalTypeController extends Controller
{
     public function __construct()
    {
        $this->middleware('permission:view_medal_types')->only('index', 'show');
        $this->middleware('permission:create_medal_types')->only('create', 'store');
        $this->middleware('permission:edit_medal_types')->only('edit', 'update');
        $this->middleware('permission:delete_medal_types')->only('destroy');

    }
   
    /**
     * Display a listing of the resource.
     */
    public function index(MedalTypeDataTable $dataTable)
    {
        return $dataTable->render('medal_types.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('medal_types.create');
    }

    public function store(Request $request)
    {
        MedalType::create($request->all());
        return redirect()->route('medal_types.index');
    }

    public function show(MedalType $medal_type)
    {
        return view('medal_types.show', compact('medal_type'));
    }

    public function edit(MedalType $medal_type)
    {
        return view('medal_types.edit', compact('medal_type'));
    }

    public function update(Request $request, MedalType $medal_type)
    {
        $medal_type->update($request->all());
        return redirect()->route('medal_types.index');
    }

    public function destroy(MedalType $medal_type)
    {
        $medal_type->delete();
        return redirect()->route('medal_types.index');
    }
}

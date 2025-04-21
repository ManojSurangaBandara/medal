<?php

namespace App\Http\Controllers;
use App\Models\Regiment;
use App\DataTables\RegimentsDataTable;

use Illuminate\Http\Request;

class RegimentController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view_regiments')->only('index', 'show');
        $this->middleware('permission:create_regiments')->only('create', 'store');
        $this->middleware('permission:edit_regiments')->only('edit', 'update');
        $this->middleware('permission:delete_regiments')->only('destroy');

    }
  
    public function index(RegimentsDataTable $dataTable)
    {
        
        return $dataTable->render('regiments.index');
    }

    public function create()
    {
        return view('regiments.create');
    }

    public function store(Request $request)
    {
        Regiment::create($request->all());
        return redirect()->route('regiments.index');
    }

    public function show(Regiment $regiment)
{
    return view('regiments.show', compact('regiment'));
}

    public function edit(Regiment $regiment)
    {
        return view('regiments.edit', compact('regiment'));
    }

    public function update(Request $request, Regiment $regiment)
    {
        $regiment->update($request->all());
        return redirect()->route('regiments.index');
    }

    public function destroy(Regiment $regiment)
    {
        $regiment->delete();
        return redirect()->route('regiments.index');
    }
}

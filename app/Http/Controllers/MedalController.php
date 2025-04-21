<?php

namespace App\Http\Controllers;
use App\Models\Medal;
use App\DataTables\MedalsDataTable;

use Illuminate\Http\Request;

class MedalController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view_medals')->only('index', 'show');
        $this->middleware('permission:create_medals')->only('create', 'store');
        $this->middleware('permission:edit_medals')->only('edit', 'update');
        $this->middleware('permission:delete_medals')->only('destroy');

    }
   
    public function index(MedalsDataTable $dataTable)
    {
        
        return $dataTable->render('medals.index');
    }

    public function create()
    {
        return view('medals.create');
    }

    public function store(Request $request)
    {
        Medal::create($request->all());
        return redirect()->route('medals.index');
    }

    public function show(Medal $medal)
{
    return view('medals.show', compact('medal'));
}

    public function edit(Medal $medal)
    {
        return view('medals.edit', compact('medal'));
    }

    public function update(Request $request, Medal $medal)
    {
        $medal->update($request->all());
        return redirect()->route('medals.index');
    }

    public function destroy(Medal $medal)
    {
        $medal->delete();
        return redirect()->route('medals.index');
    }
}

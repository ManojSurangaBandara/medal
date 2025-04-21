<?php

namespace App\Http\Controllers;
use App\Models\Rank;
use App\DataTables\RanksDataTable;

use Illuminate\Http\Request;

class RankController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view_ranks')->only('index', 'show');
        $this->middleware('permission:create_ranks')->only('create', 'store');
        $this->middleware('permission:edit_ranks')->only('edit', 'update');
        $this->middleware('permission:delete_ranks')->only('destroy');

    }
   
    public function index(RanksDataTable $dataTable)
    {
        
        return $dataTable->render('ranks.index');
    }

    public function create()
    {
        return view('ranks.create');
    }

    public function store(Request $request)
    {
        Rank::create($request->all());
        return redirect()->route('ranks.index');
    }

    public function show(Rank $rank)
{
    return view('ranks.show', compact('rank'));
}

    public function edit(Rank $rank)
    {
        return view('ranks.edit', compact('rank'));
    }

    public function update(Request $request, Rank $rank)
    {
        $rank->update($request->all());
        return redirect()->route('ranks.index');
    }

    public function destroy(Rank $rank)
    {
        $rank->delete();
        return redirect()->route('ranks.index');
    }
}

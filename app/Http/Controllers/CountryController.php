<?php

namespace App\Http\Controllers;
use App\Models\Country;
use App\DataTables\CountriesDataTable;

use Illuminate\Http\Request;

class CountryController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('permission:view_medals')->only('index', 'show');
    //     $this->middleware('permission:create_medals')->only('create', 'store');
    //     $this->middleware('permission:edit_medals')->only('edit', 'update');
    //     $this->middleware('permission:delete_medals')->only('destroy');

    // }
   
    public function index(CountriesDataTable $dataTable)
    {
        
        return $dataTable->render('countries.index');
    }

    public function create()
    {
        return view('countries.create');
    }

    public function store(Request $request)
    {
        Country::create($request->all());
        return redirect()->route('countries.index')->with('success', 'Country created successfully.');
    }

    public function show(Country $country)
{
    return view('countries.show', compact('country'));
}

    public function edit(Country $country)
    {
        return view('countries.edit', compact('country'));
    }

    public function update(Request $request, Country $country)
    {
        $country->update($request->all());
        return redirect()->route('countries.index')->with('success', 'Country updated successfully.');
    }

    public function destroy(Country $country)

    {
        $country->delete();
        return redirect()->route('countries.index')->with('success', 'Country deleted successfully.');
    }
}








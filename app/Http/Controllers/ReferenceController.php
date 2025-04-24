<?php

namespace App\Http\Controllers;
use App\DataTables\ReferenceDatatable;
use App\Models\Reference;

use Illuminate\Http\Request;

class ReferenceController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function index(ReferenceDatatable $dataTable)
     {
         return $dataTable->render('references.index');
     }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('references.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'reference' => 'required|string|unique:references,reference',
        ]);

        $reference = Reference::create($validated);

        return redirect()->route('references.index')->with('success', 'Reference created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $reference = Reference::findOrFail($id);
        return view('references.edit', compact('reference'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'reference' => 'required|string|unique:references,reference,',
        ]);

        $reference = Reference::findOrFail($id);
        $reference->update($validated);

        return redirect()->route('references.index')->with('success', 'Reference updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $reference = Reference::findOrFail($id);
        $reference->delete();

        return redirect()->route('references.index')->with('success', 'Reference deleted successfully.');
    }
}

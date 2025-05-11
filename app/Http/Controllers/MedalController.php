<?php

namespace App\Http\Controllers;

use App\Models\Medal;
use App\DataTables\MedalsDataTable;
use App\Models\MedalType;
use Illuminate\Support\Facades\Storage;


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
        $medal_types = MedalType::all();
        return view('medals.create', compact('medal_types'));
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'medal_type_id' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg', // Fixed typo to 'image'
            'is_un' => 'required|in:0,1',
        ]);

        if ($request->hasFile('image')) {
            $imageContent = file_get_contents($request->file('image')->getRealPath());
            $validated['image'] = $imageContent;
        } else {
            // If no file is uploaded
            unset($validated['image']);
        }

        Medal::create($validated);

        return redirect()->route('medals.index')->with('success', 'Medal created successfully.');
    }

    public function show(Medal $medal)
    {
        return view('medals.show', compact('medal'));
    }

    public function edit(Medal $medal)
    {
        $medal_types = MedalType::all();
        return view('medals.edit', compact('medal', 'medal_types'));
    }

    public function update(Request $request, Medal $medal)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'medal_type_id' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_un' => 'required|boolean',
        ]);

        if ($request->hasFile('image')) {
            $imageContent = file_get_contents($request->file('image')->getRealPath());
            $validated['image'] = $imageContent;
        } else {
            // If no new file is uploaded, keep the existing file path
            unset($validated['image']);
        }

        // Update the medal with the validated data
        $medal->update($validated);

        return redirect()->route('medals.index')->with('success', 'Medal updated successfully.');
    }

    public function destroy(Medal $medal)
    {
        // Delete the image from storage if it exists
        if ($medal->image && Storage::exists('public/' . $medal->image)) {
            Storage::delete('public/' . $medal->image);
        }

        // Delete the medal record
        $medal->delete();

        return redirect()->route('medals.index')->with('success', 'Medal deleted successfully.');
    }

}

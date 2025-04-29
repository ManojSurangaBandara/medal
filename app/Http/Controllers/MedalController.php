<?php

namespace App\Http\Controllers;
use App\Models\Medal;
use App\DataTables\MedalsDataTable;
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
        return view('medals.create');
    }

    public function store(Request $request)
    {
        // Validate the input fields
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Fixed typo to 'image'
            'is_un' => 'required|boolean',
        ]);
        
         // Handle image upload if exists
         $path = $request->file('image')->store('medal_images', 'public'); // stores in storage/app/private/medal_reference_files
         $validated['image'] = $path; 
        // Create a new medal record
        Medal::create($validated);

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

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Fixed typo to 'image'
            'is_un' => 'required|boolean',
        ]);
        
        // Handle image upload if exists
        $path = $request->file('image')->store('medal_images', 'public'); // stores in storage/app/private/medal_reference_files
        $validated['image'] = $path; 
        

        // Update the medal with the validated data
        $medal->update($validated);

        return redirect()->route('medals.index');
    }

    public function destroy(Medal $medal)
    {
        // Delete the image from storage if it exists
        if ($medal->image && Storage::exists('public/' . $medal->image)) {
            Storage::delete('public/' . $medal->image);
        }

        // Delete the medal record
        $medal->delete();
        
        return redirect()->route('medals.index');
    }
        // $medal->delete();
        // return redirect()->route('medals.index');
    }


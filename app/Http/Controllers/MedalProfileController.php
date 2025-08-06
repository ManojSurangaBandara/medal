<?php

namespace App\Http\Controllers;
use App\DataTables\MedalProfileDataTable;
use App\Models\MedalProfile;
use App\Models\Medal;
use App\Models\Rtype;

use Illuminate\Http\Request;

class MedalProfileController extends Controller
{
    //     public function __construct()
    // {
    //     $this->middleware('permission:view_medal_profiles')->only('index', 'show');
    //     $this->middleware('permission:create_medal_profiles')->only('create', 'store');
    //     $this->middleware('permission:edit_medal_profiles')->only('edit', 'update');
    //     $this->middleware('permission:delete_medal_profiles')->only('destroy');

    // }

    /**
     * Display a listing of the resource.
     */

     public function index(MedalProfileDataTable $dataTable)
     {
         return $dataTable->render('medal_profiles.index');
     }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $rtypes = Rtype::all();
        $medals = Medal::all();

        return view('medal_profiles.create', compact('rtypes', 'medals'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'reference_no' => 'required|string',
            'rtype_id' => 'required|exists:rtypes,id',
            'date' => 'required|date',
            'file' => 'required|file|mimes:pdf',
            'medal_id' => 'required|exists:medals,id',
        ]);

        $path = $request->file('file')->store('medal_reference_files', 'public'); // stores in storage/app/private/medal_reference_files
        $validated['file'] = $path; // save the stored path in DB

        $validated['status'] = config('const.MEDAL_PROFILE_STATUS_PENDING_VALUE'); // initial status

        $medal_profile = MedalProfile::create($validated);

        return redirect()->route('medal_profiles.index')->with('success', 'Medal Profile created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(MedalProfile $medal_profile)
    {
        return view('medal_profiles.show', compact('medal_profile'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $medal_profile = MedalProfile::findOrFail($id);
        $rtypes = Rtype::all();
        $medals = Medal::all();

        return view('medal_profiles.edit', compact('medal_profile', 'rtypes', 'medals'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'reference_no' => 'required|string',
            'rtype_id' => 'required|exists:rtypes,id',
            'date' => 'required|date',
            'file' => 'file|mimes:pdf',
            'medal_id' => 'required|exists:medals,id',
        ]);

        if($request->hasFile('file')) {
            // If a new file is uploaded, store it and update the path
            $path = $request->file('file')->store('medal_reference_files', 'public'); // stores in storage/app/private/medal_reference_files
            $validated['file'] = $path; // save the stored path in DB
        } else {
            // If no new file is uploaded, keep the existing file path
            unset($validated['file']);
        }

        $medal_profile = MedalProfile::findOrFail($id);
        $medal_profile->update($validated);

        return redirect()->route('medal_profiles.index')->with('success', 'Medal Profile updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $medal_profile = MedalProfile::findOrFail($id);

        if($medal_profile->add_medals()->exists()){
            return redirect()->route('medal_profiles.index')->with('error', 'Cannot delete this medal profile as it is associated with persons');
        }

        $medal_profile->delete();

        return redirect()->route('medal_profiles.index')->with('success', 'Medal Profile deleted successfully.');
    }

    public function activate_medal_profile(string $id)
    {
        $medal_profile = MedalProfile::findOrFail($id);
        $medal_profile->status = config('const.MEDAL_PROFILE_STATUS_ACTIVE_VALUE');
        $medal_profile->save();

        return redirect()->route('medal_profiles.index')->with('success', 'Medal Profile activated successfully.');
    }

    public function close_medal_profile(string $id)
    {
        $medal_profile = MedalProfile::findOrFail($id);
        $medal_profile->status = config('const.MEDAL_PROFILE_STATUS_CLOSE_VALUE');
        $medal_profile->save();

        return redirect()->route('medal_profiles.index')->with('success', 'Medal Profile closed successfully.');
    }



}

<?php

namespace App\Http\Controllers;

use App\DataTables\ClaspProfileDataTable;
use App\Models\ClaspProfile;
use App\Models\Medal;
use App\Models\Rtype;
use Illuminate\Http\Request;

class ClaspProfileController extends Controller
{

    //  public function __construct()
    // {
    //     $this->middleware('permission:view_clasp_profiles')->only('index', 'show');
    //     $this->middleware('permission:create_clasp_profiles')->only('create', 'store');
    //     $this->middleware('permission:edit_clasp_profiles')->only('edit', 'update');
    //     $this->middleware('permission:delete_clasp_profiles')->only('destroy');

    // }

    public function index(ClaspProfileDataTable $dataTable)
    {
        return $dataTable->render('clasp_profiles.index');
    }

    public function create()
    {
        $rtypes = Rtype::all();
        $medals = Medal::all();
        return view('clasp_profiles.create', compact('rtypes', 'medals'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'reference_no' => 'required|string',
            'rtype_id' => 'required|exists:rtypes,id',
            'date' => 'required|date',
            'file' => 'required|file|mimes:pdf',
            'medal_id' => 'required|exists:medals,id',
        ]);

        $path = $request->file('file')->store('clasp_reference_files', 'public');
        $validated['file'] = $path;
        $validated['status'] = config('const.MEDAL_PROFILE_STATUS_PENDING_VALUE');

        ClaspProfile::create($validated);
        return redirect()->route('clasp_profiles.index')->with('success', 'Clasp Profile created successfully.');
    }

    public function show(ClaspProfile $clasp_profile)
    {
        return view('clasp_profiles.show', compact('clasp_profile'));
    }

    public function edit(string $id)
    {
        $clasp_profile = ClaspProfile::findOrFail($id);
        $rtypes = Rtype::all();
        $medals = Medal::all();
        return view('clasp_profiles.edit', compact('clasp_profile', 'rtypes', 'medals'));
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'reference_no' => 'required|string',
            'rtype_id' => 'required|exists:rtypes,id',
            'date' => 'required|date',
            'file' => 'file|mimes:pdf',
            'medal_id' => 'required|exists:medals,id',
        ]);

        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('clasp_reference_files', 'public');
            $validated['file'] = $path;
        } else {
            unset($validated['file']);
        }

        $clasp_profile = ClaspProfile::findOrFail($id);
        $clasp_profile->update($validated);

        return redirect()->route('clasp_profiles.index')->with('success', 'Clasp Profile updated successfully.');
    }

    public function destroy(string $id)
    {
        $clasp_profile = ClaspProfile::findOrFail($id);
        if($clasp_profile->add_clasps()->exists()){
            return redirect()->route('clasp_profiles.index')->with('error', 'Cannot delete this clasp profile as it is associated with persons');
        }
        $clasp_profile->delete();
        return redirect()->route('clasp_profiles.index')->with('success', 'Clasp Profile deleted successfully.');
    }

    public function activate_clasp_profile(string $id)
    {
        $clasp_profile = ClaspProfile::findOrFail($id);
        $clasp_profile->status = config('const.MEDAL_PROFILE_STATUS_ACTIVE_VALUE');
        $clasp_profile->save();
        return redirect()->route('clasp_profiles.index')->with('success', 'Clasp Profile activated successfully.');
    }

    public function close_clasp_profile(string $id)
    {
        $clasp_profile = ClaspProfile::findOrFail($id);
        $clasp_profile->status = config('const.MEDAL_PROFILE_STATUS_CLOSE_VALUE');
        $clasp_profile->save();
        return redirect()->route('clasp_profiles.index')->with('success', 'Clasp Profile closed successfully.');
    }
}

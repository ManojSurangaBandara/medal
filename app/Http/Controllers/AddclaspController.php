<?php

namespace App\Http\Controllers;

use App\DataTables\AddclaspsDataTable;
use App\Models\Addclasp;
use App\Models\Person;
use App\Models\ClaspProfile;
use App\Models\Regiment;
use App\Models\Country;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\AddClaspImport;
use Maatwebsite\Excel\HeadingRowImport;

class AddclaspController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view_addclasps')->only('index', 'show');
        $this->middleware('permission:create_addclasps')->only('create', 'store');
        $this->middleware('permission:edit_addclasps')->only('edit', 'update');
        $this->middleware('permission:delete_addclasps')->only('destroy');

    }

    public function index(AddclaspsDataTable $dataTable)
    {
        return $dataTable->render('addclasps.index');
    }

    public function create()
    {
        $clasp_profiles = ClaspProfile::where('status', config('const.MEDAL_PROFILE_STATUS_ACTIVE_VALUE'))->get();
        $countries = Country::all();
        return view('addclasps.create', compact('clasp_profiles', 'countries'));
    }


    public function store(Request $request)
    {

        $validated = $request->validate([
            'person_id' => ['required', 'numeric'],
            'clasp_profile_id' => ['required', 'numeric'],
            'country_id' => ['nullable', 'numeric'],
            'from' => ['nullable', 'date'],
            'to' => ['nullable', 'date'],
        ]);

        // Check for existing clasp assignment
        $existingClasp = Addclasp::where('person_id', $validated['person_id'])
            ->where('clasp_profile_id', $validated['clasp_profile_id'])
            ->first();

        if ($existingClasp) {
            return redirect()->back()->with('error', 'This clasp profile has already been assigned to this person.');
        }

        $person = Person::find($validated['person_id']);
        $clasp_profile = ClaspProfile::find($validated['clasp_profile_id']);

        if (!$person || !$clasp_profile) {
            return back()->with('error', 'Invalid person or clasp profile.');
        }

        $validated['medal_id'] = $clasp_profile->medal->id ?? null;
        $validated['rtype_id'] = $clasp_profile->rtype->id ?? null;
        $validated['date'] = $clasp_profile->date ?? null;
        $validated['file'] = $clasp_profile->file ?? null;
        $validated['person_name'] = $person->name ?? null;
        $validated['person_rank'] = $person->rank->name ?? null;
        $validated['is_un'] = $clasp_profile->medal->is_un ?? null;

        Addclasp::create($validated);

        return redirect()->back()->with('success', 'Clasp assigned successfully.');
    }

    public function store_ajax(Request $request)
    {

        $validated = $request->validate([
            'person_id' => ['required', 'numeric'],
            'clasp_profile_id' => ['required', 'numeric'],
            'country_id' => ['nullable', 'numeric'],
            'from' => ['nullable', 'date'],
            'to' => ['nullable', 'date'],
        ]);

        // Check for existing clasp assignment
        $existingClasp = Addclasp::where('person_id', $validated['person_id'])
            ->where('clasp_profile_id', $validated['clasp_profile_id'])
            ->first();

        if ($existingClasp) {
            return response()->json([
                'success' => false,
                'message' => 'This clasp profile has already been assigned to this person'
            ]);
        }

        $person = Person::find($validated['person_id']);
        $clasp_profile = ClaspProfile::find($validated['clasp_profile_id']);

        // if (!$person || !$clasp_profile) {
        //     return back()->with('error', 'Invalid person or clasp profile.');
        // }

        $validated['medal_id'] = $clasp_profile->medal->id ?? null;
        $validated['rtype_id'] = $clasp_profile->rtype->id ?? null;
        $validated['date'] = $clasp_profile->date ?? null;
        $validated['file'] = $clasp_profile->file ?? null;
        $validated['person_name'] = $person->name ?? null;
        $validated['person_rank'] = $person->rank->name ?? null;
        $validated['is_un'] = $clasp_profile->medal->is_un ?? null;

        Addclasp::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Clasp assigned successfully.',
            'clasp_file' => $clasp_profile->file
        ]);
    }

    public function show(Addclasp $addclasp)
    {
        return view('addclasps.show', compact('addclasp'));
    }

    public function edit(Addclasp $addclasp)
    {
        $clasp_profiles = ClaspProfile::where('status', config('const.MEDAL_PROFILE_STATUS_ACTIVE_VALUE'))->get();
        $countries = Country::all();
        return view('addclasps.edit', compact('addclasp', 'clasp_profiles', 'countries'));
    }

    public function update(Request $request, Addclasp $addclasp)
    {
        $validated = $request->validate([
            'person_id' => ['required', 'numeric'],
            'clasp_profile_id' => ['required', 'numeric'],
            'country_id' => ['nullable', 'numeric'],
            'from' => ['nullable', 'date'],
            'to' => ['nullable', 'date'],
        ]);

        $person = Person::where('id', $validated['person_id'])->first();
        $clasp_profile = ClaspProfile::where('id', $validated['clasp_profile_id'])->first();

        $validated['medal_id'] = $clasp_profile->medal->id;
        $validated['rtype_id'] = $clasp_profile->rtype->id;
        $validated['date'] = $clasp_profile->date;
        $validated['file'] = $clasp_profile->file;
        $validated['person_name'] = $person->name;
        $validated['person_rank'] = $person->rank->name;
        $validated['is_un'] = $clasp_profile->medal->is_un;

        $addclasp->update($validated);
        return redirect()->route('addclasps.index')->with('success', 'Clasp assignment updated successfully.');
    }

    public function destroy(Addclasp $addclasp)
    {
        $addclasp->delete();
        return redirect()->route('addclasps.index')->with('success', 'Clasp assignment deleted successfully.');
    }

    public function create_bulk()
    {
        $clasp_profiles = ClaspProfile::where('status', config('const.MEDAL_PROFILE_STATUS_ACTIVE_VALUE'))->get();
        $regiments = Regiment::all();
        return view('addclasps.create_bulk', compact('clasp_profiles', 'regiments'));
    }

    public function store_bulk(Request $request)
    {
        $request->validate([
            'clasp_profile_id' => 'required|numeric',
            'regiment_id' => 'required|numeric',
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        $headings = (new HeadingRowImport)->toArray($request->file('file'))[0][0] ?? [];
        $expected = ['service_no', 'rank', 'name', 'unit'];
        foreach ($expected as $heading) {
            if (!in_array($heading, $headings)) {
                return back()->withErrors("Missing column: $heading");
            }
        }

        Excel::import(new AddClaspImport($request->regiment_id, $request->clasp_profile_id), $request->file('file'));
        return redirect()->route('addclasps.index')->with('success', 'Bulk import completed successfully.');
    }
}

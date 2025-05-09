<?php

namespace App\Http\Controllers;

use App\Models\Person;
use App\Models\Medal;  // Import Location Model
use App\Models\Rtype;
use App\Models\MedalProfile;
use App\Models\Addmedal;
use App\DataTables\AddmedalsDataTable;  // Import Location Model
use App\Models\Country;
use App\Models\Regiment;
use App\Imports\AddMedalImport;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;

use Illuminate\Http\Request;

class AddmedalController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('permission:view_users')->only('index', 'show');
    //     $this->middleware('permission:create_users')->only('create', 'store');
    //     $this->middleware('permission:edit_users')->only('edit', 'update');
    //     $this->middleware('permission:delete_users')->only('destroy');

    // }

    public function index(AddmedalsDataTable $dataTable)
    {
        return $dataTable->render('addmedals.index');
    }

    public function create()
    {
        $person = Person::all();
        $rtype = Rtype::all();
        $medal = Medal::all();
        $medal_profiles = MedalProfile::where('status', config('const.MEDAL_PROFILE_STATUS_ACTIVE_VALUE'))->get();
        $countries = Country::all();

        return view('addmedals.create', compact('medal', 'rtype', 'person', 'medal_profiles', 'countries'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'person_id' => ['required', 'numeric'],
            'medal_profile_id' => ['required', 'numeric'],
            'country_id' => ['nullable', 'numeric'],
            'from' => ['nullable', 'date'],
            'to' => ['nullable', 'date'],
        ]);

        $person = Person::where('id', $validated['person_id'])->first();
        $medal_profile = MedalProfile::where('id', $validated['medal_profile_id'])->first();

        $validated['medal_id'] = $medal_profile->medal->id;
        $validated['rtype_id'] = $medal_profile->rtype->id;
        $validated['date'] = $medal_profile->date;
        $validated['file'] = $medal_profile->file;
        $validated['person_name'] = $person->name;
        $validated['person_rank'] = $person->rank->name;
        $validated['is_un'] = $medal_profile->medal->is_un;

        $addmedal = Addmedal::create($validated);

        return redirect()->route('addmedals.index')->with('success', 'Addmedal created successfully.');
    }

    public function show(Addmedal $addmedal)
    {
        return view('addmedals.show', compact('addmedal'));
    }

    public function edit(Addmedal $addmedal)
    {
        $person = Person::all();
        $rtype = Rtype::all();
        $medal = Medal::all();
        $medal_profiles = MedalProfile::where('status', config('const.MEDAL_PROFILE_STATUS_ACTIVE_VALUE'))->get();
        $countries = Country::all();

        return view('addmedals.edit', compact('person', 'rtype', 'medal', 'medal_profiles', 'addmedal', 'countries'));
    }

    public function update(Request $request, Addmedal $addmedal)
    {
        $validated = $request->validate([
            'person_id' =>  ['required', 'numeric'],
            'medal_profile_id' =>  ['required', 'numeric'],
            'country_id' => ['nullable', 'numeric'],
            'from' => ['nullable', 'date'],
            'to' => ['nullable', 'date'],
        ]);

        $person = Person::where('id', $validated['person_id'])->first();
        $medal_profile = MedalProfile::where('id', $validated['medal_profile_id'])->first();

        $validated['medal_id'] = $medal_profile->medal->id;
        $validated['rtype_id'] = $medal_profile->rtype->id;
        $validated['date'] = $medal_profile->date;
        $validated['file'] = $medal_profile->file;
        $validated['person_name'] = $person->name;
        $validated['person_rank'] = $person->rank->name;
        $validated['is_un'] = $medal_profile->medal->is_un;

        $addmedal->update($validated);

        return redirect()->route('addmedals.index')->with('success', 'Addmedal updated successfully.');
    }

    public function destroy(Addmedal $addmedal)
    {
        $addmedal->delete();
        return redirect()->route('addmedals.index')->with('success', 'Addmedal deleted successfully.');
    }

    public function create_bulk()
    {
        $medal_profiles = MedalProfile::where('status', config('const.MEDAL_PROFILE_STATUS_ACTIVE_VALUE'))->get();
        $regiments = Regiment::all();

        return view('addmedals.create_bulk', compact('medal_profiles', 'regiments'));
    }

    public function store_bulk(Request $request)
    {
        $request->validate([
            'medal_profile_id' => 'required|numeric',
            'regiment_id' => 'required|numeric',
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        //Check if file header names are correct
        $headings = (new HeadingRowImport)->toArray($request->file('file'))[0][0] ?? [];
        $expected = ['service_no', 'rank', 'name', 'unit']; // whatever you expect
        foreach ($expected as $heading) {
            if (!in_array($heading, $headings)) {
                return back()->withErrors(["Missing or incorrect heading: '$heading'. Please download and refer to the 'Empty Excel File' for correct format."]);
            }
        }

        //Import from excel file
        try {
            Excel::import(new AddMedalImport($request->regiment_id, $request->medal_profile_id), $request->file('file'));

            return redirect()->route('addmedal.create_bulk')->with('status', 'File Imported Successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['excel_error' => $e->getMessage()]);
        }
    }
}

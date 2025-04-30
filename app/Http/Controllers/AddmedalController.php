<?php

namespace App\Http\Controllers;

use App\Models\Person;
use App\Models\Medal;  // Import Location Model
use App\Models\Rtype;
use App\Models\MedalProfile;
use App\Models\Addmedal;
use App\DataTables\AddmedalsDataTable;  // Import Location Model
use App\Models\Country;

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
}

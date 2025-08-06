<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Person;
use App\Models\ClaspProfile;



class ReportController extends Controller
{

    // public function __construct()
    // {
    //     $this->middleware('permission:view_reports')->only('index', 'show');
    //     $this->middleware('permission:create_reports')->only('create', 'store');
    //     $this->middleware('permission:edit_reports')->only('edit', 'update');
    //     $this->middleware('permission:delete_reports')->only('destroy');

    // }


    public function person_profile()
    {
        return view('reports.person_profile');
    }

    public function person_profile_show(Request $request)
    {

        $validated = $request->validate([
            'service_no' => 'required|string|max:255',
        ]);

        $validated['service_no'];

        $person = Person::where('service_no', $validated['service_no'])->with(['addmedal'])->first();
        if (!$person) {
            return redirect()->back()->with('error', 'Person not found.');
        }

        $person_addmedals = $person->addmedal;

        $clasp_profiles = ClaspProfile::where('status', config('const.MEDAL_PROFILE_STATUS_ACTIVE_VALUE'))
                    ->with(['rtype', 'medal'])
                    ->get();

        return view('reports.person_profile_show', compact('person','person_addmedals','clasp_profiles'));
    }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Person;


class ReportController extends Controller
{
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

        return view('reports.person_profile_show', compact('person','person_addmedals'));
    }

}

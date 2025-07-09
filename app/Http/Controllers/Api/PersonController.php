<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Addclasp;
use Illuminate\Http\Request;
use \App\Models\Person;
use Illuminate\Support\Facades\Validator;

class PersonController extends Controller
{
    public function get_medal_info(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'service_no' => 'required',
            'eno' => 'required',
        ], [
            'eno.required' => 'The eno is required.',
            'service_no.required' => 'The service_no is required.',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors(), 'status' => 0], 200);
        }


        $service_no = $request->input('service_no');
        $eno = $request->input('eno');

        $person = Person::where('service_no', $service_no)
            ->where('eno', $eno)
            ->first();
        if (!$person) {
            return response()->json(['message' => 'Person not found', 'status' => 0], 200);
        }

        $add_medals = $person->addmedal()->get();
        if ($add_medals->isEmpty()) {
            return response()->json(['message' => 'No medals found for this person', 'status' => 0], 200);
        }

        $medal_info = [];
        foreach ($add_medals as $add_medal) {

            $add_clasps = Addclasp::where('person_id', $add_medal->person_id)->where('medal_id', $add_medal->medal_id)->get();

            $clasp_info = [];
            foreach ($add_clasps as $add_clasp) {
                $clasp_info[] = [
                    'name' => $add_clasp->medal->name,
                    'date' => $add_clasp->date,
                    'type' => $add_clasp->medal->medal_type->medal_type,
                    'is_un' => $add_clasp->medal->is_un,
                    'reference' => $add_clasp->clasp_profile->rtype->rtype.'-'.$add_clasp->clasp_profile->reference_no.'-'.$add_clasp->clasp_profile->date,
                ];
            }

            $medal_info[] = [
                'name' => $add_medal->medal->name,
                'date' => $add_medal->date,
                'type' => $add_medal->medal->medal_type->medal_type,
                'is_un' => $add_medal->medal->is_un,
                'reference' => $add_medal->medal_profile->rtype->rtype.'-'.$add_medal->medal_profile->reference_no.'-'.$add_medal->medal_profile->date,
                'clasps' => $clasp_info ?? [],
            ];
        }

        return response()->json(['message' => 'Medal information retrieved successfully', 'status' => 1, 'medals' => $medal_info], 200);
    }
}

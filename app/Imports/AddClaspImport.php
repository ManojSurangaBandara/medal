<?php

namespace App\Imports;

use App\Models\Addclasp;
use App\Models\Person;
use App\Models\Rank;
use App\Models\Regiment;
use App\Models\Unit;
use App\Models\ClaspProfile;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class AddClaspImport implements ToCollection, WithHeadingRow, WithValidation
{
    protected $regiment_id, $clasp_profile_id;

    public function __construct($regiment_id, $clasp_profile_id)
    {
        $this->regiment_id = $regiment_id;
        $this->clasp_profile_id = $clasp_profile_id;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            if (!empty($row['service_no'])) {
                $person = Person::where('service_no', $row['service_no'])->first();

                if (!$person) {
                    $person = Person::create([
                        'service_no' => $row['service_no'],
                        'name' => $row['name'],
                        'regiment_id' => $this->regiment_id,
                        'rank_id' => Rank::where('name', $row['rank'])->first()->id,
                        'unit_id' => Unit::where('unit', $row['unit'])->first()->id,
                    ]);
                }

                $person = Person::where('service_no', $row['service_no'])->first();
                $clasp_profile = ClaspProfile::where('id', $this->clasp_profile_id)->first();

                $existingAddclasp = Addclasp::where('person_id', $person->id)
                    ->where('clasp_profile_id', $this->clasp_profile_id)
                    ->first();

                if (!$existingAddclasp) {
                    if ($person && $clasp_profile) {
                        Addclasp::create([
                            'person_id' => $person->id,
                            'medal_id' => $clasp_profile->medal->id,
                            'clasp_profile_id' => $this->clasp_profile_id,
                            'rtype_id' => $clasp_profile->rtype->id,
                            'date' => $clasp_profile->date,
                            'file' => $clasp_profile->file,
                            'person_name' => $person->name,
                            'person_rank' => $person->rank->name,
                            'is_un' => $clasp_profile->medal->is_un,
                            'country_id' => null,
                            'to' => null,
                            'from' => null,
                        ]);
                    }
                }
            }
        }
    }

    public function rules(): array
    {
        return [
            'service_no' => 'required',
            'rank' => 'required',
            'name' => 'required',
            'unit' => 'required',
        ];
    }
}

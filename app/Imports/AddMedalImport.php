<?php

namespace App\Imports;

use App\Models\Addmedal;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Person;
use Illuminate\Support\Facades\Http;
use App\Models\Rank;
use App\Models\Regiment;
use App\Models\Unit;
use App\Models\MedalProfile;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeImport;
use Maatwebsite\Excel\HeadingRowImport;



class AddMedalImport implements ToCollection,  WithHeadingRow, WithValidation

{
    protected $regiment_id, $medal_profile_id;

    public function __construct($regiment_id, $medal_profile_id)
    {
        $this->regiment_id = $regiment_id;
        $this->medal_profile_id = $medal_profile_id;
    }

    public function rules(): array
    {
        return [
            'rank' => 'required|string|exists:ranks,name',
            'unit' => 'required|string|exists:units,unit',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'rank.exists' => 'Rank name not allowed. Please refer to the allowed rank names list for correct format.',
            'unit.exists' => 'Unit name not allowed. Please refer to the allowed unit name list for correct format.',
        ];
    }

    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {

        foreach ($rows as $row) {
            $existingPerson = Person::where('service_no', $row['service_no'])->first();
            if ($row['service_no'] != null) {

                // Enter Person to the database if not existing
                if (!$existingPerson) {
                    Person::create([
                        'service_no' => $row['service_no'],
                        'name' => $row['name'],
                        'regiment_id' => $this->regiment_id,
                        'rank_id' => Rank::where('name', $row['rank'])->first()->id,
                        'unit_id' => Unit::where('unit', $row['unit'])->first()->id,
                    ]);
                }

                $person = Person::where('service_no', $row['service_no'])->first();
                $medal_profile = MedalProfile::where('id', $this->medal_profile_id)->first();

                //check if person already added to medal profile
                $existingAddmedal = Addmedal::where('person_id', $person->id)
                    ->where('medal_profile_id', $this->medal_profile_id)
                    ->first();

                // If person is not already added to addmedal, add them
                if (!$existingAddmedal) {
                    // Add person to medal profile
                    if ($person && $medal_profile) {
                        Addmedal::create([
                            'person_id' => $person->id,
                            'medal_id' => $medal_profile->medal->id,
                            'medal_profile_id' => $this->medal_profile_id,
                            'rtype_id' => $medal_profile->rtype->id,
                            'date' => $medal_profile->date,
                            'file' => $medal_profile->file,
                            'person_name' => $person->name,
                            'person_rank' => $person->rank->name,
                            'is_un' => $medal_profile->medal->is_un,
                            'country_id' => null,
                            'to' => null,
                            'from' => null,
                        ]);
                    }
                }
            }
        }
    }
}

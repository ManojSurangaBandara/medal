<?php
// app/Imports/MedalDataOldImport.php
namespace App\Imports;

use App\Models\MedalDataOld;
use App\Models\Person;
use App\Models\Rank;
use App\Models\Regiment;
use App\Models\Unit;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class MedalDataOldImport implements ToModel, WithStartRow, WithChunkReading
{

    public function model(array $row)
    {

        $row[1] = trim($row[1]);
        $row[2] = trim($row[2]);
        $row[3] = trim($row[3]);
        $row[4] = trim($row[4]);
        $row[5] = trim($row[5]);
        $row[6] = trim($row[6]);

        // Check if person exists
        $person = Person::where('service_no', $row[1])->first();

        if (!$person) {

            $rank = Rank::where('name', $row[2])->first();
            $regiment = Regiment::where('regiment', $row[4])->first();

            if (isset($rank)) {
                $rank_id = $rank->id;
            } else {
                $rank_id = null;
            }

            if (isset($regiment)) {
                $regiment_id = $regiment->id;
            } else {
                $regiment_id = null;
            }

            if (isset($row[1])) {
                $person = Person::create([
                    'service_no' => $row[1],
                    'name' => $row[3],
                    'rank_id' => $rank_id,
                    'regiment_id' => $regiment_id,
                    'unit_id' => null,
                ]);
            }
        }

        // Create medal data record regardless of person creation
        return new MedalDataOld([
            'service_no' => $row[1],
            'rank' => $row[2],
            'name' => $row[3],
            'regiment' => $row[4],
            'medal' => $row[5],
            'reference_string' => $row[6],
        ]);
    }

    public function startRow(): int
    {
        return 2; // Skip the first row (header)
    }

    public function chunkSize(): int
    {
        return 1000; // Adjust as needed
    }
}

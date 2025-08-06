<?php
// app/Imports/MedalDataOldImport.php
namespace App\Imports;

use App\Models\MedalDataOld;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterImport;
use App\Models\User;

class MedalDataOldImport implements ToModel, WithStartRow, WithChunkReading
{

    public function model(array $row)
    {
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

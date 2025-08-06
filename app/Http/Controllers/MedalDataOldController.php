<?php
// app/Http/Controllers/MedalDataOldController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\MedalDataOldImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\MedalDataOld;

class MedalDataOldController extends Controller
{
    public function showUploadForm()
    {
        return view('medal_data_old.upload');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        ini_set('max_execution_time', 9999999); // Increase timeout for this request
        Excel::import(new MedalDataOldImport, $request->file('file'));

        return back()->with('success', 'Data imported successfully.');
    }


    public function index()
    {
        $medalDataOld = MedalDataOld::paginate(25000); // Use pagination, 20 per page
        return view('medal_data_old.index', compact('medalDataOld'));
    }
}

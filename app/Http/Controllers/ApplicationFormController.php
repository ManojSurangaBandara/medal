<?php

namespace App\Http\Controllers;

use App\Models\ApplicationForm;
use App\Models\Medal;
use App\DataTables\ApplicationFormsDataTable;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApplicationFormController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view_application_forms')->only('index', 'show');
        $this->middleware('permission:create_application_forms')->only('create', 'store');
        $this->middleware('permission:edit_application_forms')->only('edit', 'update');
        $this->middleware('permission:delete_application_forms')->only('destroy');
    }

    public function index(ApplicationFormsDataTable $dataTable)
    {
        return $dataTable->render('application_forms.index');
    }

    public function create()
    {
        $medals = Medal::all();

        return view('application_forms.create', compact('medals'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'medal_id' => 'required|exists:medals,id',
            'file' => 'required|mimes:pdf|max:10240' // allows pdf files up to 10MB
        ]);

        $path = $request->file('file')->store('application_forms', 'public');
        $validated['file'] = $path;

        ApplicationForm::create($validated);

        return redirect()->route('application_forms.index')->with('success', 'Application Form created successfully.');
    }

    public function show(ApplicationForm $application_form)
    {
        return view('application_forms.show', compact('application_form',));
    }

    public function edit(ApplicationForm $application_form)
    {
        $medals = Medal::all(); // Fetch all medals for the dropdown
        // If you want to pre-select the medal in the dropdown, you can pass it to the view
        $selected_medal = $application_form->medal_id; // Get the current medal ID
        // Pass the medals and selected medal to the view
        return view('application_forms.edit', compact('application_form', 'medals', 'selected_medal'));
    }

    public function update(Request $request, ApplicationForm $application_form)
    {
        $validated = $request->validate([
            'medal_id' => 'required|exists:medals,id',
            'file' => 'nullable|file|mimes:pdf',
        ]);

        if ($request->hasFile('file')) {
            // Delete the old file if it exists
            if ($application_form->file && Storage::disk('public')->exists($application_form->file)) {
                Storage::disk('public')->delete($application_form->file);
            }

            $path = $request->file('file')->store('application_forms', 'public');
            $validated['file'] = $path;
        }

        $application_form->update($validated);
        return redirect()->route('application_forms.index')->with('success', 'Application Form updated successfully.');
    }

    public function destroy(ApplicationForm $application_form)
    {
        $application_form->delete();
        return redirect()->route('application_forms.index')->with('success', 'Application Form deleted successfully.');
    }
}

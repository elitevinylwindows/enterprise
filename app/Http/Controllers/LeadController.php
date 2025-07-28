<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lead;
use App\Models\User;
use App\Helper\LeadImportHelper;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\File\UploadedFile;


class LeadController extends Controller
{
    public function index()
    {
        $leads = Lead::all();
        return view('leads.index', compact('leads'));
    }
public function show($id)
{
    $lead = Lead::findOrFail($id);
    return view('leads.show', compact('lead'));
}

    // Optional methods you may add later:
    public function create() {}
    public function store(Request $request) {}
   public function edit(Lead $lead)
{
    return view('leads.edit', compact('lead'));
}

public function kanban()
{
    $statuses = [
        'pending' => 'Pending',
        'picked_up' => '✅ Picked Up',
        'call_back' => '🔁 Call Back Requested',
        'wrong_number' => '❌ Wrong Number',
        'voicemail' => '📴 Voicemail Left',
        'spoke' => '💬 Spoke with Contractor',
        'info_sent' => '📩 Info Sent (Email/Text)',
        'not_interested' => '🚫 Not Interested',
        'considering' => '⏳ Considering Us',
'do_not_call' => '🚫 Do Not Call',
    ];

    $leadsByStatus = [];
    foreach (array_keys($statuses) as $status) {
        $leadsByStatus[$status] = \App\Models\Lead::where('status', $status)->get();
    }

    return view('leads.kanban', compact('leadsByStatus', 'statuses'));
}

public function myKanban()
{
    $user = auth()->user();

    $statuses = [
        'pending' => 'Pending',
        'picked_up' => '✅ Picked Up',
        'call_back' => '🔁 Call Back Requested',
        'wrong_number' => '❌ Wrong Number',
        'voicemail' => '📴 Voicemail Left',
        'spoke' => '💬 Spoke with Contractor',
        'info_sent' => '📩 Info Sent (Email/Text)',
        'not_interested' => '🚫 Not Interested',
        'considering' => '⏳ Considering Us',
'do_not_call' => '🚫 Do Not Call',
    ];

    $leadsByStatus = [];
    foreach (array_keys($statuses) as $status) {
        $leadsByStatus[$status] = \App\Models\Lead::where('assigned_to', $user->id)
            ->where('status', $status)
            ->get();
    }

    return view('leads.mykanban', compact('leadsByStatus', 'statuses'));
}



public function reassignUnassigned()
{
    $agents = User::role('Sales Agents')->pluck('id')->toArray(); // use role name here
    $agentCount = count($agents);

    if ($agentCount === 0) {
        return back()->with('error', 'No sales agents found.');
    }

    $index = 0;

    $unassignedLeads = Lead::whereNull('assigned_to')->get();

foreach ($unassignedLeads as $lead) {
    $lead->assigned_to = $agents[$index % $agentCount];
    $lead->save();
    $index++;
}


    return back()->with('success', 'Unassigned leads were successfully distributed.');
}



public function debug()
{
    return 'Working';
}
    

public function updateStatus(Request $request)
{
    \Log::info('Updating status:', $request->all()); // debug log

    $request->validate([
        'id' => 'required|exists:elitevw_sr_leads,id',
        'status' => 'required|string'
    ]);

    $lead = Lead::findOrFail($request->id);
    $lead->status = $request->status;

    if ($request->status !== 'call_back') {
        $lead->call_back_date = null;
        $lead->call_back_time = null;
    }

    $lead->save();

    return response()->json(['message' => 'Status updated']);
}

    
        
    
public function update(Request $request, Lead $lead)
{
    $request->validate([
        'name' => 'required|string',
        'status' => 'nullable|string',
        'email' => 'nullable|string',
        'notes' => 'nullable|string',
        'call_back_date' => 'nullable|date',
        'call_back_time' => 'nullable'
    ]);

    $lead->fill($request->only(['name', 'status', 'email', 'notes', 'call_back_date', 'call_back_time']));
    $lead->save();

    return redirect()->back()->with('success', 'Lead updated');
}

    public function destroy($id) {}


public function handleImports(Request $request)
{
    $file = $request->file('import_file');

    // Handle re-import from confirmation page
    if ($request->filled('import_file') && is_string($request->import_file)) {
        $tempPath = storage_path('app/temp_lead_import.xlsx');
        file_put_contents($tempPath, base64_decode($request->import_file));
        $file = new UploadedFile($tempPath, 'import.xlsx', null, null, true);
    }

    if (!$file) {
        return back()->with('error', 'The uploaded file is invalid.');
    }

    $actionType = $request->input('action_type');
    $spreadsheet = IOFactory::load($file->getRealPath());
    $sheet = $spreadsheet->getActiveSheet();
    $rows = $sheet->toArray();

    if (empty($rows)) {
        return back()->with('error', 'The uploaded file is empty or incorrectly formatted.');
    }

    $headerRow = array_shift($rows);
    $headerMap = LeadImportHelper::getHeaderMap();

    $leadsToImport = [];
    $duplicateLicenses = [];

    foreach ($rows as $row) {
        $leadData = [];

        foreach ($headerRow as $index => $columnHeader) {
            $trimmedHeader = trim($columnHeader);
            $mappedField = $headerMap[$trimmedHeader] ?? null;

            if ($mappedField) {
                $value = trim($row[$index] ?? '');
                $leadData[$mappedField] = $value === '' ? null : $value;
            }
        }

        if (!empty($leadData['license_number'])) {
            $leadsToImport[] = $leadData;

            if (Lead::where('license_number', $leadData['license_number'])->exists()) {
                $duplicateLicenses[] = $leadData['license_number'];
            }
        }
    }

    if (!$actionType && !empty($duplicateLicenses)) {
        return view('leads.confirm-import', [
            'duplicates' => $duplicateLicenses,
            'originalFile' => base64_encode(file_get_contents($file->getRealPath()))
        ]);
    }

    foreach ($leadsToImport as $data) {
        if (
            $actionType === 'skip' &&
            array_key_exists('license_number', $data) &&
            Lead::where('license_number', $data['license_number'])->exists()
        ) {
            continue;
        }

        Lead::updateOrCreate(
            ['license_number' => $data['license_number']],
            $data
        );
    }

    return redirect()->route('leads.index')->with('success', 'Leads imported successfully.');
}

}

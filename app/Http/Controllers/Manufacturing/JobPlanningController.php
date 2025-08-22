<?php

namespace App\Http\Controllers\Manufacturing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Manufacturing\JobPlanning;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Facades\DB;


class JobPlanningController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status', 'all');

        $query = JobPlanning::query()->with('order');

        if ($status === 'deleted') {
            $query = JobPlanning::onlyTrashed()->with('order');
        } elseif ($status === 'processed') {
            $query->where('status', 'processed');
        } elseif ($status === 'tempered') {
            $query->where('status', 'tempered');
        } elseif ($status === 'unprocessed') {
            $query->where('status', 'unprocessed');
        }

        $jobs = $query->orderByDesc('id')->get();

        // If you pass stations to the Create modal:
        $stations = []; // or \App\Models\Manufacturing\Station::orderBy('station_number')->get();

        return view('manufacturing.job_planning.index', [
            'jobs'     => $jobs,
            'status'   => $status,
            'stations' => $stations,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'order_id'    => ['required','integer'],
            'status'      => ['required','string','in:unprocessed,processed,tempered,active,draft'],
            'priority'    => ['nullable','integer','min:0'],
            'station'     => ['nullable','string','max:255'],
            'description' => ['nullable','string'],
        ]);

        JobPlanning::create($data);

        return redirect()->route('manufacturing.job_planning.index')
            ->with('success', 'Job created.');
    }

public function show(Request $request, $job)
{
    $record = JobPlanning::find($job);

    // Fallback stub so the modal shows even without a real record
    if (!$record) {
        $record = (object) [
            'id'               => 0,
            'job_order_number' => 'JP-0001',
            'delivery_date'    => now()->addDays(7),
            'customer_number'  => 'CUST-42',
            'customer_name'    => 'Wayne Enterprises',
            'line'             => 'Line A',
            'series'           => 'LAM-WH',
            'qty'              => 36,
            'internal_notes'   => 'Demo notes…',
            'production_status'=> 'created',
        ];
    }

    // Empty datasets for tabs (you can wire real data later)
    $glassRows = []; $frameRows = []; $sashRows = []; $gridRows = [];

    // IMPORTANT: return a PARTIAL (no @extends)
    return view('manufacturing.job_planning.show', [
        'job'       => $record,
        'glassRows' => $glassRows,
        'frameRows' => $frameRows,
        'sashRows'  => $sashRows,
        'gridRows'  => $gridRows,
    ]);
}



public function download(Request $request, $job)
{
    $type = (string) $request->get('type', '');

    // Simple placeholder content per type
    $map = [
        'glass_xls'   => ['filename' => "glass_$job.xlsx",   'mime' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'body' => "Glass XLS for job $job"],
        'frame_xls'   => ['filename' => "frame_$job.xlsx",   'mime' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'body' => "Frame XLS for job $job"],
        'sash_xls'    => ['filename' => "sash_$job.xlsx",    'mime' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'body' => "Sash XLS for job $job"],
        'grids_xls'   => ['filename' => "grids_$job.xlsx",   'mime' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'body' => "Grids XLS for job $job"],
        'barcodes_pdf'=> ['filename' => "barcodes_$job.pdf", 'mime' => 'application/pdf',                                              'body' => "PDF for job $job"],
        'cutlist_txt' => ['filename' => "cutlist_$job.txt",  'mime' => 'text/plain',                                                   'body' => "Cutlist for job $job"],
        'labels_txt'  => ['filename' => "labels_$job.txt",   'mime' => 'text/plain',                                                   'body' => "Labels for job $job"],
        'all'         => ['filename' => "job_$job_all.zip",  'mime' => 'application/zip',                                             'body' => "ZIP bundle for job $job"],
    ];

    $conf = $map[$type] ?? ['filename' => "job_$job.txt", 'mime' => 'text/plain', 'body' => "Download for job $job ($type)"];

    return new StreamedResponse(function () use ($conf) {
        echo $conf['body']; // placeholder; replace with real file stream
    }, 200, [
        'Content-Type'        => $conf['mime'],
        'Content-Disposition' => 'attachment; filename="'.$conf['filename'].'"',
    ]);
}



    public function edit(JobPlanning $job)
    {
        $job->loadMissing('order');
        return view('manufacturing.job_planning.edit', compact('job'));
    }

    public function update(Request $request, JobPlanning $job)
    {
        $data = $request->validate([
            'status'      => ['required','string','in:unprocessed,processed,tempered,active,draft'],
            'priority'    => ['nullable','integer','min:0'],
            'station'     => ['nullable','string','max:255'],
            'description' => ['nullable','string'],
        ]);

        $job->update($data);

        return redirect()->route('manufacturing.job_planning.index')
            ->with('success', 'Job updated.');
    }

    public function destroy(Job $job)
    {
        $job->delete();
        return redirect()->route('manufacturing.job_planning.index', ['status' => 'deleted'])
            ->with('success', 'Job deleted.');
    }

    public function restore($id)
    {
        $job = Job::onlyTrashed()->findOrFail($id);
        $job->restore();
        return redirect()->route('manufacturing.job_planning.index')
            ->with('success', 'Job restored.');
    }

    public function forceDelete($id)
    {
        $job = Job::onlyTrashed()->findOrFail($id);
        $job->forceDelete();
        return redirect()->route('manufacturing.job_planning.index', ['status' => 'deleted'])
            ->with('success', 'Job permanently deleted.');
    }

    public function prioritize(Job $job)
    {
        $job->priority = max(1, (int)($job->priority ?? 0));
        $job->save();

        return redirect()->route('manufacturing.job_planning.index')
            ->with('success', 'Job prioritized.');
    }

    public function payment(Job $job)
    {
        return view('manufacturing.job_planning.payment', compact('job'));
    }

    // Returns the modal body above
public function create()
{
    return view('manufacturing.job_planning.create');
}

public function lookup(Request $req)
{
    $req->validate([
        'date_from' => 'nullable|date',
        'date_to'   => 'nullable|date|after_or_equal:date_from',
        'series'    => 'nullable|string|max:100',
        'colors'    => 'nullable|array',
        'colors.*'  => 'string|max:50',
    ]);

    $q = \App\Models\Manufacturing\JobPool::query();
    if ($req->filled('date_from')) $q->whereDate('delivery_date','>=',$req->date('date_from'));
    if ($req->filled('date_to'))   $q->whereDate('delivery_date','<=',$req->date('date_to'));
    if ($req->filled('series'))    $q->where('series','like',trim($req->series).'%');
    if ($req->colors)              $q->whereIn(\DB::raw('LOWER(color)'), array_map('strtolower',$req->colors));

    $rows = $q->orderBy('delivery_date')->orderBy('order_id')->limit(500)->get();

    $data = $rows->map(function ($r) {
        return [
            'id'                    => $r->id,
            'job_order_number'      => optional($r->order)->order_number ?? $r->order_id,
            'series'                => $r->series,
            'qty'                   => (int)($r->qty ?? 0),
            'line'                  => $r->line,
            'delivery_date'         => optional($r->delivery_date)->format('Y-m-d'),
            'type'                  => $r->type,
            'production_status'     => $r->production_status,
            'entry_date'            => optional($r->entry_date)->format('Y-m-d'),
            'last_transaction_date' => optional($r->last_transaction_date)->format('Y-m-d H:i'),
        ];
    });

    return response()->json(['success' => true, 'data' => $data]);
}

public function queue(Request $req)
{
    $req->validate([
        'selected_ids'       => 'required|array|min:1',
        'selected_ids.*'     => 'integer',
        'selected_qty_total' => 'nullable|integer|min:1|max:50',
    ], ['selected_ids.required' => 'Please select at least one job.']);

    $ids  = $req->input('selected_ids', []);
    $jobs = \App\Models\Manufacturing\JobPool::whereIn('id',$ids)->get()->keyBy('id');

    $totalQty = 0; $ordered = [];
    foreach ($ids as $id) {
        if (!isset($jobs[$id])) return back()->with('error',"Job ID {$id} not found.");
        $j = $jobs[$id]; $q = (int)($j->qty ?? 0);
        $totalQty += $q; $ordered[] = $j;
    }
    if ($totalQty > 50) return back()->with('error',"Total Qty {$totalQty} exceeds max 50.");

    $plannedDate = collect($ordered)->pluck('delivery_date')->filter()->sort()->first() ?: now();

    \DB::beginTransaction();
    try {
        $plan = \App\Models\Manufacturing\JobPlan::create([
            'planned_date'  => $plannedDate,
            'total_qty'     => $totalQty,
            'status'        => 'queued',
            'created_by_id' => auth()->id(),
        ]);

        $seq = 1;
        foreach ($ordered as $job) {
            \App\Models\Manufacturing\JobPlanItem::create([
                'job_plan_id'   => $plan->id,
                'job_pool_id'   => $job->id,
                'order_id'      => $job->order_id ?? null,
                'order_number'  => optional($job->order)->order_number,
                'series'        => $job->series,
                'color'         => $job->color,
                'frame_type'    => $job->frame_type,
                'qty'           => (int)($job->qty ?? 0),
                'line'          => $job->line,
                'delivery_date' => $job->delivery_date,
                'type'          => $job->type,
                'seq'           => $seq++,
            ]);

            $job->update([
                'production_status'     => 'in_production',
                'last_transaction_date' => now(),
            ]);
        }

        \DB::commit();
        return redirect()->route('manufacturing.job_planning.show', $plan->id)
            ->with('success', "Job plan #{$plan->id} created (qty {$totalQty}).");
    } catch (\Throwable $e) {
        \DB::rollBack(); report($e);
        return back()->with('error','Failed to create job plan: '.$e->getMessage());
    }
}


}

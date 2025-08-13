<?php

namespace App\Http\Controllers\Manufacturing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Manufacturing\Job;

class JobPlanningController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status', 'all');

        $query = Job::query()->with('order');

        if ($status === 'deleted') {
            $query = Job::onlyTrashed()->with('order');
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

        Job::create($data);

        return redirect()->route('manufacturing.job_planning.index')
            ->with('success', 'Job created.');
    }

public function show(Request $request, JobPlanning $job)
    {
        // Return the modal PARTIAL when opened via customModal (AJAX)
        if ($request->ajax()) {
            // Load any rows you want to show in the tabs, or leave empty arrays
            $glassRows = []; $frameRows = []; $sashRows = []; $gridRows = [];
            return view('manufacturing.job_planning._show', compact(
                'job','glassRows','frameRows','sashRows','gridRows'
            ));
        }

        // Optional: if user hits the URL directly, render a full page wrapper
        return view('manufacturing.job_planning.show_page', compact('job'));
    }


    public function edit(Job $job)
    {
        $job->loadMissing('order');
        return view('manufacturing.job_planning.edit', compact('job'));
    }

    public function update(Request $request, Job $job)
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

/** Lookup jobs to send (JSON) */
public function lookup(Request $request)
{
    $dateFrom = $request->date_from ? date('Y-m-d', strtotime($request->date_from)) : null;
    $dateTo   = $request->date_to   ? date('Y-m-d', strtotime($request->date_to))   : null;
    $series   = trim((string) $request->series);
    $colors   = (array) $request->get('colors', []);

    // Pull "created/draft" jobs (not yet queued)
    $q = \App\Models\Manufacturing\JobPool::query()
        ->whereIn('production_status', ['created', 'draft']);

    if ($dateFrom) $q->whereDate('delivery_date', '>=', $dateFrom);
    if ($dateTo)   $q->whereDate('delivery_date', '<=', $dateTo);
    if ($series !== '') $q->where('series', 'like', "%{$series}%");
    if (!empty($colors)) $q->whereIn('color', $colors);

    $rows = $q->latest('id')->limit(500)->get()->map(function($j){
        return [
            'id' => $j->id,
            'job_order_number' => $j->job_order_number,
            'delivery_date' => optional($j->delivery_date)->format('Y-m-d'),
            'customer_number' => $j->customer_number,
            'customer_name' => $j->customer_name,
            'line' => $j->line,
            'series' => $j->series,
            'color' => $j->color,
            'qty' => $j->qty,
        ];
    });

    return response()->json(['success' => true, 'data' => $rows]);
}

/** Bulk send selected to production queue */
public function queue(Request $request)
{
    $ids = (array) $request->get('selected_ids', []);
    if (empty($ids)) {
        return back()->with('error', 'No jobs selected.');
    }

    \App\Models\Manufacturing\JobPool::whereIn('id', $ids)->update([
        'production_status' => 'queued',
        'last_transaction_date' => now(),
        'updated_at' => now()
    ]);

    return redirect()->route('manufacturing.job_planning.index')->with('success', 'Selected jobs sent to Production Queue.');
}

}

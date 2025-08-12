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

    public function show(Job $job)
    {
        $job->loadMissing('order');
        return view('manufacturing.job_planning.show', compact('job'));
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
}

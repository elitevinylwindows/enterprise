<?php

namespace App\Http\Controllers\Manufacturing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Manufacturing\Job;

class JobPlanningController extends Controller
{
    /**
     * GET /manufacturing/job-planning
     * Filters: status = all|processed|tempered|unprocessed|deleted
     */
    public function index(Request $request)
    {
        $status = $request->get('status', 'all');

        // Base query with eager-loaded order relation (needed for job_order_number)
        $query = Job::query()->with(['order']);

        if ($status === 'deleted') {
            $query = Job::onlyTrashed()->with(['order']);
        } elseif ($status === 'processed') {
            $query->where('status', 'processed');
        } elseif ($status === 'tempered') {
            $query->where('status', 'tempered');
        } elseif ($status === 'unprocessed') {
            $query->where('status', 'unprocessed');
        }
        // else 'all' -> no status filter

        $jobs = $query->orderByDesc('id')->get();

        return view('manufacturing.job_planning.index', [
            'jobs'   => $jobs,
            'status' => $status,
        ]);
    }

    /**
     * Show a single job (used by your View modal)
     */
    public function show(Job $job)
    {
        $job->loadMissing('order');
        return view('manufacturing.job_planning.show', compact('job'));
    }

    /**
     * Edit form (used by your Edit modal)
     */
    public function edit(Job $job)
    {
        $job->loadMissing('order');
        return view('manufacturing.job_planning.edit', compact('job'));
    }

    /**
     * Update job (station/status/description/priority)
     */
    public function update(Request $request, Job $job)
    {
        $data = $request->validate([
            'station'     => 'nullable|string|max:255',
            'status'      => 'required|string|in:unprocessed,processed,tempered,active,draft',
            'description' => 'nullable|string',
            'priority'    => 'nullable|integer|min:0',
        ]);

        $job->update($data);

        return redirect()->route('manufacturing.job_planning.index')
            ->with('success', 'Job updated successfully.');
    }

    /**
     * Soft-delete a job (moves it to "Deleted" tab)
     */
    public function destroy(Job $job)
    {
        $job->delete();

        return redirect()->route('manufacturing.job_planning.index', ['status' => 'deleted'])
            ->with('success', 'Job deleted.');
    }

    /**
     * Restore a soft-deleted job
     */
    public function restore($id)
    {
        $job = Job::onlyTrashed()->findOrFail($id);
        $job->restore();

        return redirect()->route('manufacturing.job_planning.index')
            ->with('success', 'Job restored.');
    }

    /**
     * Permanently delete a soft-deleted job
     */
    public function forceDelete($id)
    {
        $job = Job::onlyTrashed()->findOrFail($id);
        $job->forceDelete();

        return redirect()->route('manufacturing.job_planning.index', ['status' => 'deleted'])
            ->with('success', 'Job permanently deleted.');
    }

    /**
     * Prioritize a job (simple example sets a higher priority)
     */
    public function prioritize(Job $job)
    {
        $job->priority = max(1, (int)($job->priority ?? 0));
        $job->save();

        return redirect()->route('manufacturing.job_planning.index')
            ->with('success', 'Job prioritized.');
    }

    /**
     * Payment modal/view placeholder (since your view links to it)
     * Adjust to your actual payment workflow.
     */
    public function payment(Job $job)
    {
        return view('manufacturing.job_planning.payment', compact('job'));
    }
}

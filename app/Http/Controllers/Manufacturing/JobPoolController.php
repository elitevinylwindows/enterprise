<?php

namespace App\Http\Controllers\Manufacturing;

use App\Http\Controllers\Controller;
use App\Models\Manufacturing\JobPool;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class JobPoolController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->string('status')->toString() ?: 'all';

        $query = JobPool::query();

        if ($status === 'deleted') {
            $query = JobPool::onlyTrashed();
        } elseif ($status !== 'all') {
            $query->where('production_status', $status);
        }

        // You can add additional optional filters here if needed (date ranges, etc.)
        $jobs = $query->latest('id')->get();

        return view('manufacturing.job_pool.index', [
            'jobs' => $jobs,
            'status' => $status,
        ]);
    }

    public function create()
    {
        // Return your modal form view
        return view('manufacturing.job_pool.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'job_order_number'   => ['required', 'string', 'max:100', 'unique:elitevw_manufacturing_job_pool,job_order_number'],
            'series'             => ['nullable', 'string', 'max:100'],
            'qty'                => ['required', 'integer', 'min:0'],
            'line'               => ['nullable', 'string', 'max:100'],
            'delivery_date'      => ['nullable', 'date'],
            'type'               => ['nullable', 'string', 'max:100'],
            'production_status'  => ['required', 'string', 'max:50'], // e.g. queued|in_production|completed
            'entry_date'         => ['nullable', 'date'],
            'last_transaction_date' => ['nullable', 'date'],
        ]);

        // Defaults
        $validated['entry_date'] = $validated['entry_date'] ?? now()->toDateString();
        $validated['last_transaction_date'] = $validated['last_transaction_date'] ?? now();

        JobPool::create($validated);

        return redirect()
            ->route('manufacturing.job_pool.index')
            ->with('success', 'Job created successfully.');
    }

    public function edit(JobPool $job_pool)
    {
        // Route model binding uses {job_pool}
        return view('manufacturing.job_pool.edit', ['job' => $job_pool]);
    }

    public function update(Request $request, JobPool $job_pool)
    {
        $validated = $request->validate([
            'job_order_number'   => ['required', 'string', 'max:100', Rule::unique('elitevw_manufacturing_job_pool', 'job_order_number')->ignore($job_pool->id)],
            'series'             => ['nullable', 'string', 'max:100'],
            'qty'                => ['required', 'integer', 'min:0'],
            'line'               => ['nullable', 'string', 'max:100'],
            'delivery_date'      => ['nullable', 'date'],
            'type'               => ['nullable', 'string', 'max:100'],
            'production_status'  => ['required', 'string', 'max:50'],
            'entry_date'         => ['nullable', 'date'],
            'last_transaction_date' => ['nullable', 'date'],
        ]);

        // Auto-touch last_transaction_date unless explicitly provided
        if (!$request->filled('last_transaction_date')) {
            $validated['last_transaction_date'] = now();
        }

        $job_pool->update($validated);

        return redirect()
            ->route('manufacturing.job_pool.index')
            ->with('success', 'Job updated successfully.');
    }

    public function destroy(JobPool $job_pool)
    {
        $job_pool->delete();

        return redirect()
            ->route('manufacturing.job_pool.index')
            ->with('success', 'Job deleted successfully.');
    }
}

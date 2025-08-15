<?php

namespace App\Http\Controllers\Master\Colors;

use App\Http\Controllers\Controller;
use App\Models\Master\Colors\StatusColor;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StatusColorController extends Controller
{
    public function index(Request $request)
    {
        $scope = $request->get('scope', 'all');

        $statusColors = $scope === 'deleted'
            ? StatusColor::onlyTrashed()->latest()->get()
            : StatusColor::latest()->get();

        return view('master.colors.status_colors.index', compact('statusColors', 'scope'));
    }

    public function create()
    {
        // modal partial (no @extends)
        return view('master.colors.status_colors.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'color_code' => ['required', 'regex:/^#?[0-9A-Fa-f]{6}$/'],
            'department' => ['required', 'string', 'max:100'],
            'status'     => ['required', 'string', 'max:100'],
            'status_abbr' => ['required', 'string', 'max:10', Rule::unique('status_colors')->where(function ($query) use ($request) {
                return $query->where('department', $request->department);
            })],
        ]);

        // Normalize HEX to "#RRGGBB"
        $data['color_code'] = strtoupper('#' . ltrim($data['color_code'], '#'));

        StatusColor::create($data);

        return redirect()
            ->route('color-options.status-colors.index')
            ->with('success', 'Status color created.');
    }

    public function show(StatusColor $status_color)
    {
        // Optional; not used by customModal flows
        return view('master.colors.status_colors.show', ['color' => $status_color]);
    }

    public function edit(StatusColor $status_color)
    {
        // modal partial (no @extends)
        return view('master.colors.status_colors.edit', ['status_color' => $status_color]);
    }

    public function update(Request $request, StatusColor $status_color)
    {
        $data = $request->validate([
            'color_code' => ['required', 'regex:/^#?[0-9A-Fa-f]{6}$/'],
            'department' => ['required', 'string', 'max:100'],
            'status'     => ['required', 'string', 'max:100'],
            'status_abbr' => ['required', 'string', 'max:10', Rule::unique('status_colors')->ignore($status_color->id)->where(function ($query) use ($request) {
                return $query->where('department', $request->department);
            })],
        ]);

        $data['color_code'] = strtoupper('#' . ltrim($data['color_code'], '#'));

        $status_color->update($data);

        return redirect()
            ->route('color-options.status-colors.index')
            ->with('success', 'Status color updated.');
    }

    public function destroy(StatusColor $status_color)
    {
        $status_color->delete(); // soft delete

        return redirect()
            ->route('color-options.status-colors.index', ['scope' => 'deleted'])
            ->with('success', 'Status color deleted.');
    }

    // ---- Optional helpers for soft-deletes (add routes if you need them) ----

    public function restore($id)
    {
        $color = StatusColor::onlyTrashed()->findOrFail($id);
        $color->restore();

        return redirect()
            ->route('color-options.status-colors.index')
            ->with('success', 'Status color restored.');
    }

    public function forceDelete($id)
    {
        $color = StatusColor::onlyTrashed()->findOrFail($id);
        $color->forceDelete();

        return redirect()
            ->route('color-options.status-colors.index', ['scope' => 'deleted'])
            ->with('success', 'Status color permanently deleted.');
    }
}

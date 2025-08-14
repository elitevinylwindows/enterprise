<?php

namespace App\Http\Controllers\Master\Colors;

use App\Http\Controllers\Controller;
use App\Models\Manufacturing\StatusColor; // or your actual model namespace
use Illuminate\Http\Request;

class StatusColorController extends Controller
{
    public function index()
    {
        $scope = request('scope', 'all');
        $statusColors = $scope === 'deleted'
            ? StatusColor::onlyTrashed()->latest()->get()
            : StatusColor::latest()->get();

        return view('master.colors.status_colors.index', compact('statusColors','scope'));
    }

    public function create()
    {
        return view('master.colors.status_colors.create');
    }

    public function edit(StatusColor $status_color)
    {
        return view('master.colors.status_colors.edit', ['color' => $status_color]);
    }

    // store/update/destroy... (as you already have)
}

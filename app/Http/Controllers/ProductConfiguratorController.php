<?php

namespace App\Http\Controllers;

use App\Models\FormOption;
use App\Models\FormOptionGroup;
use Illuminate\Http\Request;

class ProductConfiguratorController extends Controller
{
    public function index()
    {
        $groups = FormOptionGroup::with('options')->get();

        return view('inventory.configurator.index', compact('groups'));
    }
}

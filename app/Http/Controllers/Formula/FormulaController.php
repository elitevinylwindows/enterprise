<?php

namespace App\Http\Controllers\Formula;

use Illuminate\Http\Request;

class FormulaController extends Controller
{
    public function index()
    {
        // For now, no DB. Just load static Blade.
        return view('formulas.index');
    }
}

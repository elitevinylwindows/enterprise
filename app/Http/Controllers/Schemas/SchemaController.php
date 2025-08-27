<?php

namespace App\Http\Controllers\Schemas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SchemaController extends Controller
{
    public function importForm()
    {
        return view('schemas.import');
    }

    public function import(Request $request)
    {
        $validated = $request->validate([
            'import_file' => 'required',
            'action_type' => 'nullable|in:skip,overwrite',
        ]);

        // Call the helper function to handle the import
        return handleSchemaImport($request);
    }
}

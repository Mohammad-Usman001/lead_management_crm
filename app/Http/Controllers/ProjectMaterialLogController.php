<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProjectMaterialLog;

class ProjectMaterialLogController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'project_id' => 'required',
            'item_name'     => 'required|string|max:255',
            'technician_id' => 'nullable',

            'quantity' => 'required|numeric',
            'entry_date' => 'required|date',
            'remarks'       => 'nullable|string',
        ]);

        ProjectMaterialLog::create($request->all());

        return back()->with('success', 'Material entry added');
    }
    public function destroy(ProjectMaterialLog $material)
    {
        $material->delete();

        return back()->with('success', 'Material entry deleted successfully.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Technician;
use Mpdf\Mpdf;


class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::latest()->get();
        return view('admin.projects.index', compact('projects'));
    }
    public function create()
    {
        return view('admin.projects.create');
    }
    public function show($id)
    {
        $project = Project::with('materialLogs.technician')
            ->findOrFail($id);

        $technicians = Technician::all();

        return view('admin.projects.show', compact('project', 'technicians'));
    }

    public function store(Request $request)
    {
        Project::create($request->validate([
            'project_name' => 'required',
            'description' => 'nullable',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'assigned_team_id' => 'nullable|integer|exists:teams,id',
            'status' => 'required'
        ]));

        return redirect()->route('projects.index');
    }
    public function edit(string $id)
    {
        $project = Project::findOrFail($id);
        return view('admin.projects.edit', compact('project'));
    }
    public function update(Request $request, string $id)
    {
        $request->validate([
            'project_name' => 'required',
            'description' => 'nullable',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'assigned_team_id' => 'nullable|integer|exists:teams,id',
            'status' => 'required'
        ]);

        $project = Project::findOrFail($id);
        $project->update($request->all());

        return redirect()->route('projects.index')->with('success', 'Project updated successfully!');
    }
    public function destroy(string $id)
    {
        $project = Project::findOrFail($id);
        $project->delete();

        return redirect()->route('projects.index')->with('success', 'Project deleted successfully!');
    }
    public function materialHistoryPdf($id)
    {
        $project = Project::with(['materialLogs.technician'])
            ->findOrFail($id);

        $html = view('admin.projects.material_pdf', compact('project'))->render();

        $mpdf = new Mpdf([
            'format' => 'A4',
            'margin_top' => 10,
            'margin_bottom' => 15,
            'margin_left' => 10,
            'margin_right' => 10,
        ]);

        $mpdf->SetTitle('Project Material History');
        $mpdf->WriteHTML($html);

        return $mpdf->Output(
            'Project_Material_History_' . $project->name . '.pdf',
            'I' // I = browser view, D = download
        );
    }


    // public function index()
    // {
    //     $projects = Project::all();
    //     return view('admin.projects.index', compact('projects'));
    // }

    // public function create()
    // {
    //     return view('admin.projects.create');
    // }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'project_name' => 'required|string|max:255',
    //         'description' => 'nullable|string',
    //         'start_date' => 'nullable|date',
    //         'end_date' => 'nullable|date|after_or_equal:start_date',
    //         'assigned_team_id' => 'nullable|integer|exists:teams,id',
    //         'status' => 'required|in:Not Started,In Progress,Completed',
    //         'linked_lead_id' => 'required|integer|exists:leads,lead_id',
    //     ]);

    //     Project::create($request->all());

    //     return redirect()->route('projects.index')->with('success', 'Project created successfully!');
    // }

    // public function show(string $id)
    // {
    //     $project = Project::findOrFail($id);
    //     return view('admin.projects.show', compact('project'));
    // }

    // public function edit(string $id)
    // {
    //     $project = Project::findOrFail($id);
    //     return view('admin.projects.edit', compact('project'));
    // }

    // public function update(Request $request, string $id)
    // {
    //     $request->validate([
    //         'project_name' => 'required|string|max:255',
    //         'description' => 'nullable|string',
    //         'start_date' => 'nullable|date',
    //         'end_date' => 'nullable|date|after_or_equal:start_date',
    //         'assigned_team_id' => 'nullable|integer|exists:teams,id',
    //         'status' => 'required|in:Not Started,In Progress,Completed',
    //         'linked_lead_id' => 'required|integer|exists:leads,id',
    //     ]);

    //     $project = Project::findOrFail($id);
    //     $project->update($request->all());

    //     return redirect()->route('admin.projects.index')->with('success', 'Project updated successfully!');
    // }


}

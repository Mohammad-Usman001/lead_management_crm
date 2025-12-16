<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\User;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    // public function index()
    // {
    //     $leads = Lead::all();

    //     return view('admin.leads.index', compact('leads'));
    // }

   public function index(Request $request)
{
    $query = Lead::query();

    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('customer_name', 'LIKE', "%{$search}%")
              ->orWhere('email', 'LIKE', "%{$search}%")
              ->orWhere('status', 'LIKE', "%{$search}%");
        });
    }

    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    if ($request->filled('assigned_to')) {
        $query->where('assigned_to', $request->assigned_to);
    }

    // Safe default sort fallback
    $allowedSorts = ['created_at', 'follow_up_date', 'customer_name', 'status'];
    $sortColumn = $request->get('sort_by', 'created_at');
    if (!in_array($sortColumn, $allowedSorts)) {
        $sortColumn = 'created_at';
    }
    $sortOrder = $request->get('sort_order', 'desc') === 'asc' ? 'asc' : 'desc';

    $query->orderBy($sortColumn, $sortOrder);

    $leads = $query->paginate(10)->withQueryString();

    $users = User::all();

    return view('admin.leads.index', compact('leads', 'users'));
}


    public function create()
    {
        $users = User::all();
        return view('admin.leads.create', compact('users'));
    }

    public function store(Request $request)
    {
        // $request->validate([
        //     'received_date' => 'required',
        //     'follow_up_date' => 'required',
        //     'customer_name' => 'required',
        //     'email' => 'nullable|email',
        //     'country' => 'required',
        //     'contact_number' => 'required',
        //     'website' => 'nullable',
        //     'lead_source' => 'required',
        //     'service_required' => 'required',
        //     'status' => 'required',
        //     'linkedin_profile' => 'nullable',
        //     'assigned_to' => 'required',
        // ]);
        $data = $request->validate([
        'customer_name' => 'required|string|max:255',
        'contact_number' => 'required|string|max:10|min:10',
        'site_address' => 'nullable|string',
        'city' => 'nullable|string|max:120',
        'property_type' => 'nullable|string',
        'site_area' => 'nullable|string|max:100',
        'num_cameras' => 'nullable|integer|min:0',
        'camera_type' => 'nullable|string',
        'features' => 'nullable|array',
        'features.*' => 'nullable|string',
        'installation_required' => 'nullable|string',
        'preferred_date' => 'nullable|date',
        'budget' => 'nullable|string',
        'lead_source' => 'nullable|string',
        'status' => 'nullable|string',
        'follow_up_date' => 'nullable|date',
        'notes' => 'nullable|string',
    ]);
    // Normalize features (store as JSON or comma-separated)
    $data['features'] = isset($data['features']) ? json_encode($data['features']) : null;

    // Example: Create the lead (adjust model name and fillable properties)
    $lead = \App\Models\Lead::create($data);

    return redirect()->route('leads.index')->with('success','Lead saved successfully.');

        // Lead::create($request->all());

        // return redirect()->route('leads.index');
    }

    public function show(Lead $lead)
    {
        // Make sure features field is decoded for view (optional)
        if (!is_array($lead->features)) {
            $lead->features = json_decode($lead->features, true) ?? [];
        }

        // eager load assigned user so view can use $lead->assignedUser->name
        $lead->load('assignedUser');

        return view('admin.leads.show', compact('lead'));
    }

   public function edit($lead_id)
{
    $lead = Lead::findOrFail($lead_id);
    return view('admin.leads.edit', compact('lead'));
}

public function update(Request $request, $lead_id)
{
    $lead = Lead::findOrFail($lead_id);

    $data = $request->validate([
        'customer_name' => 'required|string|max:255',
        'contact_number' => 'required|string|max:30',
        'site_address' => 'nullable|string',
        'city' => 'nullable|string|max:120',
        'property_type' => 'nullable|string',
        'site_area' => 'nullable|string|max:100',
        'num_cameras' => 'nullable|integer|min:0',
        'camera_type' => 'nullable|string',
        'features' => 'nullable|array',
        'features.*' => 'nullable|string',
        'installation_required' => 'nullable|string',
        'preferred_date' => 'nullable|date',
        'budget' => 'nullable|string',
        'lead_source' => 'nullable|string',
        'status' => 'nullable|string',
        'follow_up_date' => 'nullable|date',
        'notes' => 'nullable|string',
    ]);

    $data['features'] = $request->has('features')
        ? json_encode($request->features)
        : null;

    $lead->update($data);

    return redirect()->route('leads.index')->with('success', 'Lead updated successfully.');
}


    public function destroy(Lead $lead)
    {
        $lead->delete();

        return redirect()->route('leads.index');
    }

    public function search(Request $request)
    {
        $search = $request->get('search');
        $leads = Lead::where('customer_name', 'like', '%'.$search.'%')->get();

        return view('admin.leads.index', compact('leads'));
    }

    public function filter(Request $request)
    {
        $filter = $request->get('filter');
        $leads = Lead::where('status', $filter)->get();

        return view('admin.leads.index', compact('leads'));
    }

    public function assign(Lead $lead)
    {

        $users = User::all();

        return view('admin.leads.assign', compact('lead', 'users'));
    }

    public function assignUser(Request $request, Lead $lead)
    {
        $request->validate([
            'assigned_to' => 'required',
        ]);

        $lead->update($request->all());

        return redirect()->route('admin.leads.index');
    }
    public function updateStatus(Request $request, Lead $lead)
{
    $request->validate([
        'status' => 'required|string'
    ]);

    $lead->update([
        'status' => $request->status
    ]);

    return response()->json([
        'success' => true,
        'status' => $lead->status
    ]);
}

    
}

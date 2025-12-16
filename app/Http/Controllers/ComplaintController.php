<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Complaint;
use App\Models\ComplaintImage;
use App\Models\User;
use App\Models\Lead;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ComplaintController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Complaint::with(['assignedUser', 'lead'])->latest();

        if ($request->has('search') && $request->search) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('customer_name', 'like', "%{$s}%")
                    ->orWhere('contact_number', 'like', "%{$s}%")
                    ->orWhere('device_type', 'like', "%{$s}%")
                    ->orWhere('serial_number', 'like', "%{$s}%");
            });
        }

        if ($request->status) $query->where('status', $request->status);
        if ($request->priority) $query->where('priority', $request->priority);

        $complaints = $query->paginate(15)->withQueryString();
        $users = User::all();

        return view('complaints.index', compact('complaints', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $users = User::all();
        $lead = null;
        if ($request->has('lead_id')) {
            $lead = Lead::find($request->lead_id);
        }
        return view('complaints.create', compact('users', 'lead'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'lead_id' => 'nullable|exists:leads,lead_id',
            'customer_name' => 'required|string|max:255',
            'contact_number' => 'required|string|max:10|min:10',
            'site_address' => 'nullable|string',
            'city' => 'nullable|string|max:150',
            'location_detail' => 'nullable|string|max:255',
            'device_type' => 'nullable|string|max:255',
            'serial_number' => 'nullable|string|max:255',
            'issue_description' => 'nullable|string',
            'priority' => ['required', Rule::in(['Low', 'Medium', 'High'])],
            'status' => ['nullable', Rule::in(['New', 'Assigned', 'In Progress', 'Resolved', 'Closed', 'Rejected'])],
            'assigned_to' => 'nullable|exists:users,id',
            'reported_at' => 'nullable|date',
            'scheduled_visit' => 'nullable|date',
            'technician_notes' => 'nullable|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120'
        ]);

        $data['status'] = $data['status'] ?? 'New';
        $complaint = Complaint::create($data);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                $path = $img->store('complaints', 'public');
                $complaint->images()->create([
                    'path' => $path,
                    'original_name' => $img->getClientOriginalName()
                ]);
            }
        }

        return redirect()->route('complaints.show', $complaint)->with('success', 'Complaint registered.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Complaint $complaint)
    {
        $complaint->load(['images', 'assignedUser', 'lead']);
        return view('complaints.show', compact('complaint'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Complaint $complaint)
    {
        $users = User::all();
        return view('complaints.edit', compact('complaint', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Complaint $complaint)
    {
        $data = $request->validate([
            'lead_id' => 'nullable|exists:leads,lead_id',
            'customer_name' => 'required|string|max:255',
            'contact_number' => 'nullable|string|max:50',
            'site_address' => 'nullable|string',
            'city' => 'nullable|string|max:150',
            'location_detail' => 'nullable|string|max:255',
            'device_type' => 'nullable|string|max:255',
            'serial_number' => 'nullable|string|max:255',
            'issue_description' => 'nullable|string',
            'priority' => ['required', Rule::in(['Low', 'Medium', 'High'])],
            'status' => ['required', Rule::in(['New', 'Assigned', 'In Progress', 'Resolved', 'Closed', 'Rejected'])],
            'assigned_to' => 'nullable|exists:users,id',
            'reported_at' => 'nullable|date',
            'scheduled_visit' => 'nullable|date',
            'technician_notes' => 'nullable|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120'
        ]);

        $complaint->update($data);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                $path = $img->store('complaints', 'public');
                $complaint->images()->create([
                    'path' => $path,
                    'original_name' => $img->getClientOriginalName()
                ]);
            }
        }

        return redirect()->route('complaints.show', $complaint)->with('success', 'Complaint updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Complaint $complaint)
    {
        // delete images files from storage
        foreach ($complaint->images as $img) {
            Storage::disk('public')->delete($img->path);
            $img->delete();
        }
        $complaint->delete();

        return redirect()->route('complaints.index')->with('success', 'Complaint deleted.');
    }
    // optional: remove a specific image via AJAX or form
    public function removeImage(Complaint $complaint, ComplaintImage $image)
    {
        if ($image->complaint_id !== $complaint->id) abort(403);
        Storage::disk('public')->delete($image->path);
        $image->delete();
        return back()->with('success', 'Image removed');
    }
    public function updateStatus(Request $request, Complaint $complaint)
    {
        $request->validate([
            'status' => 'required|string'
        ]);

        $complaint->update([
            'status' => $request->status
        ]);

        return response()->json([
            'success' => true,
            'status' => $complaint->status
        ]);
    }
}

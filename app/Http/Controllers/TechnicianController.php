<?php

namespace App\Http\Controllers;

use App\Models\Technician;
use Illuminate\Http\Request;

class TechnicianController extends Controller
{
    /**
     * Display a listing of the technicians.
     */
    public function index()
    {
        $technicians = Technician::orderBy('name')->get();
        return view('admin.technicians.index', compact('technicians'));
    }

    /**
     * Show the form for creating a new technician.
     */
    public function create()
    {
        return view('admin.technicians.create');
    }

    /**
     * Store a newly created technician in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'mobile' => 'nullable|string|max:15',
        ]);

        Technician::create($request->all());

        return redirect()->route('technicians.index')->with('success', 'Technician added successfully.');
    }

    /**
     * Display the specified technician.
     */
    public function show(Technician $technician)
    {
        return view('admin.technicians.show', compact('technician'));
    }

    /**
     * Show the form for editing the specified technician.
     */
    public function edit(Technician $technician)
    {
        return view('admin.technicians.edit', compact('technician'));
    }

    /**
     * Update the specified technician in storage.
     */
    public function update(Request $request, Technician $technician)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'mobile' => 'nullable|string|max:15',
        ]);

        $technician->update($request->all());

        return redirect()->route('technicians.index')->with('success', 'Technician updated successfully.');
    }

    /**
     * Remove the specified technician from storage.
     */
    public function destroy(Technician $technician)
    {
        $technician->delete();

        return redirect()->route('technicians.index')->with('success', 'Technician deleted successfully.');
    }
}

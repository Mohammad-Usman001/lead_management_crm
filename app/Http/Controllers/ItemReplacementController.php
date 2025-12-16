<?php

namespace App\Http\Controllers;

use App\Models\ItemReplacement;
use Illuminate\Http\Request;

class ItemReplacementController extends Controller
{
    public function index()
    {
        $replacements = ItemReplacement::latest()->get();
        return view('admin.replacements.index', compact('replacements'));
    }

    public function create()
    {
        return view('admin.replacements.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'client_name' => 'required',
            'deposit_date' => 'required|date',
            'items.*.item_name' => 'required|string',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        ItemReplacement::create([
            'client_name' => $request->client_name,
            'deposited_by' => $request->deposited_by,
            'deposit_date' => $request->deposit_date,
            'replacement_date' => $request->replacement_date,
            'status' => $request->status,
            'items' => $request->items, // 👈 STORED AS JSON
            'remarks' => $request->remarks,
        ]);

        return redirect()->route('replacements.index')
            ->with('success', 'Replacement entry saved successfully');
    }

    public function show(ItemReplacement $replacement)
    {
        return view('admin.replacements.show', compact('replacement'));
    }

    public function edit(ItemReplacement $replacement)
    {
        return view('admin.replacements.edit', compact('replacement'));
    }

    public function update(Request $request, ItemReplacement $replacement)
    {
        $request->validate([
            'client_name' => 'required|string',
            'deposit_date' => 'required|date',
            'items.*.item_name' => 'required|string',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $replacement->update([
            'client_name' => $request->client_name,
            'deposited_by' => $request->deposited_by,
            'deposit_date' => $request->deposit_date,
            'replacement_date' => $request->replacement_date,
            'status' => $request->status,
            'items' => $request->items, // JSON update
            'remarks' => $request->remarks,
        ]);

        return redirect()->route('replacements.index')
            ->with('success', 'Replacement updated successfully');
    }

    public function destroy(ItemReplacement $replacement)
    {
        $replacement->delete();

        return redirect()->route('replacements.index')
            ->with('success', 'Replacement entry deleted successfully');
    }
}

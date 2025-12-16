<?php

namespace App\Http\Controllers;

use App\Models\Estimate;
use App\Models\EstimateItem;
use Illuminate\Http\Request;
// use Barryvdh\DomPDF\Facade\Pdf; // ensure this import; or use PDF alias if configured
use Mpdf\Mpdf;

class EstimateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $estimates = Estimate::latest()->paginate(15);
        return view('estimates.index', compact('estimates'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // ensure $items is a Collection so view methods like isNotEmpty() work
        return view('estimates.form', [
            'estimate' => new Estimate(),
            'items' => collect([]),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'invoice_no' => 'nullable|string',
            'date' => 'nullable|date',
            'client_name' => 'nullable|string',
            'client_address' => 'nullable|string',
            'client_phone' => 'required|string|max:10|min:10',
            'email' => 'nullable|email',
            'gst' => 'nullable|string',
            'notes' => 'nullable|string',
            'item_description.*' => 'nullable|string',
            'item_qty.*' => 'nullable|integer',
            'item_rate.*' => 'nullable|numeric',
        ]);

        $estimate = Estimate::create([
            'invoice_no' => $request->invoice_no ?? 'EST-' . time(),
            'date' => $request->date,
            'client_name' => $request->client_name,
            'client_address' => $request->client_address,
            'client_phone' => $request->client_phone,
            'email' => $request->email,
            'gst' => $request->gst,
            'notes' => $request->notes,
        ]);

        $subTotal = 0;
        $items = $request->input('item_description', []);
        foreach ($items as $idx => $desc) {
            $qty = (int) ($request->input('item_qty')[$idx] ?? 0);
            $rate = (float) ($request->input('item_rate')[$idx] ?? 0);
            $amount = $qty * $rate;
            if ($desc || $qty || $rate) {
                $estimate->items()->create([
                    'line' => $idx + 1,
                    'description' => $desc,
                    'qty' => $qty,
                    'rate' => $rate,
                    'amount' => $amount,
                ]);
                $subTotal += $amount;
            }
        }

        $estimate->sub_total = $subTotal;
        $estimate->total = $subTotal;
        $estimate->save();

        return redirect()->route('estimates.show', $estimate)->with('success', 'Estimate created');
    }

    /**
     * Display the specified resource.
     *
     * Using route-model binding: Laravel will inject the Estimate instance.
     */
    public function show(Estimate $estimate)
    {
        $estimate->load('items');
        return view('estimates.show', compact('estimate'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Estimate $estimate)
    {
        $estimate->load('items');
        return view('estimates.form', ['estimate' => $estimate, 'items' => $estimate->items]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Estimate $estimate)
    {
        $data = $request->validate([
            'invoice_no' => 'nullable|string',
            'date' => 'nullable|date',
            'client_name' => 'nullable|string',
            'client_address' => 'nullable|string',
            'client_phone' => 'nullable|string',
            'email' => 'nullable|email',
            'gst' => 'nullable|string',
            'notes' => 'nullable|string',
            'item_description.*' => 'nullable|string',
            'item_qty.*' => 'nullable|integer',
            'item_rate.*' => 'nullable|numeric',
        ]);

        $estimate->update([
            'invoice_no' => $request->invoice_no,
            'date' => $request->date,
            'client_name' => $request->client_name,
            'client_address' => $request->client_address,
            'client_phone' => $request->client_phone,
            'email' => $request->email,
            'gst' => $request->gst,
            'notes' => $request->notes,
        ]);

        // Remove all items and re-create (simple approach)
        $estimate->items()->delete();

        $subTotal = 0;
        $items = $request->input('item_description', []);
        foreach ($items as $idx => $desc) {
            $qty = (int) ($request->input('item_qty')[$idx] ?? 0);
            $rate = (float) ($request->input('item_rate')[$idx] ?? 0);
            $amount = $qty * $rate;
            if ($desc || $qty || $rate) {
                $estimate->items()->create([
                    'line' => $idx + 1,
                    'description' => $desc,
                    'qty' => $qty,
                    'rate' => $rate,
                    'amount' => $amount,
                ]);
                $subTotal += $amount;
            }
        }

        $estimate->sub_total = $subTotal;
        $estimate->total = $subTotal;
        $estimate->save();

        return redirect()->route('estimates.show', $estimate)->with('success', 'Estimate updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Estimate $estimate)
    {
        $estimate->delete();
        return redirect()->route('estimates.index')->with('success', 'Estimate deleted');
    }

    /**
     * Generate PDF and download
     */
    // public function pdf(Estimate $estimate)
    // {
    //     $estimate->load('items');
    //      $clientNumber = preg_replace('/[^0-9]/', '', $estimate->client_phone);
    //     $pdf = Pdf::loadView('estimates.pdf', compact('estimate'))->setPaper('a4', 'portrait');
    //     return $pdf->download("estimate-{$clientNumber}.pdf");
    // }
    public function pdf(Estimate $estimate)
    {
        $estimate->load('items');

        $clientNumber = preg_replace('/[^0-9]/', '', $estimate->client_phone);
        $filename = "estimate-{$clientNumber}.pdf";

        $html = view('estimates.pdf', compact('estimate'))->render();

        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'margin_top' => 5,
            'margin_bottom' => 5,
            'margin_left' => 5,
            'margin_right' => 5,
        ]);
        // ✅ WATERMARK
        $mpdf->SetWatermarkImage(
            public_path('assets/images/DIAMOND-IT.png'),
            0.12,            // opacity (0.1–0.2 best)
            [120, 120],      // size
            true
        );
        $mpdf->showWatermarkImage = true;
        $mpdf->WriteHTML($html);
        return response($mpdf->Output($filename, 'S'))
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', "attachment; filename={$filename}");
    }
}

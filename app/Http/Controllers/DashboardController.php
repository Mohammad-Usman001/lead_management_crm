<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use App\Models\Estimate;
use App\Models\Complaint;
use App\Models\User;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
     // Shared filters
        $search    = $request->query('search');
        $fromDate  = $request->query('created_at');
        $toDate    = $request->query('to_date');
        $assigned  = $request->query('assigned_to');

        // Per-resource status filters
        $leadStatus      = $request->query('lead_status');
        $estimateStatus  = $request->query('estimate_status');
        $complaintStatus = $request->query('complaint_status');

        // --- LEADS QUERY ---
        $leadsQuery = Lead::query()->with('assignedUser');

        if ($search) {
            $leadsQuery->where(function($q) use ($search) {
                $q->where('customer_name', 'like', "%{$search}%")
                  ->orWhere('contact_number', 'like', "%{$search}%")
                  ->orWhere('site_address', 'like', "%{$search}%");
            });
        }

        if ($leadStatus) {
            $leadsQuery->where('status', $leadStatus);
        }

        if ($assigned) {
            $leadsQuery->where('assigned_to', $assigned);
        }

        if ($fromDate) {
            $leadsQuery->whereDate('created_at', '>=', $fromDate);
        }
        if ($toDate) {
            $leadsQuery->whereDate('created_at', '<=', $toDate);
        }

        $leads = $leadsQuery->orderBy('created_at', 'desc')
                            ->paginate(6, ['*'], 'leads_page');

        // --- ESTIMATES QUERY ---
        $estQuery = Estimate::query();

        if ($search) {
            $estQuery->where(function($q) use ($search) {
                $q->where('invoice_no', 'like', "%{$search}%")
                  ->orWhere('client_name', 'like', "%{$search}%")
                  ->orWhere('client_phone', 'like', "%{$search}%")
                  ;
            });
        }

        if ($estimateStatus) {
            // if you have a status column on estimates; otherwise skip this
            $estQuery->where('status', $estimateStatus);
        }

        if ($fromDate) $estQuery->whereDate('created_at', '>=', $fromDate);
        if ($toDate)   $estQuery->whereDate('created_at', '<=', $toDate);

        $estimates = $estQuery->orderBy('created_at', 'desc')
                              ->paginate(6, ['*'], 'estimates_page');

        // --- COMPLAINTS QUERY ---
        $compQuery = Complaint::query()->with('assignedUser');

        if ($search) {
            $compQuery->where(function($q) use ($search) {
                $q->where('customer_name', 'like', "%{$search}%")
                  ->orWhere('serial_number', 'like', "%{$search}%")
                  ->orWhere('device_type', 'like', "%{$search}%")
                  ->orWhere('issue_description', 'like', "%{$search}%");
            });
        }

        if ($complaintStatus) {
            $compQuery->where('status', $complaintStatus);
        }

        if ($assigned) {
            $compQuery->where('assigned_to', $assigned);
        }

        if ($fromDate) $compQuery->whereDate('created_at', '>=', $fromDate);
        if ($toDate)   $compQuery->whereDate('created_at', '<=', $toDate);

        $complaints = $compQuery->orderBy('created_at', 'desc')
                                ->paginate(6, ['*'], 'complaints_page');

        // Summary counts for "New" items
        $counts = [
            'leads_new'      => Lead::where('status', 'New')->count(),
            'today_leads'   => Lead::whereDate('created_at', today())->count(),
            'today_estimates'=> Estimate::whereDate('created_at', today())->count(),
            'today_complaints'=> Complaint::whereDate('created_at', today())->count(),
            'estimates_total'=> Estimate::count(),
            'complaints_new' => Complaint::where('status', 'New')->count(),
        ];

        // Users for assigned filter
        $users = User::select('id','name')->orderBy('name')->get();

        // Return view with everything
        return view('dashboard', compact(
            'leads','estimates','complaints','counts','users',
            'search','fromDate','toDate','assigned',
            'leadStatus','estimateStatus','complaintStatus'
        ));
    }
}

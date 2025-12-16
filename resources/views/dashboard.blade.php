@extends('admin.layouts.app')

@section('title', 'Admin Dashboard')
@push('styles')
    <style>
        /* Card + layout */
        .table-card {
            background: #fff;
            padding: 14px;
            border-radius: 8px;
            box-shadow: 0 8px 22px rgba(10, 15, 30, 0.06);
            transition: transform .18s ease, box-shadow .18s ease;
            overflow: hidden;
        }

        .table-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 14px 34px rgba(10, 15, 30, 0.10);
        }

        /* header */
        .table-card .card-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .card-head h5 {
            margin: 0;
            font-size: 16px;
            font-weight: 700;
            color: #111;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* small SVG icon */
        .card-head svg {
            opacity: .88;
        }

        /* table styling */
        .table-compact {
            width: 100%;
            border-collapse: collapse;
            font-size: 13.5px;
        }

        .table-compact thead th {
            text-align: left;
            font-weight: 700;
            padding: 10px 8px;
            color: #222;
            border-bottom: 2px solid rgba(0, 0, 0, 0.06);
            background: linear-gradient(180deg, rgba(246, 198, 0, 0.08), transparent);
        }

        .table-compact tbody td {
            padding: 10px 8px;
            vertical-align: middle;
            color: #333;
            border-bottom: 1px solid rgba(10, 10, 10, 0.03);
        }

        /* hover row */
        .table-compact tbody tr:hover td {
            background: linear-gradient(90deg, rgba(246, 198, 0, 0.03), rgba(0, 0, 0, 0.01));
            transform: translateX(4px);
            transition: all .12s ease;
        }

        /* status badges */
        .badge-status {
            display: inline-block;
            padding: 6px 8px;
            border-radius: 999px;
            font-weight: 700;
            font-size: 12px;
            color: #fff;
            transition: all .18s ease;
        }

        .badge-new {
            background: #0d6efd;
        }

        /* blue */
        .badge-resolved {
            background: #20c997;
        }

        /* green */
        .badge-assigned {
            background: #ffc107;
            color: #111;
        }

        /* amber */
        .badge-other {
            background: #6c757d;
        }

        /* small meta */
        .small-muted {
            font-size: 13px;
            color: #666;
        }

        /* animated counters on top right */
        .counter {
            font-size: 20px;
            font-weight: 800;
            color: #111;
            display: inline-block;
            min-width: 56px;
            text-align: right;
        }

        /* responsive */
        @media (max-width: 991px) {
            .table-card {
                margin-bottom: 14px;
            }
        }

        /* fade/slide-in animation for rows (staggered by JS) */
        .row-reveal {
            opacity: 0;
            transform: translateY(8px) scale(.995);
        }

        .row-reveal.visible {
            opacity: 1;
            transform: translateY(0) scale(1);
            transition: all .36s cubic-bezier(.2, .9, .3, 1);
        }

        /* small link style */
        .table-compact a {
            color: #0b5ed7;
            text-decoration: none;
        }

        .table-compact a:hover {
            text-decoration: underline;
        }

        /* pagination wrapper styling */
        .pagination-wrapper {
            padding-top: 10px;
            display: flex;
            justify-content: center;
        }
    </style>
@endpush
@push('styles')
    <style>
        .summary-cards {
            display: flex;
            gap: 12px;
            margin-bottom: 18px;
            flex-wrap: wrap;
        }

        .card-small {
            flex: 1;
            min-width: 200px;
            padding: 14px;
            border-radius: 6px;
            background: #fff;
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.06);
        }

        .card-small h3 {
            margin: 0;
            font-size: 22px;
        }

        .filters .row>* {
            margin-bottom: 8px;
        }

        .table-card {
            background: #fff;
            padding: 12px;
            border-radius: 6px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.04);
        }

        .badge-status {
            padding: 6px 8px;
            border-radius: 6px;
        }
    </style>
@endpush

@section('content')

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                <div class="container mb-4">
                    <h2 class="mb-3">Dashboard</h2>

                    {{-- FILTERS --}}
                    <form method="GET" action="{{ route('dashboard') }}" class="filters mb-3">
                        <div class="row g-2">
                            <div class="col-md-3">
                                <input name="search" value="{{ old('search', $search) }}" class="form-control"
                                    placeholder="Search leads, invoices, serial...">
                            </div>

                            <div class="col-md-2">
                                <input type="date" name="created_at" value="{{ old('created_at', $fromDate) }}"
                                    class="form-control">
                            </div>
                            {{-- <div class="col-md-2">
                                <input type="date" name="to_date" value="{{ old('to_date', $toDate) }}"
                                    class="form-control">
                            </div> --}}

                            <div class="col-md-2">
                                <select name="assigned_to" class="form-control">
                                    <option value="">Assigned to</option>
                                    @foreach ($users as $u)
                                        <option value="{{ $u->id }}"
                                            {{ (string) $u->id === (string) $assigned ? 'selected' : '' }}>
                                            {{ $u->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>



                            {{-- per-resource quick status filters --}}
                            <div class="col-12 mt-2">
                                <div class="row">
                                    <div class="col-md-3">
                                        <select name="lead_status" class="form-control">
                                            <option value="">Lead Status</option>
                                            <option value="New" {{ $leadStatus == 'New' ? 'selected' : '' }}>New</option>
                                            <option value="Contacted" {{ $leadStatus == 'Contacted' ? 'selected' : '' }}>
                                                Contacted</option>
                                            <option value="Converted" {{ $leadStatus == 'Converted' ? 'selected' : '' }}>
                                                Converted</option>
                                            <option value="Lost" {{ $leadStatus == 'Lost' ? 'selected' : '' }}>Lost
                                            </option>
                                        </select>
                                    </div>
                                    {{-- <div class="col-md-3">
                                        <select name="estimate_status" class="form-control">
                                            <option value="">Estimate Status</option> --}}
                                    {{-- if you have statuses, include here --}}
                                    {{-- <option value="Draft" {{ $estimateStatus == 'Draft' ? 'selected' : '' }}>Draft
                                            </option>
                                            <option value="Sent" {{ $estimateStatus == 'Sent' ? 'selected' : '' }}>Sent
                                            </option>
                                            <option value="Accepted" {{ $estimateStatus == 'Accepted' ? 'selected' : '' }}>
                                                Accepted</option>
                                        </select>
                                    </div> --}}
                                    <div class="col-md-3">
                                        <select name="complaint_status" class="form-control">
                                            <option value="">Complaint Status</option>
                                            <option value="New" {{ $complaintStatus == 'New' ? 'selected' : '' }}>New
                                            </option>
                                            <option value="Assigned"
                                                {{ $complaintStatus == 'Assigned' ? 'selected' : '' }}>
                                                Assigned</option>
                                            <option value="In Progress"
                                                {{ $complaintStatus == 'In Progress' ? 'selected' : '' }}>In Progress
                                            </option>
                                            <option value="Resolved"
                                                {{ $complaintStatus == 'Resolved' ? 'selected' : '' }}>
                                                Resolved</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 text-end m-2">
                                        <button class="btn btn-primary">Filter</button>
                                        <a href="{{ route('dashboard') }}" class="btn btn-secondary">Reset</a>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </form>

                    {{-- SUMMARY CARDS --}}
                    <div class="summary-cards mb-3">
                        {{-- <div class="card-small">
                            <h3>{{ $counts['leads_new'] }}</h3>
                            <div class="small-muted">New Leads</div>
                        </div> --}}
                        <div class="row">
                            <div class="col-xxl col-sm-6">
                                <div class="card overflow-hidden">
                                    <div class="card-body">
                                        <div class="avatar-sm float-end">
                                            <div class="avatar-title bg-primary-subtle text-primary fs-3xl rounded">
                                                <i class="ph ph-file-text"></i>
                                            </div>
                                        </div>
                                        <h4><span class="counter-value" data-target="{{ $counts['today_leads'] }}">0</span>
                                        </h4>
                                        <p class="text-muted mb-4">Today's Leads</p>

                                    </div>
                                    <div class="progress progress-sm rounded-0" role="progressbar" aria-valuenow="76"
                                        aria-valuemin="0" aria-valuemax="100">
                                        <div class="progress-bar" style="width: 76%"></div>
                                    </div>
                                </div>
                            </div><!--end col-->
                            <div class="col-xxl col-sm-6">
                                <div class="card overflow-hidden">
                                    <div class="card-body">
                                        <div class="avatar-sm float-end">
                                            <div class="avatar-title bg-secondary-subtle text-secondary fs-3xl rounded">
                                                <i class="ph ph-folders"></i>
                                            </div>
                                        </div>
                                        <h4><span class="counter-value"
                                                data-target="{{ $counts['today_estimates'] }}">0</span></h4>
                                        <p class="text-muted mb-4">Today's Estimates</p>

                                    </div>
                                    <div class="progress progress-sm rounded-0" role="progressbar" aria-valuenow="88"
                                        aria-valuemin="0" aria-valuemax="100">
                                        <div class="progress-bar bg-secondary" style="width: 88%"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xxl col-sm-6">
                                <div class="card overflow-hidden">
                                    <div class="card-body">
                                        <div class="avatar-sm float-end">
                                            <div class="avatar-title bg-success-subtle text-success fs-3xl rounded">
                                                <i class="ph ph-chat-circle"></i>
                                            </div>
                                        </div>
                                        <h4><span class="counter-value"
                                                data-target="{{ $counts['today_complaints'] }}">0</span></h4>
                                        <p class="text-muted mb-4">Today's Complaints</p>

                                    </div>
                                    <div class="progress progress-sm rounded-0" role="progressbar" aria-valuenow="88"
                                        aria-valuemin="0" aria-valuemax="100">
                                        <div class="progress-bar bg-success" style="width: 88%"></div>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="card-small">
                                <h3>{{ $counts['estimates_total'] }}</h3>
                                <div class="small-muted">Total Estimates</div>
                            </div>
                            <div class="card-small">
                                <h3>{{ $counts['complaints_new'] }}</h3>
                                <div class="small-muted">New Complaints</div>
                            </div> --}}
                        </div><br><br>

                        {{-- TABLES: use responsive columns --}}
                        {{-- <div class="row g-3 ms-3"> --}}
                        {{-- LEADS --}}
                        {{-- <div class="col-lg-12 col-md-12">
                                <div class="table-card">
                                    <div class="card-head">
                                        <h5>
                                            <!-- SVG users icon -->
                                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                                                aria-hidden>
                                                <path
                                                    d="M12 12c2.7 0 8 1.35 8 4v2H4v-2c0-2.65 5.3-4 8-4zM12 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8z"
                                                    fill="#111" />
                                            </svg>
                                            Leads
                                        </h5>
                                            <a href="{{ route('leads.index') }}"
                                                class="btn btn-sm btn-outline-secondary ms-2">View all</a>
                                        
                                    </div> --}}
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card" id="contactList">
                                    <div class="card-header align-items-center d-flex">
                                        <h4 class="card-title mb-0 flex-grow-1">Leads</h4>
                                        <a href="{{ route('leads.index') }}" class="text-muted">View All <i
                                                class="ph-caret-right align-middle"></i></a>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table
                                                class="table table-borderless table-centered align-middle table-nowrap mb-0">
                                                <thead class="text-muted table-light">
                                                    <tr>
                                                        <th scope="col" class="sort cursor-pointer" data-sort="name">
                                                            Name
                                                        </th>
                                                        <th scope="col" class="sort cursor-pointer"
                                                            data-sort="status">Status
                                                        </th>

                                                        <th scope="col" class="sort cursor-pointer"
                                                            data-sort="received">Received
                                                        </th>
                                                        <th scope="col" class="sort cursor-pointer"
                                                            data-sort="Action">Action
                                                        </th>

                                                    </tr>
                                                </thead>
                                                <tbody class="list">
                                                    @forelse($leads as $idx => $l)
                                                        <tr class="row-reveal" data-delay="{{ $idx * 60 }}">
                                                            <td><a
                                                                    href="{{ route('leads.show', $l->lead_id) }}">{{ \Illuminate\Support\Str::limit($l->customer_name, 30) }}</a>
                                                            </td>
                                                            <td>

                                                                @php
                                                                    $statusColors = [
                                                                        'New' => 'primary',
                                                                        'Contacted' => 'secondary',
                                                                        'Qualified' => 'info',
                                                                        'Quoted' => 'warning',
                                                                        'Lost' => 'danger',
                                                                        'Converted' => 'success', // Add more statuses if needed
                                                                    ];
                                                                @endphp

                                                                <span
                                                                    class="badge bg-{{ $statusColors[$l->status] ?? 'secondary' }}">
                                                                    {{ $l->status }}
                                                                </span>
                                                            </td>
                                                            <td class="small-muted">
                                                                {{ optional($l->created_at)->format('d/m/Y') }}</td>
                                                            <td><a href="{{ route('leads.show', $l->lead_id) }}"
                                                                    class="btn btn-sm btn-info">View</a></td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="3" class="small-muted">No leads found.</td>
                                                        </tr>
                                                    @endforelse

                                                </tbody>
                                            </table>

                                            <div class="pagination-wrapper">
                                                {{ $leads->appends(request()->except('leads_page'))->links() }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- ESTIMATES --}}
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card" id="contactList">
                                    <div class="card-header align-items-center d-flex">
                                        <h4 class="card-title mb-0 flex-grow-1">Estimates</h4>
                                        <a href="{{ route('estimates.index') }}" class="text-muted">View All
                                            <i class="ph-caret-right align-middle"></i></a>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table
                                                class="table table-borderless table-centered align-middle table-nowrap mb-0">
                                                <thead class="text-muted table-light">
                                                    <tr>
                                                        <th scope="col" class="sort cursor-pointer"
                                                            data-sort="Invoice">Invoice
                                                        </th>
                                                        <th scope="col" class="sort cursor-pointer"
                                                            data-sort="Client">Client
                                                        </th>

                                                        <th scope="col" class="sort cursor-pointer" data-sort="Date">
                                                            Date
                                                        </th>
                                                        <th scope="col" class="sort cursor-pointer"
                                                            data-sort="Action">Action
                                                        </th>

                                                    </tr>
                                                </thead>
                                                <tbody class="list">

                                                    @forelse($estimates as $idx => $e)
                                                        <tr class="row-reveal" data-delay="{{ $idx * 60 }}">
                                                            <td><a
                                                                    href="{{ route('estimates.show', $e) }}">{{ $e->invoice_no }}</a>
                                                            </td>
                                                            <td>{{ \Illuminate\Support\Str::limit($e->client_name, 20) }}
                                                            </td>
                                                            <td class="small-muted">
                                                                {{ optional($e->created_at)->format('d/m/Y') }}
                                                            </td>
                                                            <td><a href="{{ route('estimates.show', $e) }}"
                                                                    class="btn btn-sm btn-info">View</a><a
                                                                    href="{{ route('estimates.pdf', $e) }}"
                                                                    class="btn btn-sm btn-secondary ms-2">PDF</a>
                                                            </td>

                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="3" class="small-muted">No
                                                                estimates found.</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>

                                            <div class="pagination-wrapper">
                                                {{ $estimates->appends(request()->except('estimates_page'))->links() }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- container -->
                        </div>

                        {{-- COMPLAINTS --}}
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card" id="contactList">
                                    <div class="card-header align-items-center d-flex">
                                        <h4 class="card-title mb-0 flex-grow-1">Complaints</h4>
                                        <a href="{{ route('complaints.index') }}" class="text-muted">View All
                                            <i class="ph-caret-right align-middle"></i></a>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table
                                                class="table table-borderless table-centered align-middle table-nowrap mb-0">
                                                <thead class="text-muted table-light">
                                                    <tr>
                                                        <th scope="col" class="sort cursor-pointer"
                                                            data-sort="Customer">Customer
                                                        </th>
                                                        <th scope="col" class="sort cursor-pointer"
                                                            data-sort="Status">Status
                                                        </th>

                                                        <th scope="col" class="sort cursor-pointer"
                                                            data-sort="Reported">
                                                            Reported
                                                        </th>
                                                        </th>
                                                        <th scope="col" class="sort cursor-pointer"
                                                            data-sort="Action">Action
                                                        </th>

                                                    </tr>
                                                </thead>
                                                <tbody class="list">
                                                    @forelse($complaints as $idx => $c)
                                                        <tr class="row-reveal" data-delay="{{ $idx * 60 }}">
                                                            <td><a
                                                                    href="{{ route('complaints.show', $c) }}">{{ \Illuminate\Support\Str::limit($c->customer_name, 26) }}</a>
                                                            </td>
                                                            <td>
                                                                @php
                                                                    $ccls =
                                                                        $c->status == 'New'
                                                                            ? 'badge-new'
                                                                            : ($c->status == 'Resolved'
                                                                                ? 'badge-resolved'
                                                                                : 'badge-assigned');
                                                                @endphp
                                                                <span
                                                                    class="badge-status {{ $ccls }}">{{ $c->status }}</span>
                                                            </td>
                                                            <td class="small-muted">
                                                                {{ optional($c->created_at)->format('d/m/Y') }}
                                                            </td>
                                                            <td><a href="{{ route('complaints.show', $c) }}"
                                                                    class="btn btn-sm btn-info">View</a></td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="3" class="small-muted">No
                                                                complaints found.</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>

                                            <div class="pagination-wrapper">
                                                {{ $complaints->appends(request()->except('complaints_page'))->links() }}
                                            </div>

                                        </div>
                                    </div>
                                </div>


                            </div><!-- container -->
                        </div>
                    </div>
                </div>
                @push('scripts')
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            // animate counters
                            document.querySelectorAll('.counter').forEach(function(el) {
                                const target = parseInt(el.getAttribute('data-target') || 0, 10);
                                let current = 0;
                                const step = Math.max(1, Math.floor(target / 25));
                                const id = setInterval(() => {
                                    current += step;
                                    if (current >= target) {
                                        el.textContent = target;
                                        clearInterval(id);
                                    } else el.textContent = current;
                                }, 18);
                            });

                            // staggered reveal of rows
                            const rows = Array.from(document.querySelectorAll('.row-reveal'));
                            rows.forEach((r, i) => {
                                const delay = parseInt(r.getAttribute('data-delay') || (i * 40), 10);
                                setTimeout(() => r.classList.add('visible'), 120 + delay);
                            });

                            // quick hover micro-translate (for accessibility)
                            document.querySelectorAll('.table-compact tbody tr').forEach(tr => {
                                tr.addEventListener('mouseenter', () => tr.style.transform = 'translateX(4px)');
                                tr.addEventListener('mouseleave', () => tr.style.transform = '');
                            });
                        });
                    </script>
                @endpush
            @endsection

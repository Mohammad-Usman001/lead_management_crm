@extends('admin.layouts.app')

@section('title', 'Lead #' . ($lead->lead_id ?? ''))

@push('styles')
    <style>
        .lead-card {
            background: #fff;
            border-radius: 6px;
            padding: 18px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.06);
        }

        .lead-row {
            margin-bottom: 12px;
        }

        .lead-label {
            font-weight: 700;
            color: #333;
        }

        .lead-value {
            color: #222;
        }

        .features-badge {
            display: inline-block;
            background: #f1f1f1;
            padding: 6px 8px;
            margin: 4px 6px 4px 0;
            border-radius: 4px;
            font-size: 13px;
        }

        .meta-box {
            background: #fafafa;
            padding: 10px;
            border-radius: 6px;
        }

        .actions {
            gap: 8px;
            display: flex;
            flex-wrap: wrap;
        }

        .small-muted {
            color: #666;
            font-size: 13px;
        }
    </style>
@endpush

@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="container">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h2>Lead Details</h2>
                        <div class="actions">
                            <a href="{{ route('leads.index') }}" class="btn btn-secondary btn-sm">Back to list</a>
                            <a href="{{ route('leads.edit', $lead->lead_id) }}" class="btn btn-warning btn-sm">Edit</a>

                            <!-- Convert to Estimate (passes lead id as query param to prefill estimate form) -->
                            <a href="{{ route('estimates.create') }}?lead_id={{ $lead->lead_id }}"
                                class="btn btn-primary btn-sm">
                                Convert → Estimate
                            </a>

                            <!-- Delete -->
                            <form action="{{ route('leads.destroy', $lead->lead_id) }}" method="POST"
                                onsubmit="return confirm('Delete this lead?');" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </div>
                    </div>

                    <div class="lead-card">

                        <!-- Basic info row -->
                        <div class="row lead-row">
                            <div class="col-md-6">
                                <div class="lead-label">Customer / Contact Name</div>
                                <div class="lead-value"><strong>{{ $lead->customer_name ?? '-' }}</strong></div>
                            </div>
                            <div class="col-md-6 text-md-end mt-2">
                                {{-- <div class="small-muted">Lead ID: {{ $lead->lead_id }}</div> --}}
                                <div class="small-muted">Created:
                                    <strong>{{ $lead->created_at ? $lead->created_at->format('d/m/Y') : '-' }}</strong>
                                </div>
                            </div>
                        </div>

                        <div class="row lead-row mt-2">
                            <div class="col-md-4">
                                <div class="lead-label">Primary Phone</div>
                                <div class="lead-value"><strong>{{ $lead->contact_number ?? '-' }}</strong></div>
                            </div>

                        </div>

                        <hr>

                        <div class="row lead-row">
                            <div class="col-md-12">
                                <div class="lead-label">Site / Installation Address</div>
                                <div class="lead-value"><strong>{!! nl2br(e($lead->site_address ?? '-')) !!}</strong></div>
                            </div>
                        </div>

                        <div class="row lead-row">
                            <div class="col-md-3">
                                <div class="lead-label">City / Locality</div>
                                <div class="lead-value">{{ $lead->city ?? '-' }}</div>
                            </div>
                            <div class="col-md-3">
                                <div class="lead-label">Property Type</div>
                                <div class="lead-value">{{ $lead->property_type ?? '-' }}</div>
                            </div>
                            <div class="col-md-3">
                                <div class="lead-label">Approx. Area</div>
                                <div class="lead-value">{{ $lead->site_area ?? '-' }}</div>
                            </div>
                            <div class="col-md-3">
                                <div class="lead-label">Estimated Budget</div>
                                <div class="lead-value"><strong>{{ $lead->budget ? '₹ ' . $lead->budget : '-' }}</strong>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="row lead-row">
                            <div class="col-md-3">
                                <div class="lead-label">CCTV Cameras (approx)</div>
                                <div class="lead-value"><strong>{{ $lead->num_cameras ?? 0 }}</strong></div>
                            </div>
                            <div class="col-md-3">
                                <div class="lead-label">Camera Type</div>
                                <div class="lead-value"><strong>{{ $lead->camera_type ?? '-' }}</strong></div>
                            </div>
                            <div class="col-md-3">
                                <div class="lead-label">Installation Required</div>
                                <div class="lead-value"><strong>{{ $lead->installation_required ?? '-' }}</strong></div>
                            </div>
                            <div class="col-md-3">
                                <div class="lead-label">Preferred Visit</div>
                                <div class="lead-value">
                                    <strong>{{ $lead->preferred_date ? \Carbon\Carbon::parse($lead->preferred_date)->format('d/m/Y') : '-' }}</strong>
                                </div>
                            </div>

                            <div class="row lead-row mt-3">
                                <div class="col-12">
                                    <div class="lead-label">Features Requested</div>
                                    <div>
                                        @php
                                            $features = is_array($lead->features)
                                                ? $lead->features
                                                : json_decode($lead->features, true) ?? [];
                                        @endphp

                                        {{-- @if (count($features))
                  @foreach ($features as $f)
                    <span class="features-badge"><strong>{{ $f }}</strong></span>
                  @endforeach
                @else
                  <span class="small-muted">None specified</span>
                @endif --}}
                                        @if (count($features))
                                            <strong>{{ implode(', ', $features) }}</strong>
                                        @else
                                            <span class="small-muted">None specified</span>
                                        @endif

                                    </div>
                                </div>
                            </div>

                            <hr>

                            <div class="row lead-row">
                                <div class="col-md-4">
                                    <div class="lead-label">Lead Source</div>
                                    <div class="lead-value">{{ $lead->lead_source ?? '-' }}</div>
                                </div>
                                <div class="col-md-4">
                                    <div class="lead-label">Status</div>
                                    <div class="lead-value"><strong>{{ $lead->status ?? '-' }}</strong></div>
                                </div>
                                <div class="col-md-4">
                                    <div class="lead-label">Follow Up Date</div>
                                    <div class="lead-value">
                                        <strong>{{ $lead->follow_up_date ? \Carbon\Carbon::parse($lead->follow_up_date)->format('d/m/Y') : '-' }}</strong>
                                    </div>
                                </div>
                            </div>

                            <div class="row lead-row">
                                <div class="col-12">
                                    <div class="lead-label">Internal Notes</div>
                                    <div class="lead-value"><strong>{!! nl2br(e($lead->notes ?? '-')) !!}</strong></div>
                                </div>
                            </div>

                            <div class="mt-3">
                                <a href="{{ route('leads.index') }}" class="btn btn-outline-secondary btn-sm">Back</a>
                                <a href="{{ route('leads.edit', $lead->lead_id) }}" class="btn btn-warning btn-sm">Edit
                                    Lead</a>
                                <a href="{{ route('estimates.create') }}?lead_id={{ $lead->lead_id }}"
                                    class="btn btn-primary btn-sm">Create Estimate</a>
                            </div>

                        </div> <!-- .lead-card -->

                    </div>
                </div>
            </div>
        </div>
    @endsection

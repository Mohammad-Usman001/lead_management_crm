@extends('admin.layouts.app')

@section('title', 'Complaint #' . $complaint->id)

@section('content')
    <div class="main-content">
        <div class="page-content">

            <div class="container-fluid">
                <div class="container mb-4">
                    <div class="container">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h2>Complaint {{ $complaint->created_at->format('d/m/Y') }}</h2>
                            <div>
                                <a href="{{ route('complaints.edit', $complaint) }}" class="btn btn-warning">Edit</a>
                                <a href="{{ route('complaints.index') }}" class="btn btn-secondary">Back</a>
                            </div>
                        </div>

                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <div class="card p-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5>Customer</h5>
                                    <p><strong>{{ $complaint->customer_name }}</strong><br>{{ $complaint->contact_number }}
                                    </p>

                                    <h6>Address</h6>
                                    <p>{!! nl2br(e($complaint->site_address)) !!}</p>

                                    <h6>City / Location</h6>
                                    <p>{{ $complaint->city }} <br> <small>{{ $complaint->location_detail }}</small></p>
                                </div>

                                <div class="col-md-6">
                                    <h5>Complaint Info</h5>
                                    <p><strong>Device:</strong> {{ $complaint->device_type }} <br>
                                        <strong>Serial:</strong> {{ $complaint->serial_number }}<br>
                                        <strong>Priority:</strong> {{ $complaint->priority }}<br>
                                        <strong>Status:</strong> {{ $complaint->status }}<br>
                                        <strong>Assigned to:</strong> {{ optional($complaint->assignedUser)->name }}
                                    </p>

                                    <strong>Reported:</strong>
                                    {{ optional($complaint->reported_at)->format('d/m/Y H:i') }}<br>
                                    <strong>Scheduled Visit:</strong>
                                    {{ optional($complaint->scheduled_visit)->format('d/m/Y H:i') }}
                                </div>
                            </div>

                            <hr>
                            <h6>Issue Description</h6>
                            <p>{!! nl2br(e($complaint->issue_description)) !!}</p>

                            <h6>Technician Notes</h6>
                            <p>{!! nl2br(e($complaint->technician_notes)) !!}</p>

                            @if ($complaint->images->count())
                                <hr>
                                <h6>Photos</h6>
                                <div class="row">
                                    @foreach ($complaint->images as $img)
                                        <div class="col-md-3 mb-2">
                                            <a href="{{ asset('storage/' . $img->path) }}" target="_blank">
                                                <img src="{{ asset('storage/' . $img->path) }}" class="img-fluid border"
                                                    alt="{{ $img->original_name }}">
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

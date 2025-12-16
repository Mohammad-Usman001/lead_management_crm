@extends('admin.layouts.app')

@section('title', 'Edit Complaint')

@section('content')
    <div class="main-content">
        <div class="page-content">

            <div class="container-fluid">
                <div class="container mb-4">
                    <div class="container">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h2>Edit Complaint</h2>
                            <a href="{{ route('complaints.show', $complaint) }}" class="btn btn-secondary">Back</a>
                        </div>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $err)
                                        <li>{{ $err }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('complaints.update', $complaint) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf @method('PUT')

                            <div class="row">
                                <div class="col-md-6">
                                    <label>Customer / Contact Name</label>
                                    <input type="text" name="customer_name" class="form-control"
                                        value="{{ old('customer_name', $complaint->customer_name) }}" required>

                                    <label class="mt-2">Contact Number</label>
                                    <input type="text" name="contact_number" class="form-control"
                                        value="{{ old('contact_number', $complaint->contact_number) }}">

                                    <label class="mt-2">Site / Address</label>
                                    <textarea name="site_address" class="form-control" rows="3">{{ old('site_address', $complaint->site_address) }}</textarea>

                                    <label class="mt-2">City</label>
                                    <input type="text" name="city" class="form-control"
                                        value="{{ old('city', $complaint->city) }}">
                                </div>

                                <div class="col-md-6">
                                    <label>Location detail</label>
                                    <input type="text" name="location_detail" class="form-control"
                                        value="{{ old('location_detail', $complaint->location_detail) }}">

                                    <label class="mt-2">Device Type</label>
                                    <input type="text" name="device_type" class="form-control"
                                        value="{{ old('device_type', $complaint->device_type) }}">

                                    <label class="mt-2">Serial / Model</label>
                                    <input type="text" name="serial_number" class="form-control"
                                        value="{{ old('serial_number', $complaint->serial_number) }}">

                                    <label class="mt-2">Issue Description</label>
                                    <textarea name="issue_description" class="form-control" rows="3">{{ old('issue_description', $complaint->issue_description) }}</textarea>

                                    <label class="mt-2">Priority</label>
                                    <select name="priority" class="form-control">
                                        <option value="Low"
                                            {{ old('priority', $complaint->priority) == 'Low' ? 'selected' : '' }}>Low
                                        </option>
                                        <option value="Medium"
                                            {{ old('priority', $complaint->priority) == 'Medium' ? 'selected' : '' }}>
                                            Medium
                                        </option>
                                        <option value="High"
                                            {{ old('priority', $complaint->priority) == 'High' ? 'selected' : '' }}>High
                                        </option>
                                    </select>

                                    <label class="mt-2">Status</label>
                                    <select name="status" class="form-control">
                                        @foreach (['New', 'Assigned', 'In Progress', 'Resolved', 'Closed', 'Rejected'] as $s)
                                            <option value="{{ $s }}"
                                                {{ old('status', $complaint->status) == $s ? 'selected' : '' }}>
                                                {{ $s }}</option>
                                        @endforeach
                                    </select>

                                    <label class="mt-2">Assign To</label>
                                    <select name="assigned_to" class="form-control">
                                        <option value="">-- Select technician --</option>
                                        @foreach ($users as $u)
                                            <option value="{{ $u->id }}"
                                                {{ old('assigned_to', $complaint->assigned_to) == $u->id ? 'selected' : '' }}>
                                                {{ $u->name }}</option>
                                        @endforeach
                                    </select>

                                    <label class="mt-2">Scheduled Visit</label>
                                    <input type="datetime-local" name="scheduled_visit" class="form-control"
                                        value="{{ old('scheduled_visit', $complaint->scheduled_visit ? $complaint->scheduled_visit->format('Y-m-d\TH:i') : '') }}">

                                    <label class="mt-2">Technician Notes</label>
                                    <textarea name="technician_notes" class="form-control" rows="3">{{ old('technician_notes', $complaint->technician_notes) }}</textarea>

                                    <label class="mt-2">Add Photos</label>
                                    <input type="file" name="images[]" multiple class="form-control">
                                </div>
                            </div>

                            <div class="mt-3"><button class="btn btn-success">Update Complaint</button></div>
                        </form>

                        @if ($complaint->images->count())
                            <hr>
                            <h5>Attached Photos</h5>
                            <div class="row">
                                @foreach ($complaint->images as $img)
                                    <div class="col-md-3 mb-2">
                                        <img src="{{ asset('storage/' . $img->path) }}" class="img-fluid border"
                                            alt="{{ $img->original_name }}">
                                        <form
                                            action="{{ route('complaints.images.remove', ['complaint' => $complaint, 'image' => $img]) }}"
                                            method="POST" onsubmit="return confirm('Remove image?')"
                                            style="margin-top:6px;">
                                            @csrf
                                            <button class="btn btn-sm btn-danger">Remove</button>
                                        </form>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

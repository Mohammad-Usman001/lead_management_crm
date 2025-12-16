@extends('admin.layouts.app')

@section('title', 'New Complaint')

@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="container mb-4">
                    <div class="container">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h2>Register Complaint</h2>
                            <a href="{{ route('complaints.index') }}" class="btn btn-secondary">Back</a>
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

                        <form action="{{ route('complaints.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-md-6">
                                    <label>Customer / Contact Name</label>
                                    <input type="text" name="customer_name" class="form-control"
                                        value="{{ old('customer_name', optional($lead)->customer_name) }}" required>

                                    <label class="mt-2">Contact Number</label>
                                    <input type="text" name="contact_number" class="form-control"
                                        value="{{ old('contact_number', optional($lead)->contact_number) }}">

                                    <label class="mt-2">Lead (optional)</label>
                                    <select name="lead_id" class="form-control">
                                        <option value="">-- none --</option>
                                        @if ($lead)
                                            <option value="{{ $lead->lead_id }}" selected>Lead #{{ $lead->lead_id }} -
                                                {{ $lead->customer_name }}</option>
                                        @endif
                                    </select>

                                    <label class="mt-2">Site / Address</label>
                                    <textarea name="site_address" class="form-control" rows="3">{{ old('site_address', optional($lead)->site_address) }}</textarea>

                                    <label class="mt-2">City</label>
                                    <input type="text" name="city" class="form-control"
                                        value="{{ old('city', optional($lead)->city) }}">
                                </div>

                                <div class="col-md-6">
                                    <label>Location detail (e.g. "Gate pillar left")</label>
                                    <input type="text" name="location_detail" class="form-control"
                                        value="{{ old('location_detail') }}">

                                    <label class="mt-2">Device Type</label>
                                    <input type="text" name="device_type" class="form-control"
                                        value="{{ old('device_type') }}" placeholder="2.4 MP CCTV Camera">

                                    <label class="mt-2">Serial / Model</label>
                                    <input type="text" name="serial_number" class="form-control"
                                        value="{{ old('serial_number') }}">

                                    <label class="mt-2">Issue Description</label>
                                    <textarea name="issue_description" class="form-control" rows="3">{{ old('issue_description') }}</textarea>

                                    <label class="mt-2">Priority</label>
                                    <select name="priority" class="form-control">
                                        <option value="Low" {{ old('priority') == 'Low' ? 'selected' : '' }}>Low
                                        </option>
                                        <option value="Medium" {{ old('priority') == 'Medium' ? 'selected' : '' }}>Medium
                                        </option>
                                        <option value="High" {{ old('priority') == 'High' ? 'selected' : '' }}>High
                                        </option>
                                    </select>

                                    <label class="mt-2">Assign To</label>
                                    <select name="assigned_to" class="form-control">
                                        <option value="">-- Select technician --</option>
                                        @foreach ($users as $u)
                                            <option value="{{ $u->id }}"
                                                {{ old('assigned_to') == $u->id ? 'selected' : '' }}>{{ $u->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <label class="mt-2">Reported At</label>
                                    <input type="datetime-local" name="reported_at" class="form-control"
                                        value="{{ old('reported_at') }}">

                                    <label class="mt-2">Scheduled Visit</label>
                                    <input type="datetime-local" name="scheduled_visit" class="form-control"
                                        value="{{ old('scheduled_visit') }}">

                                    <label class="mt-2">Attach photos (e.g. damaged cable)</label>
                                    <input type="file" name="images[]" multiple class="form-control">
                                </div>
                            </div>

                            <div class="mt-3">
                                <button class="btn btn-success">Register Complaint</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

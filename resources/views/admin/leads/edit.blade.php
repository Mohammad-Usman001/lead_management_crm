@extends('admin.layouts.app')

@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                <div class="container">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h2>Edit CCTV Lead</h2>
                        <a href="{{ route('leads.index') }}" class="btn btn-secondary">Back to Leads</a>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('leads.update', $lead->lead_id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <!-- LEFT COLUMN -->
                            <div class="col-md-6">

                                <div class="form-group mb-3">
                                    <label>Customer / Contact Name</label>
                                    <input type="text" name="customer_name" class="form-control"
                                        value="{{ old('customer_name', $lead->customer_name) }}" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label>Primary Phone</label>
                                    <input type="tel" name="contact_number" class="form-control"
                                        value="{{ old('contact_number', $lead->contact_number) }}" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label>Site / Installation Address</label>
                                    <textarea name="site_address" class="form-control" rows="3">{{ old('site_address', $lead->site_address) }}</textarea>
                                </div>

                                <div class="form-group mb-3">
                                    <label>City / Locality</label>
                                    <input type="text" name="city" class="form-control"
                                        value="{{ old('city', $lead->city) }}">
                                </div>

                                <div class="form-group mb-3">
                                    <label>Property Type</label>
                                    <select name="property_type" class="form-control">
                                        <option value="Residential" {{ $lead->property_type == 'Residential' ? 'selected' : '' }}>
                                            Residential</option>
                                        <option value="Commercial" {{ $lead->property_type == 'Commercial' ? 'selected' : '' }}>
                                            Commercial</option>
                                        <option value="Industrial" {{ $lead->property_type == 'Industrial' ? 'selected' : '' }}>
                                            Industrial</option>
                                    </select>
                                </div>

                                <div class="form-group mb-3">
                                    <label>Approx. Area</label>
                                    <input type="text" name="site_area" class="form-control"
                                        value="{{ old('site_area', $lead->site_area) }}">
                                </div>

                            </div>

                            <!-- RIGHT COLUMN -->
                            <div class="col-md-6">

                                <div class="form-group mb-3">
                                    <label>Number of Cameras</label>
                                    <input type="number" min="0" name="num_cameras" class="form-control"
                                        value="{{ old('num_cameras', $lead->num_cameras) }}">
                                </div>

                                <div class="form-group mb-3">
                                    <label>Camera Type</label>
                                    <select name="camera_type" class="form-control">
                                        <option value="WI-FI" {{ $lead->camera_type == 'WI-FI' ? 'selected' : '' }}>WI-FI
                                        </option>
                                        <option value="HD-Camera" {{ $lead->camera_type == 'HD-Camera' ? 'selected' : '' }}>HD
                                            Camera</option>
                                        <option value="IP Camera" {{ $lead->camera_type == 'IP Camera' ? 'selected' : '' }}>IP
                                            Camera</option>
                                    </select>
                                </div>

                                <div class="form-group mb-3">
                                    <label>Features Required</label>

                                    @php
                                        $selected = is_array($lead->features)
                                            ? $lead->features
                                            : json_decode($lead->features, true) ?? [];
                                    @endphp

                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="features[]"
                                                    value="Night Vision"
                                                    {{ in_array('Night Vision', $selected) ? 'checked' : '' }}>
                                                <label class="form-check-label">Night Vision</label>
                                            </div>

                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="features[]"
                                                    value="Remote Viewing"
                                                    {{ in_array('Remote Viewing', $selected) ? 'checked' : '' }}>
                                                <label class="form-check-label">Remote Viewing</label>
                                            </div>

                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="features[]"
                                                    value="PTZ" {{ in_array('PTZ', $selected) ? 'checked' : '' }}>
                                                <label class="form-check-label">PTZ / Motorized</label>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="features[]"
                                                    value="Infrared"
                                                    {{ in_array('Infrared', $selected) ? 'checked' : '' }}>
                                                <label class="form-check-label">Infrared / Low Light</label>
                                            </div>

                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="features[]"
                                                    value="Audio" {{ in_array('Audio', $selected) ? 'checked' : '' }}>
                                                <label class="form-check-label">Two-way Audio</label>
                                            </div>

                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="features[]"
                                                    value="Cloud" {{ in_array('Cloud', $selected) ? 'checked' : '' }}>
                                                <label class="form-check-label">Cloud Storage</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group mb-3">
                                    <label>Installation Required?</label>
                                    <select name="installation_required" class="form-control">
                                        <option value="Yes" {{ $lead->installation_required == 'Yes' ? 'selected' : '' }}>Yes
                                        </option>
                                        <option value="No" {{ $lead->installation_required == 'No' ? 'selected' : '' }}>No
                                            (Supply only)</option>
                                    </select>
                                </div>

                                <div class="form-group mb-3">
                                    <label>Preferred Visit Date</label>
                                    <input type="datetime-local" name="preferred_date" class="form-control"
                                        value="{{ $lead->preferred_date ? $lead->preferred_date->format('Y-m-d\TH:i') : '' }}">
                                </div>

                                <div class="form-group mb-3">
                                    <label>Budget</label>
                                    <input type="text" name="budget" class="form-control"
                                        value="{{ old('budget', $lead->budget) }}">
                                </div>

                                <div class="form-group mb-3">
                                    <label>Lead Source</label>
                                    <select name="lead_source" class="form-control">
                                        <option value="Walk-in" {{ $lead->lead_source == 'Walk-in' ? 'selected' : '' }}>Walk-in
                                        </option>
                                        <option value="Referral" {{ $lead->lead_source == 'Referral' ? 'selected' : '' }}>
                                            Referral</option>
                                        <option value="Social Media"
                                            {{ $lead->lead_source == 'Social Media' ? 'selected' : '' }}>Social Media</option>
                                        <option value="Telemark" {{ $lead->lead_source == 'Telemark' ? 'selected' : '' }}>
                                            Tele/Call</option>
                                    </select>
                                </div>

                                <div class="form-group mb-3">
                                    <label>Status</label>
                                    <select name="status" class="form-control">
                                        <option value="New" {{ $lead->status == 'New' ? 'selected' : '' }}>New</option>
                                        <option value="Contacted" {{ $lead->status == 'Contacted' ? 'selected' : '' }}>Contacted
                                        </option>
                                        <option value="Site Survey" {{ $lead->status == 'Site Survey' ? 'selected' : '' }}>Site
                                            Survey</option>
                                        <option value="Quoted" {{ $lead->status == 'Quoted' ? 'selected' : '' }}>Quoted</option>
                                        <option value="Converted" {{ $lead->status == 'Converted' ? 'selected' : '' }}>Converted
                                        </option>
                                        <option value="Lost" {{ $lead->status == 'Lost' ? 'selected' : '' }}>Lost</option>
                                    </select>
                                </div>

                                <div class="form-group mb-3">
                                    <label>Follow Up Date</label>
                                    <input type="datetime-local" name="follow_up_date" class="form-control"
                                        value="{{ $lead->follow_up_date ? $lead->follow_up_date->format('Y-m-d\TH:i') : '' }}">
                                </div>

                                <div class="form-group mb-3">
                                    <label>Internal Notes</label>
                                    <textarea name="notes" rows="3" class="form-control">{{ old('notes', $lead->notes) }}</textarea>
                                </div>

                                <button type="submit" class="btn btn-success">Update Lead</button>
                            </div>
                        </div>

                    </form>

                </div>

            </div>
        </div>
    </div>
@endsection

@extends('admin.layouts.app')

@section('content')
<div class="main-content">
  <div class="page-content">
    <div class="container-fluid">
      <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h2>Add New CCTV Lead</h2>
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

        <form action="{{ route('leads.store') }}" method="POST">
          @csrf

          <div class="row">
            <!-- Left column: customer & site -->
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label>Customer / Contact Name</label>
                <input type="text" name="customer_name" class="form-control" value="{{ old('customer_name') }}" required>
              </div>

              <div class="form-group mb-3">
                <label>Primary Phone</label>
                <input type="tel" name="contact_number" class="form-control" value="{{ old('contact_number') }}" required>
              </div>

            
              <div class="form-group mb-3">
                <label>Site / Installation Address</label>
                <textarea name="site_address" class="form-control" rows="3">{{ old('site_address') }}</textarea>
              </div>

              <div class="form-group mb-3">
                <label>City / Locality</label>
                <input type="text" name="city" class="form-control" value="{{ old('city') }}">
              </div>

              <div class="form-group mb-3">
                <label>Property Type</label>
                <select name="property_type" class="form-control">
                  <option value="Residential" {{ old('property_type')=='Residential' ? 'selected' : '' }}>Residential</option>
                  <option value="Commercial"  {{ old('property_type')=='Commercial' ? 'selected' : '' }}>Commercial</option>
                  <option value="Industrial"  {{ old('property_type')=='Industrial' ? 'selected' : '' }}>Industrial</option>
                </select>
              </div>

              <div class="form-group mb-3">
                <label>Approx. Area (sq.ft / sq.m)</label>
                <input type="text" name="site_area" class="form-control" value="{{ old('site_area') }}" placeholder="e.g. 1500 sqft">
              </div>
            </div>

            <!-- Right column: CCTV specifics & administrative -->
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label>Number of Cameras (approx)</label>
                <input type="number" min="0" name="num_cameras" class="form-control" value="{{ old('num_cameras', 0) }}">
              </div>

              <div class="form-group mb-3">
                <label>Camera Type</label>
                <select name="camera_type" class="form-control">
                  <option value="WI-FI" {{ old('camera_type')=='WI-FI' ? 'selected' : '' }}>WI-FI Camera</option>
                  <option value="HD-Camera" {{ old('camera_type')=='HD-Camera' ? 'selected' : '' }}>HD-Camera</option>
                  <option value="IP Camera" {{ old('camera_type')=='IP Camera' ? 'selected' : '' }}>IP Camera</option>
                </select>
              </div>

              <div class="form-group mb-3">
                <label>Features Required</label>
                <div class="row">
                  <div class="col-6">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="features[]" value="Night Vision" id="f1"
                        {{ is_array(old('features')) && in_array('Night Vision', old('features')) ? 'checked' : '' }}>
                      <label class="form-check-label" for="f1">Night Vision</label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="features[]" value="Remote Viewing" id="f2"
                        {{ is_array(old('features')) && in_array('Remote Viewing', old('features')) ? 'checked' : '' }}>
                      <label class="form-check-label" for="f2">Remote Viewing (Mobile)</label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="features[]" value="PTZ" id="f3"
                        {{ is_array(old('features')) && in_array('PTZ', old('features')) ? 'checked' : '' }}>
                      <label class="form-check-label" for="f3">PTZ / Motorized</label>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="features[]" value="Infrared" id="f4"
                        {{ is_array(old('features')) && in_array('Infrared', old('features')) ? 'checked' : '' }}>
                      <label class="form-check-label" for="f4">Infrared / Low Light</label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="features[]" value="Audio" id="f5"
                        {{ is_array(old('features')) && in_array('Audio', old('features')) ? 'checked' : '' }}>
                      <label class="form-check-label" for="f5">Two-way Audio / Mic</label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="features[]" value="Cloud" id="f6"
                        {{ is_array(old('features')) && in_array('Cloud', old('features')) ? 'checked' : '' }}>
                      <label class="form-check-label" for="f6">Cloud Storage</label>
                    </div>
                  </div>
                </div>
              </div>

              <div class="form-group mb-3">
                <label>Installation Required?</label>
                <select name="installation_required" class="form-control">
                  <option value="Yes" {{ old('installation_required')=='Yes' ? 'selected' : '' }}>Yes</option>
                  <option value="No" {{ old('installation_required')=='No' ? 'selected' : '' }}>No (Supply only)</option>
                </select>
              </div>

              <div class="form-group mb-3">
                <label>Preferred Site Visit / Installation Date</label>
                <input type="datetime-local" name="preferred_date" class="form-control" value="{{ old('preferred_date') }}">
              </div>

              <div class="form-group mb-3">
                <label>Estimated Budget (optional)</label>
                <input type="text" name="budget" class="form-control" value="{{ old('budget') }}" placeholder="e.g. ₹25,000">
              </div>

              <div class="form-group mb-3">
                <label>Lead Source</label>
                <select name="lead_source" class="form-control">
                  <option value="Walk-in" {{ old('lead_source')=='Walk-in' ? 'selected' : '' }}>Walk-in</option>
                  <option value="Referral" {{ old('lead_source')=='Referral' ? 'selected' : '' }}>Referral</option>
                  <option value="Social Media" {{ old('lead_source')=='Social Media' ? 'selected' : '' }}>Social Media</option>
                  <option value="Telemark" {{ old('lead_source')=='Telemark' ? 'selected' : '' }}>Tele/Call</option>
                </select>
              </div>

            

              <div class="form-group mb-3">
                <label>Status</label>
                <select name="status" class="form-control">
                  <option value="New" {{ old('status')=='New' ? 'selected' : '' }}>New</option>
                  <option value="Contacted" {{ old('status')=='Contacted' ? 'selected' : '' }}>Contacted</option>
                  <option value="Site Survey" {{ old('status')=='Site Survey' ? 'selected' : '' }}>Site Survey</option>
                  <option value="Quoted" {{ old('status')=='Quoted' ? 'selected' : '' }}>Quoted</option>
                  <option value="Converted" {{ old('status')=='Converted' ? 'selected' : '' }}>Converted</option>
                  <option value="Lost" {{ old('status')=='Lost' ? 'selected' : '' }}>Lost</option>
                </select>
              </div>

              <div class="form-group mb-3">
                <label>Follow Up Date</label>
                <input type="datetime-local" name="follow_up_date" class="form-control" value="{{ old('follow_up_date') }}">
              </div>

              <div class="form-group mb-3">
                <label>Internal Notes</label>
                <textarea name="notes" rows="3" class="form-control">{{ old('notes') }}</textarea>
              </div>

              <button type="submit" class="btn btn-success">Save Lead</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

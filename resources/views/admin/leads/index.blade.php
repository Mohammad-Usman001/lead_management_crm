@extends('admin.layouts.app')
@push('styles')
<style>
.lead-status {
    font-weight: 600;
}

.lead-status option[value="New"] { color: #0d6efd; }
.lead-status option[value="Contacted"] { color: #6c757d; }
.lead-status option[value="Site Survey"] { color: #0dcaf0; }
.lead-status option[value="Quoted"] { color: #ffc107; }
.lead-status option[value="Converted"] { color: #198754; }
.lead-status option[value="Lost"] { color: #dc3545; }
</style>
@endpush
@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="container mb-4">
                    <form method="GET" action="{{ route('leads.index') }}" class="row g-3">

                        <!-- Search by Name, Email, Status, Service -->
                        <div class="col-md-3">
                            <input type="text" name="search" class="form-control" placeholder="Search leads..."
                                value="{{ request('search') }}">
                        </div>

                        <!--Filter by Date Range -->
                        <div class="col-md-2">
                            <input type="date" name="created_at" class="form-control" value="{{ request('created_at') }}">
                        </div>
                        {{-- <div class="col-md-2">
                            <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
                        </div> --}}

                        

                        <!-- Filter by Lead Source -->
                        <div class="col-md-2">
                            <select name="lead_source" class="form-control">
                                <option value="">Lead Source</option>
                                <option value="Website" {{ request('lead_source') == 'Website' ? 'selected' : '' }}>Website
                                </option>
                                <option value="Referral" {{ request('lead_source') == 'Referral' ? 'selected' : '' }}>
                                    Referral</option>
                                <option value="Social Media"
                                    {{ request('lead_source') == 'Social Media' ? 'selected' : '' }}>Social Media</option>
                                <option value="Event" {{ request('lead_source') == 'Event' ? 'selected' : '' }}>Event
                                </option>
                            </select>
                        </div>

                        <!-- Filter by Status -->
                        <div class="col-md-2">
                            <select name="status" class="form-control">
                                <option value="">Select Status</option>
                                <option value="New" {{ request('status') == 'New' ? 'selected' : '' }}>New</option>
                                <option value="Quoted" {{ request('status') == 'Quoted' ? 'selected' : '' }}>
                                    Quoted</option>
                                <option value="Contacted" {{ request('status') == 'Contacted' ? 'selected' : '' }}>
                                    Contacted</option>
                                <option value="Qualified" {{ request('status') == 'Qualified' ? 'selected' : '' }}>
                                    Qualified</option>
                                <option value="Lost" {{ request('status') == 'Lost' ? 'selected' : '' }}>Lost</option>
                            </select>
                        </div>

                        <!--Sorting -->
                        <div class="col-md-2">
                            <select name="sort_by" class="form-control">
                                <option value="received_date"
                                    {{ request('sort_by') == 'received_date' ? 'selected' : '' }}>Received Date</option>
                                <option value="follow_up_date"
                                    {{ request('sort_by') == 'follow_up_date' ? 'selected' : '' }}>Follow Up Date</option>
                                <option value="status" {{ request('sort_by') == 'status' ? 'selected' : '' }}>Status
                                </option>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <select name="sort_order" class="form-control">
                                <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>Ascending
                                </option>
                                <option value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>Descending
                                </option>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary">Filter</button>
                            <a href="{{ route('leads.index') }}" class="btn btn-secondary">Reset</a>
                        </div>

                    </form>
                </div>

                <div class="container">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h2>Leads Management</h2>
                        <a href="{{ route('leads.create') }}" class="btn btn-primary">Add Lead</a>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <table id="myTable" class="table table-striped">
                        <thead class="thead-dark">
                            <tr>

                                <th>Customer Name</th>

                                <th>Contact Number</th>
                                <th>No. of Cameras</th>

                                <th>Status</th>
                                <th>Lead Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($leads as $lead)
                                <tr>

                                    <td>{{ $lead->customer_name }}</td>

                                    <td>{{ $lead->contact_number }}</td>
                                    <td>{{ $lead->num_cameras }}</td>

                                    <td>
                                        <select class="form-select form-select-sm lead-status"
                                            data-id="{{ $lead->lead_id }}">
                                            @foreach (['New', 'Contacted', 'Site Survey', 'Quoted', 'Converted', 'Lost'] as $status)
                                                <option value="{{ $status }}"
                                                    {{ $lead->status === $status ? 'selected' : '' }}>
                                                    {{ $status }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>

                                    <td>{{ $lead->created_at->format('d-m-Y') }}</td>

                                    <td>
                                        <div class="d-flex gap-1">
                                            <a href="{{ route('leads.show', $lead->lead_id) }}"
                                                class="btn btn-sm btn-info ">View</a>
                                            <a href="{{ route('leads.edit', $lead->lead_id) }}"
                                                class="btn btn-sm btn-primary ">Edit</a>
                                            <form class="delete-lead" action="{{ route('leads.destroy', $lead->lead_id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    type="submit">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {

            document.querySelectorAll('.lead-status').forEach(select => {

                let previousValue = select.value;

                select.addEventListener('focus', function() {
                    previousValue = this.value;
                });

                select.addEventListener('change', function() {

                    let leadId = this.dataset.id;
                    let status = this.value;

                    fetch(`/leads/${leadId}/update-status`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector(
                                    'meta[name="csrf-token"]').content,
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                status
                            })
                        })
                        .then(res => res.json())
                        .then(data => {

                            if (data.success) {
                                Swal.fire({
                                    toast: true,
                                    position: 'top-end',
                                    icon: 'success',
                                    title: 'Status updated successfully',
                                    showConfirmButton: false,
                                    timer: 2000,
                                    timerProgressBar: true
                                });
                            } else {
                                this.value = previousValue;
                                Swal.fire('Error', 'Failed to update status', 'error');
                            }

                        })
                        .catch(() => {
                            this.value = previousValue;
                            Swal.fire('Error', 'Something went wrong', 'error');
                        });

                });
            });

        });
    </script>




@endsection

@extends('admin.layouts.app')

@section('title', 'Complaints')

@section('content')
    <div class="main-content">
        <div class="page-content">

            <div class="container-fluid">
                <div class="container mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h2>Complaints</h2>
                        <a href="{{ route('complaints.create') }}" class="btn btn-primary">New Complaint</a>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form method="GET" class="row g-2 mb-3">
                        <div class="col-md-3"><input name="search" value="{{ request('search') }}" class="form-control"
                                placeholder="Search name, device, serial"></div>
                        <div class="col-md-2">
                            <select name="status" class="form-control">
                                <option value="">Status</option>
                                @foreach (['New', 'Assigned', 'In Progress', 'Resolved', 'Closed', 'Rejected'] as $s)
                                    <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>
                                        {{ $s }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="priority" class="form-control">
                                <option value="">Priority</option>
                                @foreach (['Low', 'Medium', 'High'] as $p)
                                    <option value="{{ $p }}" {{ request('priority') == $p ? 'selected' : '' }}>
                                        {{ $p }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2"><button class="btn btn-primary">Filter</button> <a
                                href="{{ route('complaints.index') }}" class="btn btn-secondary">Reset</a></div>
                    </form>

                    <table id="myTable" class="table table-striped">
                        <thead>
                            <tr>

                                <th>Customer</th>
                                <th>Device</th>

                                <th>Priority</th>
                                <th>Status</th>

                                <th>Reported</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($complaints as $c)
                                <tr>

                                    <td>{{ $c->customer_name }}<br><small>{{ $c->contact_number }}</small></td>
                                    <td>{{ $c->device_type }}</td>

                                    <td>{{ $c->priority }}</td>
                                    <td>
                                        <select class="form-select form-select-sm complaint-status"
                                            data-id="{{ $c->id }}">
                                            @foreach (['New', 'Assigned', 'In Progress', 'Resolved', 'Closed', 'Rejected'] as $status)
                                                <option value="{{ $status }}"
                                                    {{ $c->status === $status ? 'selected' : '' }}>
                                                    {{ $status }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>

                                    <td>{{ optional($c->created_at)->format('d/m/Y') }}</td>
                                    <td>
                                        <a href="{{ route('complaints.show', $c) }}" class="btn btn-sm btn-info">View</a>
                                        <a href="{{ route('complaints.edit', $c) }}"
                                            class="btn btn-sm btn-warning">Edit</a>
                                        <form class="delete-complain" action="{{ route('complaints.destroy', $c) }}"
                                            method="POST" style="display:inline;">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>

                    <div>{{ $complaints->links() }}</div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            document.querySelectorAll('.complaint-status').forEach(select => {

                let previousValue = select.value;

                select.addEventListener('focus', function() {
                    previousValue = this.value;
                });

                select.addEventListener('change', function() {

                    let complaintId = this.dataset.id;
                    let status = this.value;

                    fetch(`/complaints/${complaintId}/update-status`, {
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
                                    title: 'Complaint status updated',
                                    showConfirmButton: false,
                                    timer: 2000,
                                    timerProgressBar: true
                                });
                            } else {
                                select.value = previousValue;
                                Swal.fire('Error', 'Failed to update status', 'error');
                            }
                        })
                        .catch(() => {
                            select.value = previousValue;
                            Swal.fire('Error', 'Something went wrong', 'error');
                        });

                });

            });

        });
    </script>



@endsection

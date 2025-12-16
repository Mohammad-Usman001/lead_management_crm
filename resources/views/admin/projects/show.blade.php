@extends('admin.layouts.app')
@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="container">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <h4 class="mt-4">Add Project Material</h4>

                    

                    <form action="{{ route('projects.material.store') }}" method="POST">
                        @csrf

                        <input type="hidden" name="project_id" value="{{ $project->id }}">

                        <div class="row">
                            <div class="col-md-3">
                                <label>Date</label>
                                <input type="date" name="entry_date" class="form-control" required>
                            </div>

                            <div class="col-md-3">
                                <label>Item Name</label>
                                <input type="text" name="item_name" class="form-control"
                                    placeholder="Camera / Wire / HDD" required>
                            </div>

                            <div class="col-md-3">
                                <label>Technician</label>
                                <select name="technician_id" class="form-control">
                                    <option value="">Select Technician</option>
                                    @foreach ($technicians as $tech)
                                        <option value="{{ $tech->id }}">
                                            {{ $tech->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-2">
                                <label>Quantity</label>
                                <input type="number" name="quantity" class="form-control" required>
                            </div>

                            <div class="col-md-1 d-flex align-items-end">
                                <button class="btn btn-success">Add</button>
                            </div>

                            <div class="col-md-12 mt-2">
                                <label>Remarks</label>
                                <textarea name="remarks" class="form-control"></textarea>
                            </div>
                        </div>
                    </form>

                    <h4>Material History</h4>

                

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Technician</th>
                                <th>Item</th>
                                <th>Qty</th>
                                <th>Remarks</th>
                                <th width="80">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($project->materialLogs as $log)
                                <tr>
                                    <td>{{ $log->entry_date }}</td>
                                    <td>{{ optional($log->technician)->name ?? '' }}</td>
                                    <td>{{ $log->item_name }}</td>
                                    <td>{{ $log->quantity }}</td>
                                    <td>{{ $log->remarks }}</td>
                                    <td class="text-center">
                                        <form action="{{ route('projects.material.destroy', $log->id) }}" method="POST"
                                            class="delete-material-form d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="ph ph-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No material history found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <a href="{{ route('projects.index') }}" class="btn btn-secondary">Back</a>
                    <a href="{{ route('projects.material.pdf', $project->id) }}" class="btn btn-primary" target="_blank">
                        Download PDF
                    </a>

                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            document.querySelectorAll('.delete-material-form').forEach(function(form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    Swal.fire({
                        title: 'Are you sure?',
                        text: 'This material entry will be permanently deleted!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, delete it',
                        cancelButtonText: 'Cancel',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });

        });
    </script>
@endsection

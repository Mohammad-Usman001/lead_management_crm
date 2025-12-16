@extends('admin.layouts.app')
@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="container">
                    <div class="d-flex justify-content-between mb-3">
                        <h3>Technicians</h3>
                        <a href="{{ route('technicians.create') }}" class="btn btn-primary">+ Add Technician</a>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <table class="table table-bordered table-hover table-responsive">
                        <thead class="table-dark table-striped">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Mobile</th>
                                <th width="180">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($technicians as $tech)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $tech->name }}</td>
                                    <td>{{ $tech->mobile ?? '-' }}</td>
                                    <td class="d-flex gap-1">
                                        <a href="{{ route('technicians.show', $tech->id) }}"
                                            class="btn btn-sm btn-success">View</a>
                                        <a href="{{ route('technicians.edit', $tech->id) }}"
                                            class="btn btn-sm btn-primary">Edit</a>
                                        <form action="{{ route('technicians.destroy', $tech->id) }}" method="POST"
                                            class="delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">No technicians found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Optional SweetAlert for Delete -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteForms = document.querySelectorAll('.delete-form');

            deleteForms.forEach(function(form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "The technician will be deleted permanently!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!',
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

@extends('admin.layouts.app')
@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="container">
                    <div class="d-flex justify-content-between mb-3">
                        <h3>Projects</h3>
                        <a href="{{ route('projects.create') }}" class="btn btn-primary">
                            + New Project
                        </a>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <table id="myTable" class="table table-bordered table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Project Name</th>
                                <th>Status</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th width="180">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($projects as $project)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $project->project_name }}</td>
                                    <td>
                                        <span class="badge bg-info">{{ $project->status }}</span>
                                    </td>
                                    <td>{{ $project->start_date ?? '-' }}</td>
                                    <td>{{ $project->end_date ?? '-' }}</td>
                                    <td class="d-flex gap-1">
                                        <a href="{{ route('projects.show', $project->id) }}" class="btn btn-sm btn-success">
                                            <i class="ph ph-eye"></i>
                                        </a>

                                        <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-sm btn-primary">
                                            <i class="ph ph-pencil"></i>
                                        </a>

                                        <form action="{{ route('projects.destroy', $project->id) }}" method="POST"
                                            class="delete-form" data-id="{{ $project->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger delete-btn">
                                                <i class="ph ph-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No projects found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>


            </div>
        </div>
    </div>
    <script>
document.addEventListener('DOMContentLoaded', function () {
    const deleteForms = document.querySelectorAll('.delete-form');

    deleteForms.forEach(function(form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault(); // prevent default form submit

            Swal.fire({
                title: 'Are you sure?',
                text: "This Project details will be permanently deleted!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // submit form if confirmed
                }
            });
        });
    });
});
</script>

@endsection

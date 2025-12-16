@extends('admin.layouts.app')
@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="container">
                    <h3 class="mb-3">Technician Details</h3>

                    <a href="{{ route('technicians.index') }}" class="btn btn-secondary mb-3">Back to List</a>

                    <table class="table table-bordered">
                        <tr>
                            <th>Name</th>
                            <td>{{ $technician->name }}</td>
                        </tr>
                        <tr>
                            <th>Mobile</th>
                            <td>{{ $technician->mobile ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Created At</th>
                            <td>{{ $technician->created_at->format('d/m/Y') }}</td>
                        </tr>
                        <tr>
                            <th>Updated At</th>
                            <td>{{ $technician->updated_at->format('d/m/Y') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

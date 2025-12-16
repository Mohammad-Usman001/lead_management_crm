@extends('admin.layouts.app')
@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="container">

                    <div class="d-flex justify-content-between mb-3">
                        <h3>Replacement Register</h3>
                        <a href="{{ route('replacements.create') }}" class="btn btn-primary">
                            + Add Replacement
                        </a>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <table id="myTable" class="table table-bordered table-hover table-responsive">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Client</th>
                                <th>Deposit Date</th>
                                <th>Replaced Date</th>
                                <th>Item </th>
                                <th>Status</th>

                                <th width="160">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($replacements as $replacement)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $replacement->client_name }}</td>
                                    <td>{{ $replacement->deposit_date }}</td>
                                    <td>{{ $replacement->replacement_date ?? '-' }}</td>
                                    <td>
                                        {{ collect($replacement->items)->pluck('item_name')->join(', ') }}
                                    </td>
                                    <td>
                                        <span
                                            class="badge {{ $replacement->status == 'Replaced' ? 'bg-success' : 'bg-warning' }}">
                                            {{ $replacement->status }}
                                        </span>
                                    </td>
                                    <td class="d-flex gap-1">
                                        <a href="{{ route('replacements.show', $replacement->id) }}"
                                            class="btn btn-sm btn-success">View</a>
                                        <a href="{{ route('replacements.edit', $replacement->id) }}"
                                            class="btn btn-sm btn-primary">Edit</a>

                                        <form action="{{ route('replacements.destroy', $replacement->id) }}" method="POST"
                                            class="delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No records found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
@endsection

@extends('admin.layouts.app')
@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="container">
                    <h3>Create Project</h3>

                    <form action="{{ route('projects.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Project Name</label>
                                <input type="text" name="project_name" class="form-control" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Status</label>
                                <select name="status" class="form-control" required>
                                    <option value="Not Started">Not Started</option>
                                    <option value="In Progress">In Progress</option>
                                    <option value="Completed">Completed</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Start Date</label>
                                <input type="date" name="start_date" class="form-control">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>End Date</label>
                                <input type="date" name="end_date" class="form-control">
                            </div>

                            <div class="col-md-12 mb-3">
                                <label>Description</label>
                                <textarea name="description" class="form-control"></textarea>
                            </div>

                            
                        </div>

                        <button class="btn btn-success">Save Project</button>
                        <a href="{{ route('projects.index') }}" class="btn btn-secondary">Back</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

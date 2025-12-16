@extends('admin.layouts.app')
@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="container">
                    <h3 class="mb-3">Edit Technician</h3>

                    <a href="{{ route('technicians.index') }}" class="btn btn-secondary mb-3">Back to List</a>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('technicians.update', $technician->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Technician Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control"
                                value="{{ old('name', $technician->name) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Mobile Number</label>
                            <input type="text" name="mobile" class="form-control"
                                value="{{ old('mobile', $technician->mobile) }}">
                        </div>

                        <button type="submit" class="btn btn-primary">Update Technician</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

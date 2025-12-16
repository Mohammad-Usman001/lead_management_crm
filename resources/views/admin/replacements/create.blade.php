@extends('admin.layouts.app')
@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="container">

                    <h3>Add Replacement Entry</h3>

                    <form action="{{ route('replacements.store') }}" method="POST">
                        @csrf

                        @include('admin.replacements.partials.form')

                        <button class="btn btn-success">Save</button>
                        <a href="{{ route('replacements.index') }}" class="btn btn-secondary">Back</a>

                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection

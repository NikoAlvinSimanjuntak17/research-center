@extends('admin.layouts.app')
@section('title', 'Create Researcher')

@section('content')
<div class="container">
    <h1>Add Department</h1>
    <form action="{{ route('admin.department.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Department Name</label>
            <input type="text" class="form-control" name="name" required>
        </div>

        <div class="mb-3">
            <label for="institution_id" class="form-label">Institution</label>
            <select name="institution_id" class="form-control" required>
                @foreach($institutions as $institution)
                    <option value="{{ $institution->id }}">{{ $institution->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-success">Save</button>
    </form>
</div>
@endsection

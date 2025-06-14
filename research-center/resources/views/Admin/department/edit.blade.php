@extends('admin.layouts.app')
@section('title', 'Edit Department')

@section('content')
<div class="container">
    <h1>Edit Department</h1>
    <form action="{{ route('admin.department.update', $department->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Department Name</label>
            <input type="text" class="form-control" name="name" value="{{ old('name', $department->name) }}" required>
            @error('name')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="institution_id" class="form-label">Institution</label>
            <select name="institution_id" class="form-control" required>
                @foreach($institutions as $institution)
                    <option value="{{ $institution->id }}"
                        {{ old('institution_id', $department->institution_id) == $institution->id ? 'selected' : '' }}>
                        {{ $institution->name }}
                    </option>
                @endforeach
            </select>
            @error('institution_id')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('admin.department.index') }}" class="btn btn-secondary ms-2">Cancel</a>
    </form>
</div>
@endsection

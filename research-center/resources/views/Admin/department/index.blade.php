@extends('admin.layouts.app')

@section('title', 'Daftar Peneliti')
@section('content')
<div class="container">
    <h1>Departments</h1>
    <a href="{{ route('admin.department.create') }}" class="btn btn-primary mb-3">Add Department</a>
    @if(session('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Institution</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($departments as $department)
                <tr>
                    <td>{{ $department->name }}</td>
                    <td>{{ $department->institution->name }}</td>
                    <td>
                        <a href="{{ route('admin.department.edit', $department) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('admin.department.destroy', $department) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Delete this department?')" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

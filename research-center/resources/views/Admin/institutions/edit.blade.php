@extends('admin.layouts.app')

@section('title', 'Edit Peneliti')

@section('content')
<div class="container mt-4">
    <h2>Edit Institusi</h2>

    <form action="{{ route('admin.institutions.update', $institution->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Nama Institusi</label>
            <input type="text" class="form-control" name="name" id="name" value="{{ $institution->name }}" required>
        </div>

        <div class="mb-3">
            <label for="address" class="form-label">Alamat</label>
            <input type="text" class="form-control" name="address" id="address" value="{{ $institution->address }}">
        </div>

        <div class="mb-3">
            <label for="website" class="form-label">Website</label>
            <input type="url" class="form-control" name="website" id="website" value="{{ $institution->website }}">
        </div>

        <button type="submit" class="btn btn-primary">Update Institusi</button>
        <a href="{{ route('admin.institutions.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection

@extends('admin.layouts.app')
@section('title', 'Create Researcher')

@section('content')
<div class="container mt-4">
    <h2>Tambah Institusi Baru</h2>

    <form action="{{ route('admin.institutions.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Nama Institusi</label>
            <input type="text" class="form-control" name="name" id="name" required>
        </div>

        <div class="mb-3">
            <label for="address" class="form-label">Alamat</label>
            <input type="text" class="form-control" name="address" id="address">
        </div>

        <div class="mb-3">
            <label for="website" class="form-label">Website</label>
            <input type="url" class="form-control" name="website" id="website">
        </div>

        <button type="submit" class="btn btn-primary">Simpan Institusi</button>
        <a href="{{ route('admin.institutions.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
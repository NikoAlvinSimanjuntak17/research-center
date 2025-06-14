@extends('admin.layouts.app')
@section('title', 'Create Researcher')
@section('content')

<!-- Basic layout -->
@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Buat Peneliti Baru</h5>
    </div>
    <div class="card-body border-top">
        <form method="POST" action="{{ route('admin.researchers.store') }}">
            @csrf
            <div class="row mb-3">
                <label class="col-lg-3 col-form-label">Name:</label>
                <div class="col-lg-9">
                    <input type="text" name="name" class="form-control" placeholder="Nama" value="{{ old('name') }}" required>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-lg-3 col-form-label">Email:</label>
                <div class="col-lg-9">
                    <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}" required>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-lg-3 col-form-label">Password:</label>
                <div class="col-lg-9">
                    <input type="password" name="password" class="form-control" placeholder="Your strong password" required>
                </div>
            </div>
            <div class="text-end">
                <button type="submit" class="btn btn-primary">Create <i class="ph-paper-plane-tilt ms-2"></i></button>
            </div>
        </form>
    </div>
</div>
<!-- /basic layout -->
@endsection
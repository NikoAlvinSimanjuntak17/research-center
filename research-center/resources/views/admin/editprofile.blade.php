@extends('layout.backend.main', ['activePage' => 'dashboard', 'titlePage' => __('Edit Profil')])
@section('title', 'Edit Profil')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Edit Profil</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Nama --}}
        <div class="form-group mt-3">
            <label>Nama</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                value="{{ old('name', $user->name) }}">
            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- Email --}}
        <div class="form-group mt-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                value="{{ old('email', $user->email) }}">
            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- Telepon --}}
        <div class="form-group mt-3">
            <label>Telepon</label>
            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                value="{{ old('phone', $user->phone) }}">
            @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- Alamat --}}
        <div class="form-group mt-3">
            <label>Alamat</label>
            <input type="text" name="address" class="form-control @error('address') is-invalid @enderror"
                value="{{ old('address', $user->address) }}">
            @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- Gambar --}}
        <div class="form-group mt-3">
            <label>Foto Profil</label><br>
            @if ($user->user_img)
                <img src="{{ asset('storage/' . $user->user_img) }}" alt="User Image" width="100" class="mb-2">
            @endif
            <input type="file" name="user_img" class="form-control-file @error('user_img') is-invalid @enderror">
            @error('user_img') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-group mt-4">
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection

@extends('admin.layouts.app')
@section('title', 'Daftar Profil Institusi')

@section('content')
    <h2 class="mb-4">Daftar Profil Institusi</h2>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Profil Terdaftar</span>
            <a href="{{ route('admin.profiles.create') }}" class="btn btn-primary btn-sm">Tambah Profil</a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Gambar</th>
                            <th>Kategori Umum (Key)</th>
                            <th>Judul Spesifik</th>
                            <th>Deskripsi Singkat</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($profiles as $profile)
                            <tr>
                                <td>{{ $profile->id }}</td>
                                <td>
                                    @if ($profile->image)
                                        <img src="{{ asset('storage/' . $profile->image) }}" alt="Gambar {{ $profile->title }}" style="width: 60px; height: auto;">
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>{{ $profile->key }}</td>
                                <td>{{ $profile->title }}</td>
                                <td>{{ \Illuminate\Support\Str::limit(strip_tags($profile->description), 60) }}</td>
                                <td>
                                    @if ($profile->active)
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-secondary">Nonaktif</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('admin.profiles.edit', $profile->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('admin.profiles.destroy', $profile->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus profil ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">Belum ada data profil yang tersedia.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

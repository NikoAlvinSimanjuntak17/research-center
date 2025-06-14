@extends('admin.layouts.app')
@section('title', 'Daftar Kontak')

@section('content')
<h2 class="mb-4">Daftar Kontak</h2>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>Kontak Terdaftar</span>
        <a href="{{ route('admin.contacts.create') }}" class="btn btn-primary btn-sm">Tambah Kontak</a>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Gambar</th>
                        <th>Key</th>
                        <th>Judul</th>
                        <th>Nilai</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($contacts as $contact)
                    <tr>
                        <td>{{ $contact->id }}</td>
                        <td>
                            @if ($contact->image)
                            <img src="{{ asset('storage/' . $contact->image) }}" alt="Gambar {{ $contact->title }}" style="width: 60px; height: auto;">
                            @else
                            <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>{{ $contact->key }}</td>
                        <td>{{ $contact->title }}</td>
                        <td>{{ $contact->value ?? '-' }}</td>
                        <td>
                            @if ($contact->active)
                            <span class="badge bg-success">Aktif</span>
                            @else
                            <span class="badge bg-secondary">Nonaktif</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('admin.contacts.show', $contact->id) }}" class="btn btn-info btn-sm">Lihat</a>
                                <a href="{{ route('admin.contacts.edit', $contact->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('admin.contacts.destroy', $contact->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kontak ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </div>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">Belum ada data kontak yang tersedia.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
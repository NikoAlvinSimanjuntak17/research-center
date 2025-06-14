@extends('admin.layouts.app')
@section('title', 'Daftar Institusi')

@section('content')
    <h2 class="mb-4">Daftar Institusi</h2>

    @if(session('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Institusi Terdaftar</span>
            <a href="{{ route('admin.institutions.create') }}" class="btn btn-primary btn-sm">Tambah Institusi</a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Nama Institusi</th>
                            <th>Alamat</th>
                            <th>Website</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($institutions as $institution)
                            <tr>
                                <td>{{ $institution->id }}</td>
                                <td>{{ $institution->name }}</td>
                                <td>{{ $institution->address }}</td>
                                <td>
                                    @if ($institution->website)
                                        <a href="{{ $institution->website }}" target="_blank" class="text-decoration-underline">{{ $institution->website }}</a>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('admin.institutions.edit', $institution->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('admin.institutions.destroy', $institution->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus institusi ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">Belum ada institusi yang terdaftar.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

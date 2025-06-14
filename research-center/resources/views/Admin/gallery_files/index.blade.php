@extends('admin.layouts.app')
@section('title', 'Galeri Gambar')

@section('content')
    <h2 class="mb-4">Daftar Gambar Galeri</h2>

     <div class="mb-4 text-end">
        <a href="{{ route('admin.gallery_files.create') }}" class="btn btn-primary">Tambah Gambar</a>
    </div>

    @foreach ($galleries as $gallery)
        <div class="mb-5 border rounded p-3 shadow-sm">
            <h4 class="mb-3">{{ $gallery->title }}</h4>

            @if ($gallery->files->count())
                <div class="row">
                    @foreach ($gallery->files as $file)
                        <div class="col-md-3 mb-3">
                            <div class="card">
                                <img src="{{ asset('storage/' . $file->image) }}" class="card-img-top" alt="..." style="height: 150px; object-fit: cover;">
                                <div class="card-body p-2">
                                    <small class="text-muted">Oleh: {{ $file->creator->name ?? 'Unknown' }}</small>
                                    <div class="d-flex justify-content-between mt-2">
                                        <a href="{{ route('admin.gallery_files.edit', $file->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                        <form action="{{ route('admin.gallery_files.destroy', $file->id) }}" method="POST" onsubmit="return confirm('Yakin ingin hapus gambar ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-muted">Belum ada gambar pada galeri ini.</p>
            @endif
        </div>
    @endforeach
@endsection

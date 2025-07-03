@extends('layout.backend.main', ['activePage' => 'gallery.index', 'titlePage' => 'Galeri'])

@section('title', 'Galeri')
@section('content')
    <h2 class="mb-4">Edit Gambar Galeri</h2>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.gallery_files.update', $galleryFile->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="gallery_id" class="form-label">Pilih Galeri</label>
                    <select class="form-select" name="gallery_id" required>
                        <option value="">-- Pilih Galeri --</option>
                        @foreach ($galleries as $gallery)
                            <option value="{{ $gallery->id }}" {{ $galleryFile->gallery_id == $gallery->id ? 'selected' : '' }}>
                                {{ $gallery->title }}
                            </option>
                        @endforeach
                    </select>
                    @error('gallery_id') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Gambar Saat Ini</label><br>
                    <img src="{{ asset('storage/' . $galleryFile->image) }}" alt="Gambar Galeri" class="img-thumbnail" style="max-height: 200px;">
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Ganti Gambar (opsional)</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                    @error('image') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.gallery_files.index') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-primary">Perbarui</button>
                </div>
            </form>
        </div>
    </div>
@endsection

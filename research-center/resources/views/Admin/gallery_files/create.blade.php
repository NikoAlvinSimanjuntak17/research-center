@extends('admin.layouts.app')
@section('title', 'Tambah Gambar Galeri')

@section('content')
    <h2 class="mb-4">Tambah Gambar ke Galeri</h2>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.gallery_files.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="gallery_id" class="form-label">Pilih Galeri</label>
                    <select class="form-select" name="gallery_id" required>
                        <option value="">-- Pilih Galeri --</option>
                        @foreach ($galleries as $gallery)
                            <option value="{{ $gallery->id }}" {{ old('gallery_id') == $gallery->id ? 'selected' : '' }}>
                                {{ $gallery->title }}
                            </option>
                        @endforeach
                    </select>
                    @error('gallery_id') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="mb-3">
                    <label for="images" class="form-label">Unggah Gambar</label>
                    <input type="file" name="images[]" class="form-control" accept="image/*" multiple required>
                    <small class="text-muted">Bisa unggah lebih dari satu gambar.</small>
                    @error('images') <small class="text-danger d-block">{{ $message }}</small> @enderror
                    @if ($errors->has('images.*'))
                        @foreach ($errors->get('images.*') as $error)
                            <small class="text-danger d-block">{{ $error[0] }}</small>
                        @endforeach
                    @endif
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.gallery_files.index') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection

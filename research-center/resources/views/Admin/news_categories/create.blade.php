@extends('admin.layouts.app')
@section('title', 'Tambah Kategori Berita')

@section('content')
    <h2 class="mb-4">Tambah Kategori Berita</h2>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.news_categories.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">Nama Kategori</label>
                    <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                    @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="mb-3">
                    <label for="active" class="form-label">Status</label>
                    <select class="form-select" name="active" required>
                        <option value="1" {{ old('active', '1') == '1' ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ old('active') == '0' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                    @error('active') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.news_categories.index') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection

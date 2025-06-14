@extends('admin.layouts.app')
@section('title', 'Edit Kontak')

@section('content')
    <h2 class="mb-4">Edit Kontak</h2>

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
        <div class="card-body">
            <form action="{{ route('admin.contacts.update', $contact->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Key --}}
                <div class="mb-3">
                    <label for="key" class="form-label">Key</label>
                    <input type="text" name="key" id="key" class="form-control"
                           value="{{ old('key', $contact->key) }}" required>
                    @error('key') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                {{-- Judul --}}
                <div class="mb-3">
                    <label for="title" class="form-label">Judul</label>
                    <input type="text" name="title" id="title" class="form-control"
                           value="{{ old('title', $contact->title) }}" required>
                    @error('title') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                {{-- Nilai Kontak --}}
                <div class="mb-3">
                    <label for="value" class="form-label">Isi Kontak</label>
                    <input type="text" name="value" id="value" class="form-control"
                           value="{{ old('value', $contact->value) }}">
                    @error('value') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                {{-- Gambar --}}
                <div class="mb-3">
                    <label for="image" class="form-label">Gambar (Opsional)</label>
                    @if ($contact->image)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $contact->image) }}" alt="Gambar" style="width: 100px;">
                        </div>
                    @endif
                    <input type="file" name="image" id="image" class="form-control" accept="image/*">
                    @error('image') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                {{-- Status --}}
                <div class="mb-3">
                    <label for="active" class="form-label">Status</label>
                    <select name="active" id="active" class="form-select">
                        <option value="1" {{ old('active', $contact->active) == '1' ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ old('active', $contact->active) == '0' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                    @error('active') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.contacts.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Perbarui</button>
                </div>
            </form>
        </div>
    </div>
@endsection

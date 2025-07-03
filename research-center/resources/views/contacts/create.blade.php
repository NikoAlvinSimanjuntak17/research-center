@extends('layout.backend.main', ['activePage' => 'contact.create', 'titlePage' => __('Tambah Kontak')])
@section('title', 'Tambah Kontak')

@section('content')
<h2 class="mb-4">Tambah Kontak</h2>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card">
    <div class="card-body">
        <form action="{{ route('contact.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Key --}}
            <div class="mb-3">
                <label for="key" class="form-label">Key</label>
                <select class="form-select" name="key" id="key" required>
                    @foreach($existingKeys as $existingKey)
                        <option value="{{ $existingKey }}" {{ old('key') == $existingKey ? 'selected' : '' }}>
                            {{ $existingKey }}
                        </option>
                    @endforeach
                    @if(old('key') && !$existingKeys->contains(old('key')))
                        <option value="{{ old('key') }}" selected>{{ old('key') }}</option>
                    @endif
                </select>
                @error('key') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            {{-- Judul --}}
            <div class="mb-3">
                <label for="title" class="form-label">Judul</label>
                <input type="text" name="title" id="title" class="form-control"
                       value="{{ old('title') }}" required>
                @error('title') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            {{-- Nilai --}}
            <div class="mb-3">
                <label for="value" class="form-label">Isi Kontak</label>
                <input type="text" name="value" id="value" class="form-control"
                       value="{{ old('value') }}">
                @error('value') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            {{-- Gambar --}}
            <div class="mb-3">
                <label for="image" class="form-label">Gambar (Opsional)</label>
                <input type="file" name="image" id="image" class="form-control" accept="image/*">
                @error('image') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            {{-- Status --}}
            <div class="mb-3">
                <label for="active" class="form-label">Status</label>
                <select name="active" id="active" class="form-select">
                    <option value="1" {{ old('active', '1') == '1' ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ old('active') == '0' ? 'selected' : '' }}>Nonaktif</option>
                </select>
                @error('active') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            {{-- Tombol --}}
            <div class="d-flex justify-content-between">
                <a href="{{ route('contact.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-success">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function () {
        $('#key').select2({
            tags: true,
            placeholder: 'Pilih atau ketik key baru...',
            allowClear: true,
            width: '100%'
        });
    });
</script>
@endpush

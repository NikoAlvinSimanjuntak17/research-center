@extends('layout.backend.main', ['activePage' => 'contact.edit', 'titlePage' => __('Edit Kontak')])
@section('title', 'Edit Kontak')

@section('content')
<h2 class="mb-4">Edit Kontak</h2>

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
        <form action="{{ route('contact.update', $contact->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Key --}}
            <div class="mb-3">
                <label for="key" class="form-label">Key</label>
                <select class="form-select" name="key" id="key" required>
                    @foreach($existingKeys as $existingKey)
                        <option value="{{ $existingKey }}" {{ old('key', $contact->key) == $existingKey ? 'selected' : '' }}>
                            {{ $existingKey }}
                        </option>
                    @endforeach
                    @if(old('key', $contact->key) && !$existingKeys->contains(old('key', $contact->key)))
                        <option value="{{ old('key', $contact->key) }}" selected>{{ old('key', $contact->key) }}</option>
                    @endif
                </select>
                @error('key') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            {{-- Judul --}}
            <div class="mb-3">
                <label for="title" class="form-label">Judul</label>
                <input type="text" name="title" id="title" class="form-control"
                       value="{{ old('title', $contact->title) }}" required>
                @error('title') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            {{-- Nilai --}}
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

            {{-- Tombol --}}
            <div class="d-flex justify-content-between">
                <a href="{{ route('contact.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Perbarui</button>
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
